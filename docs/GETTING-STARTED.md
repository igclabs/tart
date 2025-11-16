# Getting Started with TART

**TART** (Terminal Art for Artisan) - Make your CLI applications beautiful!

---

## 📦 Installation

### Laravel Projects

```bash
composer require igclabs/tart
```

### Verify Installation

```bash
composer show igclabs/tart
```

You should see output that begins with `name     : igclabs/tart`, confirming Composer installed the correct package.

### Laravel Auto-Discovery

Laravel 9+ automatically registers `IGC\Tart\Laravel\TartServiceProvider`, which exposes the built-in demo command:

```bash
php artisan tart:demo
```

Prefer manual control? Disable auto-discovery in Composer and add the provider to `config/app.php`.

### Configuration

Publish the configuration to customize the default theme, logo palette, and auto-answer behavior:

```bash
php artisan vendor:publish --tag=tart-config
```

### Symfony Console Projects

Use the `IGC\Tart\Symfony\StyledCommand` base class when building commands without Laravel:

```php
use IGC\Tart\Symfony\StyledCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StatusCommand extends StyledCommand
{
    protected static $defaultName = 'app:status';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->header('Status');
        $this->say('All systems nominal');

        return Command::SUCCESS;
    }
}
```

Need to override defaults? Pass a config array into the constructor:

```php
new StatusCommand('app:status', [
    'theme' => ['color' => 'green'],
    'auto_answer' => true,
]);
```

That's it! The package is ready to use.

---

## 🚀 Quick Start

### 1. Your First Command

```php
<?php

namespace App\Console\Commands;

use IGC\Tart\Laravel\StyledCommand;

class MyCommand extends StyledCommand
{
    protected $signature = 'my:command';
    protected $description = 'My beautiful command';

    public function handle()
    {
        // Add a branded logo
        $this->displayTextLogo('MY APP', 'box', [
            'text_color' => 'cyan',
        ]);
        
        $this->br();
        
        // Basic output
        $this->say('Processing data...');
        $this->good('✓ Step 1 complete');
        $this->good('✓ Step 2 complete');
        
        // Success message
        $this->success('🎉 All done!');
        
        return self::SUCCESS;
    }
}
```

### 2. Run It

```bash
php artisan my:command
```

---

## 🎨 Common Patterns

### Application Branding

```php
public function handle()
{
    // Start with your branded logo
    $this->displayTextLogo('COMPANY NAME', 'box', [
        'text_color' => 'cyan',
    ]);
    
    // ... your logic ...
}
```

### Progress Tracking

```php
$items = ['Users', 'Posts', 'Comments'];

foreach ($items as $item) {
    $this->openLine("Processing {$item}");
    // ... do work ...
    $this->appendLine(' ✓', 'green');
    $this->closeLine();
}
```

### Status Reports

```php
$this->say('System Status:');
$this->good('✓ Database: Connected');
$this->good('✓ Cache: Operational');
$this->bad('✗ API: Timeout');
```

### Themed Operations

```php
use IGC\Tart\Themes\SuccessTheme;

$this->setTheme(new SuccessTheme());
$this->header('Deployment');
// ... deployment logic ...
$this->success('Deployed!');
```

---

## 📚 Learn More

### Quick Reference
See [QUICK-REFERENCE.md](guides/QUICK-REFERENCE.md) for a one-page API reference.

### Logo Creation
See [LOGO-CREATION.md](guides/LOGO-CREATION.md) for complete logo generation guide.

### Examples
Check out [examples/laravel-example.php](../examples/laravel-example.php) for a complete working example.

---

## 🎯 Next Steps

1. ✅ Read [Quick Reference](guides/QUICK-REFERENCE.md)
2. ✅ Check [examples/laravel-example.php](../examples/laravel-example.php)
3. ✅ Explore [Logo Creation](guides/LOGO-CREATION.md)
4. ✅ Create your first styled command!

---

**Ready to make beautiful CLI applications!** 🎨✨

