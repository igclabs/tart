# TUI Frame Design Spec

## Purpose
TART’s TUI output is designed as a **framed canvas**: every rendered line sits inside a themed border that wraps a content area. The border is visually expressed as two solid color blocks (left/right), and the content is flanked by two padding blocks that create breathing room between the border and the text. This document explains the layout contract, the data flow that builds each line, and the technical considerations for expanding features without breaking the framing rules.

## Core Layout Model
Every “rendered line” is composed in the same order:

```
[LEFT BORDER] [LEFT PADDING] [CONTENT AREA] [RIGHT PADDING] [RIGHT BORDER]
```

### Border blocks
* The border color comes from the active theme’s primary color (`theme->getColor()`). The border blocks are implemented as background-colored “gaps.” The default gap width is two spaces, and it is doubled when padding is disabled to keep a visible border.【F:src/Concerns/HasColoredOutput.php†L13-L40】
* The border is symmetrical; the same gap block is rendered on both the left and right sides of the line.【F:src/Concerns/HasColoredOutput.php†L13-L40】

### Padding blocks
* Padding is emitted on both sides of the content. The default pad width is two spaces (`"  "`), but it can be set to an empty string in specialized rendering modes. The padding sits *inside* the border and *outside* the content area, maintaining the framed look.【F:src/Concerns/HasColoredOutput.php†L13-L40】

### Content area
* The content area is padded to the theme’s `maxLineWidth` using `LineFormatter::pad()`, which is visual-length aware (strips ANSI/formatting tags and counts multi-byte characters). This guarantees that the frame’s inner width is stable for all lines regardless of content length or styling tags.【F:src/Support/LineFormatter.php†L11-L58】

## Rendering Pipeline (Single-Line Output)
1. **Prepare content**: `LineFormatter::pad()` extends (or trims) content to `theme->getMaxLineWidth()` so the inner content width is fixed.【F:src/Support/LineFormatter.php†L22-L58】
2. **Assemble frame**: `prepLine()` wraps the padded line with the two border blocks and two padding blocks, then applies text color for the content area and border color for the gaps.【F:src/Concerns/HasColoredOutput.php†L13-L40】
3. **Output**: `bline()` emits the prepared line, ensuring active line state is closed if needed.【F:src/Concerns/HasColoredOutput.php†L63-L74】

### Multi-line output
* Multi-line renderers (e.g., `bad()`) chunk text to fit the content width, then emit each line through the same framing pipeline so the border and padding are always present and aligned.【F:src/Concerns/HasColoredOutput.php†L118-L140】

## Blocks & Framed Titles
The framed layout is also used to render block-style messages (title, success, notice, warning, etc.). The `block()` method shows how these blocks align to the same frame:

* `blockLine()` fills the content area with a repeated character and still uses the same `bline()` method, which preserves the frame around the line.【F:src/Concerns/HasBlocks.php†L39-L52】
* `block()` centers the message within `maxLineWidth`, applies a background color to the content area, and places a “cap” line above and below to close the block visually.【F:src/Concerns/HasBlocks.php†L12-L37】

This means blocks are **not separate renderers**; they are frame-compliant decorations on top of the standard line format.

## Theme & Configuration Contract
The frame depends on a theme that specifies:

* `color`: border color (background used in the left/right gaps).【F:src/Themes/Theme.php†L15-L47】
* `textColor`: default content color.【F:src/Themes/Theme.php†L15-L47】
* `highlightColor`: accent color for block caps and special blocks.【F:src/Themes/Theme.php†L15-L47】
* `maxLineWidth`: width of the content area (not including border/padding).【F:src/Themes/Theme.php†L15-L47】
* `colors`: palette used for decorative blocks and logos.【F:src/Themes/Theme.php†L15-L47】

The theme is loaded at runtime and can be overridden through configuration or a custom theme class, allowing applications to adjust the border color and content width without modifying framing behavior.【F:src/Concerns/InteractsWithStyling.php†L15-L70】

## Visual Decoration Around the Frame
Logo and banner output uses the same content-width model. These helpers produce lines that are padded to the theme width and can include colored block decoration lines above/below the logo.

* `AsciiArt::createLogo()` inserts header/footer color blocks and padding lines within a fixed width, matching the frame’s content width expectations.【F:src/Support/AsciiArt.php†L12-L85】
* Decorative block lines are built from repeated background-colored blocks, providing a visual “plate” that aligns with the framed content width.【F:src/Support/AsciiArt.php†L71-L85】

## Extension Guidelines
When adding new features, maintain the frame contract by adhering to these rules:

1. **Never bypass `bline()` for visible output.** All lines should be routed through `bline()` (or a method that uses it) to ensure the border, padding, and alignment stay intact.【F:src/Concerns/HasColoredOutput.php†L63-L74】
2. **Respect `maxLineWidth`.** Any renderer should pad, trim, or wrap content to `theme->getMaxLineWidth()` using `LineFormatter::pad()` or `LineFormatter::center()` before framing.【F:src/Support/LineFormatter.php†L22-L58】
3. **Align custom block styles to the frame.** If you add a new block type (e.g., “info”, “tip”), implement it with `block()` or `blockLine()` so the visual geometry stays consistent.【F:src/Concerns/HasBlocks.php†L12-L52】
4. **Border is theme-owned.** Do not hardcode border colors—always pull from `theme->getColor()` so the left/right blocks remain consistent across themes.【F:src/Concerns/HasColoredOutput.php†L13-L40】
5. **Padding is structural.** The padding blocks are part of the frame geometry; if you remove padding for a special layout, ensure the border “gap” doubles as defined in `prepLine()` so the border still reads visually.【F:src/Concerns/HasColoredOutput.php†L13-L40】

## Plan: Frame Interactive Inputs (Text, Selects, Radios, Multi-Select)
Interactive inputs currently bypass the frame and, in some cases, clear the entire screen. The goal is to keep input UIs *within* the framed canvas so they feel like any other TART output.

### Current behaviors that break the frame
* **Interactive menus** (`InteractiveMenu`) call `TerminalControl::clearScreenAndHome()` and render unframed lines directly to the output.【F:src/Support/InteractiveMenu.php†L211-L235】
* **Select and multi-select** (`Select`, `MultiSelect`) write raw lines and use cursor motion to repaint without the TART frame wrapper.【F:src/Support/Select.php†L63-L133】【F:src/Support/MultiSelect.php†L54-L150】
* **Text prompts** (`HasEnhancedInput`) write plain prompt strings, which do not include left/right border blocks or inner padding.【F:src/Concerns/HasEnhancedInput.php†L21-L75】

### Step-by-step implementation plan
1. **Introduce a shared framed input renderer.** Create a small helper that builds framed lines using the same `prepLine()` / `finishLine()` model and accepts a “content line” plus optional highlight styles. This helper should accept a fixed `maxLineWidth` and never call clear-screen directly; it should rely on cursor movement to update only the framed area. (Implementation should live near other formatting helpers, e.g., a new class in `src/Support/`.)
2. **Replace screen-clearing with frame-scoped redraws.** Update `InteractiveMenu::render()` to:\n   * Draw a framed title line (or blank framed line if no title).\n   * Render each menu row through the framed renderer, applying highlight colors to the content area only.\n   * Track how many framed lines were drawn so the cursor can move back up *within the frame* on the next repaint, instead of calling `clearScreenAndHome()`.【F:src/Support/InteractiveMenu.php†L211-L235】
3. **Unify select + multi-select rendering.** Refactor `Select` and `MultiSelect` to use the same framed renderer and cursor movement conventions as the updated menu. This ensures checkboxes/radios are always visible inside the border and padding blocks. The current update logic already uses cursor movement; only the line composition needs to be framed.【F:src/Support/Select.php†L94-L133】【F:src/Support/MultiSelect.php†L120-L150】
4. **Frame text prompts.** Update `prompt()` / `password()` to render a framed prompt line and capture input on the same line. If raw-mode input is introduced later (see `docs/feature-todo.md`), ensure the editing cursor stays within the content width and the border remains intact.【F:src/Concerns/HasEnhancedInput.php†L21-L75】
5. **Theme alignment.** Ensure input highlights draw using theme colors (e.g., use `theme->getHighlightColor()` and `theme->getTextColor()` where possible) so inputs match blocks and titles. Consider exposing highlight settings on the input classes to reuse existing theme config.
6. **Accessibility & resilience.** Keep non-interactive fallbacks untouched (e.g., when `stream_isatty` fails), but render the resulting confirmations via `bline()` so they match the frame when possible.【F:src/Support/Select.php†L36-L88】【F:src/Support/MultiSelect.php†L36-L73】

### Acceptance criteria
* All interactive inputs render inside the left/right border blocks and inner padding, without clearing the full terminal screen.
* The number of lines redrawn during selection changes is limited to the input’s framed region.
* Visual alignment is stable for long labels, emojis, and ANSI tags by reusing `LineFormatter::pad()` or equivalent visual-length aware padding.

## Future Feature Ideas (Frame-Compatible)
* **Side badges**: Add an optional badge segment inside the padding area, but keep border color and overall width fixed.
* **Segmented borders**: Alternate the left/right border colors for status lines, still using the same gap width.
* **Inline panels**: Use `block()` with custom backgrounds to create sub-panels while keeping the outer frame intact.

---

This spec is intended to keep every feature aligned with TART’s central design idea: a stable, theme-driven TUI frame that uses two solid-color borders and two inner padding blocks to surround every line of content.
