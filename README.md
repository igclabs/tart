# TART 🎨

<p align="center">
  <img src="https://www.intelligentgraphicandcode.com/storage/img/igc-tart-logo_1763304567.png" alt="TART Logo" width="400">
</p>

<p align="center">
  <strong>Terminal Art for Artisan</strong><br>
  <em>A beautiful, expressive terminal UI toolkit for PHP console applications</em>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/php-%5E8.0-blue" alt="PHP Version">
  <img src="https://img.shields.io/badge/license-MIT-green" alt="License">
  <img src="https://img.shields.io/badge/version-1.1.0-brightgreen" alt="Version">
</p>

---

## Why TART?

Transform boring CLI commands into beautiful, professional applications with styled output, themed blocks, automatic logo generation, and more. Make your terminal applications a joy to use and a work of art!

```php
// New fluent APIs (recommended)
$this->logo()
    ->text('MY APP')
    ->boxed()
    ->color('cyan')
    ->render();

$this->say('Processing data...');
$this->good('✓ Step 1 complete');
$this->success('🎉 Deployment complete!');

// Or use the traditional API (still supported)
$this->displayTextLogo('MY APP', 'box', ['text_color' => 'cyan']);
$this->say('Processing data...');
$this->good('✓ Step 1 complete');
$this->success('🎉 Deployment complete!');
```

## 📸 Examples in Action

<p align="center">
  <img src="https://www.intelligentgraphicandcode.com/storage/img/tart-example-1_1763324914.png" alt="TART Example 1" width="600">
</p>

<p align="center">
  <img src="https://www.intelligentgraphicandcode.com/storage/img/tart-example-2_1763324897.png" alt="TART Example 2" width="600">
</p>

## ✨ Features

- 🎨 **Rich Formatting** - Colored text, backgrounds, and styled blocks
- 📦 **Block Messages** - Beautiful success, warning, error, and info blocks
- 🏷️ **Automatic Logos** - Create branded ASCII art logos with one line of code
- 🎭 **Theme System** - Built-in themes or create your own with fluent APIs
- 📊 **Progress Indicators** - Build output line-by-line with columns
- 🔧 **Framework Agnostic** - Works with Laravel, Symfony, or standalone
- ✨ **Emoji Support** - Full multi-byte UTF-8 character support
- 🧩 **Modular** - Use only what you need with traits
- ⚡ **Fluent APIs** - Chainable methods for expressive, Laravel-like syntax
- 🔄 **Backward Compatible** - Traditional APIs still supported

## Installation

```bash
composer require igclabs/tart
```

### Verify Installation

After requiring the package, you can confirm that Composer resolved the correct package by inspecting it:

```bash
composer show igclabs/tart
# name     : igclabs/tart
# versions : * 1.1.0
```

## Quick Start

### Laravel

```php
<?php

namespace App\Console\Commands;

use IGC\Tart\Laravel\StyledCommand;

class DeployCommand extends StyledCommand
{
    protected $signature = 'app:deploy';
    
    public function handle()
    {
        // Beautiful branded logo (fluent API)
        $this->logo()
            ->text('DEPLOYMENT SYSTEM')
            ->boxed()
            ->color('cyan')
            ->render();
        
        $this->br();
        
        // Progress tracking
        $this->openLine('Building application');
        // ... work ...
        $this->appendLine(' ✓', 'green');
        $this->closeLine();
        
        $this->openLine('Running tests');
        // ... work ...
        $this->appendLine(' ✓', 'green');
        $this->closeLine();
        
        // Success finish
        $this->br();
        $this->success('🎉 Deployment Complete!');
        
        return self::SUCCESS;
    }
}
```

### Example Usage

See the complete example in [examples/laravel-example.php](examples/laravel-example.php)

### Symfony Console

```php
<?php

namespace App\Command;

use IGC\Tart\Symfony\StyledCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DeployCommand extends StyledCommand
{
    protected static $defaultName = 'app:deploy';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->header('Deployment (Symfony)');
        $this->say('Shipping bits via Symfony Console!');
        $this->success('Done!');

        return Command::SUCCESS;
    }
}
```

Need custom defaults outside Laravel? Pass overrides into the constructor:

```php
new DeployCommand('app:deploy', [
    'theme' => [
        'class' => \IGC\Tart\Themes\Theme::class,
        'color' => 'purple',
        'max_line_width' => 100,
    ],
]);
```

### Laravel Auto-Discovery & Demo Command

Laravel 9+ automatically discovers the `IGC\Tart\Laravel\TartServiceProvider`, which registers the `tart:demo` Artisan command. After installing the package you can immediately preview the styling toolkit:

```bash
php artisan tart:demo
```

Need manual control? Add TART to Composer's `dont-discover` list and register the provider in `config/app.php`:

```json
{
    "extra": {
        "laravel": {
            "dont-discover": [
                "igclabs/tart"
            ]
        }
    }
}
```

```php
// config/app.php
'providers' => [
    // ...
    IGC\Tart\Laravel\TartServiceProvider::class,
],
```

#### Publish Configuration

Publish the default configuration to tweak the base theme, logo colors, or auto-answer behavior:

```bash
php artisan vendor:publish --tag=tart-config
```

`config/tart.php` lets you point to a custom `ThemeInterface` implementation or adjust the palette/width used by the bundled `Theme` class.

## 📖 Core Features

### Basic Output

```php
$this->say('Regular message');
$this->good('✓ Success message');         // Green
$this->bad('✗ Error message');            // Red
$this->state('⚠ Status message');         // Yellow
$this->cool('ℹ Info message');            // Cyan
```

### Block Messages

```php
$this->header('Processing');              // Large header
$this->title('Section Title');            // Title block
$this->success('Operation succeeded!');   // Green block
$this->warning('Check this issue');       // Red block
$this->notice('Important info');          // Cyan block
$this->failure('Operation failed');       // Error block
$this->stat('Completed in 2.5s');        // Stat block
$this->footer('Process', 'Time: 2.5s');  // Footer
```

### Logo Creation 🎨

```php
// Fluent API (recommended)
$this->logo()
    ->text('MY APP')
    ->render();

$this->logo()
    ->text('DEPLOYMENT')
    ->boxed()
    ->color('green')
    ->render();

$this->logo()
    ->text('BUILD COMPLETE')
    ->banner()
    ->render();

// ASCII art with fluent API
$asciiArt = <<<'ASCII'
  ____  ____   ___  _____  ____
 |  _ \|  _ \ / _ \|  ___/ ___|
 | |_) | |_) | | | | |_  \___ \
 |  __/|  _ <| |_| |  _|  ___) |
 |_|   |_| \_\\___/|_|   |____/
ASCII;

$this->logo()
    ->ascii($asciiArt)
    ->colors(['cyan', 'blue', 'white'])
    ->render();

// Traditional API (still supported)
$this->displayTextLogo('MY APP');
$this->displayTextLogo('DEPLOYMENT', 'box', ['text_color' => 'green']);
$this->displayTextLogo('BUILD COMPLETE', 'banner');
$this->displayAsciiLogo($asciiArt, ['colors' => ['cyan', 'blue', 'white']]);
```

### Line Building & Columns

```php
// Progressive output
$this->openLine('Processing users');
// ... do work ...
$this->appendLine(' ✓ Done', 'green');
$this->closeLine();

// Table-like columns
$this->openLine('User');
$this->addColumn('John Doe', 25, 'white');
$this->addColumn('Active', 15, 'green');
$this->addColumn('Admin', 10, 'cyan');
$this->closeLine();
```

### Layout

```php
$this->br();        // Blank line
$this->br(3);       // 3 blank lines
$this->hr();        // Horizontal rule
```

## 🎨 Themes

```php
use IGC\Tart\Themes\{DefaultTheme, SuccessTheme, ErrorTheme, Theme};

// Fluent theme creation (recommended)
$theme = Theme::make('purple')
    ->withTextColor('white')
    ->withHighlightColor('yellow')
    ->withMaxWidth(80);

$this->setTheme($theme);
$this->header('Success Operations');

// Use built-in theme
$this->setTheme(new SuccessTheme());
$this->header('Success Operations');

// Traditional theme creation (still supported)
$theme = new Theme(
    color: 'purple',
    textColor: 'white',
    highlightColor: 'yellow',
    maxLineWidth: 80
);
$this->setTheme($theme);
```

**Built-in Themes:**
- `DefaultTheme` - Blue (general use)
- `SuccessTheme` - Green (success operations)
- `ErrorTheme` - Red (error handling)

## 📚 Documentation

- **[Getting Started](docs/GETTING-STARTED.md)** - Installation and first steps
- **[Quick Reference](docs/guides/QUICK-REFERENCE.md)** - Complete API reference
- **[Logo Creation](docs/guides/LOGO-CREATION.md)** - Logo generation guide
- **[Examples](examples/)** - Working code examples

## 💻 Examples

Check out the working examples in the `examples/` directory:

### Built-in Demo Command
```bash
# Auto-registered when the package is installed in Laravel
php artisan tart:demo
```

### Quick Demo Source
```bash
# Basic demo showing the same features inside your editor
cat examples/demo-command.php
```

### Comprehensive Demo
```bash
# Full showcase of all TART capabilities
cat examples/comprehensive-demo.php
```

### Laravel Integration
```bash
# Complete Laravel command example
cat examples/laravel-example.php
```

**Try it yourself:**
1. Run `php artisan tart:demo` to see the built-in showcase
2. Copy any example to your Laravel `app/Console/Commands/` directory when you're ready to customize your own command

## 💡 Use Cases

### Application Branding

```php
public function handle()
{
    // Fluent logo creation
    $this->logo()
        ->text('PROFSS PLATFORM')
        ->boxed()
        ->color('cyan')
        ->render();

    // ... application logic ...
}
```

### Progress Tracking

```php
$items = ['Users', 'Posts', 'Comments'];

foreach ($items as $item) {
    $this->openLine("Processing {$item}");
    // ... process ...
    $this->appendLine(' ✓', 'green');
    $this->closeLine();
}
```

### Status Reports

```php
$this->say('System Status:');
$this->good('✓ Database: Connected');
$this->good('✓ Cache: Operational');
$this->bad('✗ API: Connection timeout');
$this->stat('Report generated in 1.2s');
```

### Themed Operations

```php
// Fluent theme creation
$theme = Theme::make('green')
    ->withTextColor('white')
    ->withHighlightColor('yellow');

$this->setTheme($theme);
$this->header('Deployment');
// ... deployment logic ...
$this->logo()
    ->text('SUCCESS')
    ->banner()
    ->color('green')
    ->render();
```

## 🏗️ Architecture

TART uses a modular trait-based architecture:

- **HasColoredOutput** - Basic colored text output
- **HasBlocks** - Block-style formatted messages
- **HasLineBuilding** - Build lines incrementally
- **HasInteractivity** - Interactive prompts

Mix and match traits in your own classes for maximum flexibility.

## 🧪 Testing

```bash
composer install
composer test
```

## Requirements

- **PHP** 8.0 or higher
- **Symfony Console** 5.0+ or 6.0+
- **Laravel** 9.0+ (for Laravel integration)
- **mbstring extension** (standard in most PHP installations)

## 📦 What's Included

- ✅ 15+ output methods
- ✅ 7 block message types
- ✅ 3 logo styles (standard, box, banner)
- ✅ Theme system with 3 built-in themes
- ✅ Multi-byte character support (emojis!)
- ✅ Unit and integration tests
- ✅ Complete documentation
- ✅ Working examples

## 🤝 Contributing

Contributions are welcome! Please see [CONTRIBUTING.md](CONTRIBUTING.md) for details.

## 📄 License

MIT License - see [LICENSE](LICENSE) for details.

## 🙏 Credits

Developed by the [IGC team](https://www.intelligentgraphicandcode.com/). Extracted from internal tooling and open-sourced for the community.

## 🔗 Resources

- **Getting Started:** [docs/GETTING-STARTED.md](docs/GETTING-STARTED.md)
- **Quick Reference:** [docs/guides/QUICK-REFERENCE.md](docs/guides/QUICK-REFERENCE.md)
- **Logo Creation:** [docs/guides/LOGO-CREATION.md](docs/guides/LOGO-CREATION.md)
- **Examples:** [examples/README.md](examples/README.md)

---

<p align="center">
  <strong>Make your CLI applications beautiful with Terminal Art! 🎨✨</strong>
</p>

<p align="center">
  <a href="docs/GETTING-STARTED.md">Get Started</a> •
  <a href="docs/guides/QUICK-REFERENCE.md">API Reference</a> •
  <a href="docs/guides/LOGO-CREATION.md">Logos</a> •
  <a href="examples/README.md">Examples</a>
</p>
