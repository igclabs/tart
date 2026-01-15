# TART - Quick Reference Card

> Install with `composer require igclabs/tart` and extend either `IGC\Tart\Laravel\StyledCommand` or `IGC\Tart\Symfony\StyledCommand`.

## 💬 Interactive Input (NEW!)

```php
// Text input with default
$name = $this->prompt('What is your name?', 'Anonymous');

// With validation
$email = $this->prompt('Email?', null, function($value) {
    return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
});

// Hidden password input
$password = $this->password('Enter password');
```

## 🧭 Interactive Menus (NEW!)

```php
// Single-select menu
$choice = $this->menu('Pick a deployment target', [
    'Staging',
    'Production',
]);

// Checkbox menu (multi-select)
$selected = $this->checkboxMenu('Select features', [
    'Spinners',
    'Progress bars',
    'Tables',
]);

// Radio menu (single-select)
$theme = $this->radioMenu('Choose a theme', [
    'Default',
    'Success',
    'Error',
]);
```

## 📝 Lists (NEW!)

```php
// Bullet list
$this->bulletList(['Item 1', 'Item 2', 'Item 3']);

// Nested list
$this->bulletList([
    'Item 1',
    'Nested' => ['Sub A', 'Sub B'],
]);

// Ordered/numbered list
$this->orderedList(['Step 1', 'Step 2', 'Step 3']);

// Task list with checkmarks
$this->taskList([
    '✓ Completed task',
    '✗ Failed task',
    '• Pending task',
]);
```

## 📊 Tables (NEW!)

```php
$this->renderTable(
    ['Name', 'Status', 'Count'],
    [
        ['Database', 'Online', '127'],
        ['API', 'Online', '89'],
        ['Cache', 'Degraded', '42'],
    ]
);
```

## 🔄 Progress Bars (NEW!)

```php
// With callback
$this->progressBar(100, 'Processing', function($bar) {
    foreach ($items as $item) {
        // ... process item ...
        $bar->advance();
    }
});

// Manual control
$bar = $this->progressBar(100, 'Uploading');
$bar->advance(10);
$bar->advance(25);
$bar->finish();
```

## ⏳ Spinners (NEW!)

```php
// Simple spinner
$spinner = $this->spinner('Loading data...');
$spinner->start();
// ... do work ...
$spinner->stop('Done!');

// Different styles: dots, dots2, dots3, line, arrow, pulse, bounce
$spinner->setStyle('pulse');
```

## 📝 Basic Output

```php
$this->say('Regular message');           // White text
$this->good('Success message');          // Green text
$this->bad('Error message');             // Red text  
$this->state('Status message');          // Yellow text
$this->cool('Info message');             // Cyan text
```

## 📦 Block Messages

```php
$this->header('Title');                  // Large header with decoration
$this->title('Section');                 // Section title block
$this->success('Success!');              // Green success block
$this->notice('Info');                   // Cyan notice block
$this->warning('Warning!');              // Red warning block
$this->failure('Error!');                // White on red error block
$this->stat('Time: 2.5s');              // Black on blue stat block
$this->footer('Name', 'Optional time'); // Footer block
```

## 📐 Layout

```php
$this->br();                            // One blank line
$this->br(3);                           // Three blank lines
$this->hr();                            // Horizontal rule
```

## 📊 Line Building

```php
// Simple progressive line
$this->openLine('Processing');
$this->appendLine('...', 'yellow');
$this->appendLine(' Done!', 'green');
$this->closeLine();

// Column-based output (tables)
$this->openLine('Label');
$this->addColumn('Value 1', 20, 'white');
$this->addColumn('Value 2', 15, 'green');
$this->closeLine();
```

## 🎨 Themes

```php
use IGC\Tart\Themes\{DefaultTheme, SuccessTheme, ErrorTheme, Theme};

// Use built-in theme
$this->setTheme(new SuccessTheme());

// Create custom theme
$theme = new Theme(
    color: 'magenta',
    textColor: 'white',
    highlightColor: 'yellow',
    maxLineWidth: 80
);
$this->setTheme($theme);

// Get current theme
$currentTheme = $this->getTheme();
```

### Built-in Themes

| Theme | Color | Best For |
|-------|-------|----------|
| `DefaultTheme` | Blue | General use |
| `SuccessTheme` | Green | Success operations |
| `ErrorTheme` | Red | Error handling |

## 🖼️ Logos & Art

```php
// See LOGO-CREATION.md for complete logo documentation
$this->displayTextLogo('MY APP');                           // Simple text logo
$this->displayTextLogo('MY APP', 'box');                   // Boxed logo
$this->displayTextLogo('MY APP', 'banner');                // Banner logo
$this->displayAsciiLogo($asciiArt);                        // Custom ASCII art
```

## 🎯 Utilities

```php
// Path highlighting
$path = '/var/www/app/file.php';
$this->say($this->pathHighlight($path));

// Interactive confirmation
if ($this->confirm('Continue?', true)) {
    // User confirmed (or default used)
}

// Auto-answer mode (non-interactive)
$this->autoAnswer = true;
$result = $this->confirm('Auto?', true);  // Returns true without prompting

// Display built-in demo (great for testing and showcasing)
$this->demo();                           // Shows all common TART features
$this->demoText();                       // Shows all text style variations
```

## 🎨 Color Helpers (Protected Methods)

```php
// Use in custom implementations
$this->color('text', 'red', 'white');    // Background + foreground
$this->bg('text', 'blue');               // Background only
$this->fg('text', 'green');              // Foreground only
$this->bold('text');                     // Bold text
```

## 📋 Complete Example

```php
<?php

namespace App\Console\Commands;

use IGC\Tart\Laravel\StyledCommand;
use IGC\Tart\Themes\SuccessTheme;

class MyCommand extends StyledCommand
{
    protected $signature = 'my:command';
    protected $description = 'Example command';

    public function handle()
    {
        // Start with header
        $this->header('Data Processing');
        
        // Basic output
        $this->say('Starting process...');
        $this->br();
        
        // Process items with progress
        $items = ['Users', 'Posts', 'Comments'];
        foreach ($items as $item) {
            $this->openLine("Processing {$item}");
            // ... do work ...
            $this->appendLine(' Done!', 'green');
            $this->closeLine();
        }
        
        // Show results
        $this->br();
        $this->good('✓ All items processed');
        
        // Theme switch for success
        $this->setTheme(new SuccessTheme());
        $this->success('Operation Completed Successfully!');
        
        // Footer with timing
        $this->footer('Processing', 'Completed in 2.5s');
        
        return self::SUCCESS;
    }
}
```

## 💻 Examples

Check out the complete working examples:

```bash
# Quick demo
cat examples/demo-command.php

# Comprehensive demo with all features
cat examples/comprehensive-demo.php

# Real-world Laravel example
cat examples/laravel-example.php
```

Or call the built-in demo directly in any command:

```php
public function handle()
{
    $this->demo();  // Displays comprehensive feature showcase
    return self::SUCCESS;
}
```

## 🎨 Available Colors

- `black`
- `red`
- `green`
- `yellow`
- `blue`
- `magenta`
- `cyan`
- `white`

## 💡 Tips

1. **Use `good()` for success** - More concise than `success()` block
2. **Build lines progressively** - Great for showing progress
3. **Theme per operation type** - Switch themes for different operations
4. **Auto-answer for scripts** - Set `$this->autoAnswer = true` for cron jobs
5. **Path highlighting** - Makes file paths easy to read
6. **Call `demo()` to test** - Built-in demo shows all features in action

## 📚 More Info

- **Getting Started**: [docs/GETTING-STARTED.md](../GETTING-STARTED.md)
- **Logo Creation**: [docs/guides/LOGO-CREATION.md](LOGO-CREATION.md)
- **Examples**: [examples/laravel-example.php](../../examples/laravel-example.php)

---

**Quick Start:** Extend `StyledCommand` and use any method above!
