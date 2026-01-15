# TUI Feature Research TODOs

## Interactive Menus & Navigable Lists
- [x] Prototype a raw-mode input loop that detects arrow key escape sequences (ESC [ A/B/C/D) and Enter to select the highlighted item.
- [x] Implement a menu renderer that highlights the focused item (e.g., inverse colors or a leading `>` marker) and supports redrawing on selection changes.
- [x] Add cursor hide/show and safe terminal cleanup to avoid leaving the cursor hidden after menu exit.
- [x] Evaluate redraw strategies: full-screen clear (`\033[H\033[2J`) vs. partial updates with cursor movement to reduce flicker.

## Multiple-Choice Inputs (Checkbox/Radio)
- [x] Extend the menu loop to toggle checkboxes via Space/Enter and render markers like `[x]` / `[ ]`.
- [x] Implement radio-style selection (single choice) where selecting one item clears the previous choice.
- [x] Store selection state in an array of booleans (checkbox) or a single index (radio) and expose selected values.

## Text Input Fields
- [ ] Decide between readline-based prompts (simple) vs. raw-mode character capture for embedded inputs.
- [ ] Prototype raw-mode text input with Backspace handling (support ASCII 127 and 8) and optional masking for passwords.
- [ ] Ensure terminal settings are restored after input (save `stty -g`, restore on exit).

## Keyboard Input Handling
- [x] Build a small key parser for escape sequences (arrows, escape, enter) with optional timeout logic for lone ESC.
- [x] Add `stream_select()` support to allow non-blocking reads for animations/spinners during input loops.
- [ ] Document key mappings and supported terminals (ANSI/VT100 assumptions).

## Cursor & Screen Control
- [x] Create helpers for cursor movement (`ESC[<row>;<col>H`, `ESC[<n>A/B/C/D`), line clearing (`ESC[K`), and full-screen clear.
- [x] Add cursor hide/show helpers (`ESC[?25l` / `ESC[?25h`) and use them during redraws.
- [ ] Explore buffer-based redraws (compose full screen in a string, output once) to minimize flicker.

## Text Formatting Beyond Colors
- [x] Add support for bold/underline/reverse video SGR codes and a reset helper (`ESC[0m`).
- [ ] Consider 256-color or truecolor extensions for richer themes where terminals support it.

## Library Ecosystem Evaluation
- [ ] Review php-school/cli-menu for menu and checkbox patterns that can inform API design.
- [ ] Evaluate php-tui/php-tui terminal/event handling patterns for raw mode and event parsing.
- [ ] Decide whether to depend on external libraries or keep a minimal internal implementation.

## Integration & UX
- [x] Define a public API for menus, checkbox lists, and text inputs that fits TART’s fluent style.
- [x] Add safeguards to prevent leaving the terminal in raw mode after exceptions (try/finally wrapper).
- [ ] Provide Laravel/Symfony usage examples once core components are stable.
