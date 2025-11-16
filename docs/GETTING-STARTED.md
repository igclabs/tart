# Getting Started with TART

**TART** (Terminal Art for Artisan) - Make your CLI applications beautiful!

---

## 📦 Installation

### Laravel Projects

```bash
composer require profss/tart
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

