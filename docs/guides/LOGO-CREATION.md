# Automatic Logo Creation

TART includes a powerful system for creating beautiful ASCII art logos with automatic header and footer decorations!

## 🎨 Features

- ✅ **Automatic Decoration** - Header and footer color blocks
- ✅ **Multiple Styles** - Text, boxed, banner, and custom ASCII art
- ✅ **Customizable Colors** - Choose your color scheme
- ✅ **Smart Padding** - Automatic centering and spacing
- ✅ **Easy API** - Simple methods for quick logo creation

## Quick Start

### Simple Text Logo

```php
$this->displayTextLogo('MY APP');
```

Outputs with automatic colorful header/footer decoration!

### Boxed Logo

```php
$this->displayTextLogo('DEPLOYMENT SYSTEM', 'box', [
    'text_color' => 'green',
]);
```

### Banner Logo

```php
$this->displayTextLogo('BUILD COMPLETE', 'banner', [
    'text_color' => 'cyan',
]);
```

### Custom ASCII Art

```php
$asciiArt = <<<'ASCII'
  ____  ____   ___  _____  ____ 
 |  _ \|  _ \ / _ \|  ___/ ___| 
 | |_) | |_) | | | | |_  \___ \ 
 |  __/|  _ <| |_| |  _|  ___) |
 |_|   |_| \_\\___/|_|   |____/ 
ASCII;

$this->displayAsciiLogo($asciiArt);
```

## API Reference

### displayTextLogo()

Display a text logo with automatic decoration.

```php
public function displayTextLogo(
    string $text,
    string $style = 'standard',  // 'standard', 'box', or 'banner'
    array $options = []
): void
```

**Options:**
- `text_color` - Color for the text (default: 'white')
- `colors` - Array of colors for decoration (default: ['red', 'green', 'yellow', 'cyan', 'white'])
- `width` - Width of the logo area (default: theme width)
- `header_lines` - Number of header decoration lines (default: 3)
- `footer_lines` - Number of footer decoration lines (default: 3)

**Examples:**

```php
// Standard style
$this->displayTextLogo('MY APPLICATION');

// Boxed style with custom colors
$this->displayTextLogo('ERROR HANDLER', 'box', [
    'text_color' => 'red',
    'colors' => ['red', 'yellow'],
]);

// Banner style
$this->displayTextLogo('DEPLOYMENT', 'banner', [
    'text_color' => 'green',
    'colors' => ['green', 'cyan'],
]);
```

### displayAsciiLogo()

Display multi-line ASCII art with automatic decoration.

```php
public function displayAsciiLogo(
    string $asciiArt,
    array $options = []
): void
```

**Options:**
- `colors` - Array of colors for decoration
- `width` - Width of the logo area
- `header_lines` - Number of header decoration lines
- `footer_lines` - Number of footer decoration lines
- `padding_top` - Blank lines before logo
- `padding_bottom` - Blank lines after logo

**Examples:**

```php
$logo = <<<'ASCII'
 ___  ____  ____  
|__ \|___ \|___ \ 
   ) | __) | __) |
  / / / __/ / __/ 
 |_| |_____|_____|
ASCII;

$this->displayAsciiLogo($logo, [
    'colors' => ['cyan', 'blue', 'white'],
    'header_lines' => 2,
    'footer_lines' => 2,
]);
```

### displayCustomLogo()

Display custom logo lines with full control.

```php
public function displayCustomLogo(
    array $lines,
    array $options = []
): void
```

**Examples:**

```php
$lines = [
    '<fg=cyan>╔═══════════════╗</fg=cyan>',
    '<fg=cyan>║</fg=cyan> <options=bold>MY COMPANY</options=bold> <fg=cyan>║</fg=cyan>',
    '<fg=cyan>╚═══════════════╝</fg=cyan>',
];

$this->displayCustomLogo($lines, [
    'colors' => ['cyan', 'white'],
]);
```

## Logo Styles

### 1. Standard Style

Simple text with decoration:

```php
$this->displayTextLogo('APPLICATION NAME', 'standard');
```

```
[colorful decoration]

        APPLICATION NAME        

[colorful decoration]
```

### 2. Box Style

Text in a decorative box:

```php
$this->displayTextLogo('BOXED TEXT', 'box');
```

```
[colorful decoration]

   ╔═══════════╗
   ║ BOXED TEXT ║
   ╚═══════════╝

[colorful decoration]
```

### 3. Banner Style

Text with separators:

```php
$this->displayTextLogo('BANNER TEXT', 'banner');
```

```
[colorful decoration]
━━━━━━━━━━━━━━━━━━━━━━
    BANNER TEXT    
━━━━━━━━━━━━━━━━━━━━━━
[colorful decoration]
```

### 4. ASCII Art Style

Full multi-line ASCII art:

```php
$this->displayAsciiLogo($yourAsciiArt);
```

## Advanced Usage

### Custom Color Schemes

```php
// Success theme
$this->displayTextLogo('SUCCESS', 'box', [
    'text_color' => 'green',
    'colors' => ['green', 'cyan', 'white'],
]);

// Error theme
$this->displayTextLogo('ERROR', 'box', [
    'text_color' => 'red',
    'colors' => ['red', 'yellow', 'white'],
]);

// Cool theme
$this->displayTextLogo('INFO', 'banner', [
    'text_color' => 'cyan',
    'colors' => ['blue', 'cyan', 'magenta'],
]);
```

### Adjusting Decoration

```php
// More decoration
$this->displayTextLogo('BIG LOGO', 'standard', [
    'header_lines' => 5,
    'footer_lines' => 5,
]);

// Minimal decoration
$this->displayTextLogo('MINIMAL', 'banner', [
    'header_lines' => 1,
    'footer_lines' => 1,
]);

// No decoration (just the text)
$this->displayTextLogo('CLEAN', 'standard', [
    'header_lines' => 0,
    'footer_lines' => 0,
]);
```

### Custom Width

```php
$this->displayTextLogo('WIDE LOGO', 'box', [
    'width' => 100,  // Wider logo area
]);
```

## Using AsciiArt Class Directly

For more control, use the `AsciiArt` class directly:

```php
use IGC\Tart\Support\AsciiArt;

// Create logo lines
$lines = AsciiArt::createTextLogo('MY APP', [
    'style' => 'box',
    'text_color' => 'cyan',
]);

// Output them
foreach ($lines as $line) {
    $this->line($line);
}
```

### Available AsciiArt Methods

```php
// Create text logo
AsciiArt::createTextLogo($text, $options);

// Create multi-line logo
AsciiArt::createMultiLineLogo($asciiArt, $options);

// Create custom logo
AsciiArt::createLogo($lines, $options);

// Create gradient decoration
AsciiArt::createGradientBlocks($lines, $colors);

// Create pattern decoration
AsciiArt::createPatternDecoration($lines, $pattern, $color, $width);
```

## ASCII Art Resources

### Generators

Use these online tools to create ASCII art:
- **patorjk.com/software/taag** - Text to ASCII Art Generator
- **ascii-generator.site** - Image to ASCII converter
- **ascii-art-generator.org** - Various generators

### Example ASCII Art

```php
// Big letters
$logo = <<<'ASCII'
 ___  ___  ___  
|_ _||_ _||_ _| 
 | |  | |  | |  
|___||___||___|
ASCII;

// Block letters
$logo = <<<'ASCII'
█▀▀ █▀█ █▀█ █
█▄▄ █▄█ █▄█ █▄▄
ASCII;

// Simple
$logo = <<<'ASCII'
     _____
    |_____|
      | |
      |_|
ASCII;
```

## Best Practices

### ✓ Do

```php
// Keep it simple
$this->displayTextLogo('APP NAME', 'box');

// Match theme colors
$this->displayTextLogo('SUCCESS', 'box', [
    'colors' => ['green', 'cyan'],
]);

// Use appropriate style for context
$this->displayTextLogo('WARNING', 'banner', [
    'text_color' => 'yellow',
]);
```

### ✗ Don't

```php
// Too many decoration lines (cluttered)
$this->displayTextLogo('TEXT', 'box', [
    'header_lines' => 10,
    'footer_lines' => 10,
]);

// Too many colors (chaotic)
$this->displayTextLogo('TEXT', 'standard', [
    'colors' => ['red', 'green', 'blue', 'yellow', 'magenta', 'cyan', 'white'],
]);
```

## Complete Example

```php
<?php

namespace App\Console\Commands;

use IGC\Tart\Laravel\StyledCommand;

class MyBrandedCommand extends StyledCommand
{
    protected $signature = 'my:command';
    
    public function handle()
    {
        // Display company logo
        $this->displayTextLogo('PROFSS PLATFORM', 'box', [
            'text_color' => 'cyan',
            'colors' => ['blue', 'cyan', 'white'],
        ]);
        
        $this->br();
        
        // Run command logic
        $this->say('Processing data...');
        
        // ... your code ...
        
        // Success message
        $this->displayTextLogo('COMPLETE', 'banner', [
            'text_color' => 'green',
            'colors' => ['green', 'cyan'],
            'header_lines' => 1,
            'footer_lines' => 1,
        ]);
        
        return self::SUCCESS;
    }
}
```

## Examples

Check out the working example to see logo creation in action:

```bash
# View the complete example
cat examples/laravel-example.php
```

## Summary

| Method | Best For | Example |
|--------|----------|---------|
| `displayTextLogo('text', 'standard')` | Application branding | App startup |
| `displayTextLogo('text', 'box')` | Emphasis | Important sections |
| `displayTextLogo('text', 'banner')` | Separators | Between sections |
| `displayAsciiLogo($art)` | Custom branding | Detailed logos |
| `displayCustomLogo($lines)` | Full control | Complex designs |

---

**Create beautiful branded CLI applications with automatic logo decoration!** 🎨✨

