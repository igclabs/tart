# TART Examples

This directory contains working examples demonstrating TART's features and capabilities. Make sure the package is installed via `composer require igclabs/tart` before copying any command into your application.

## Available Examples

### 0. simple-demo-test.php - One-Line Test (Easiest!)
**Purpose:** The absolute simplest way to test TART.

**What it shows:**
- How to use the built-in `demo()` method
- One-line demonstration of all features

**Use this when:** You just want to quickly see TART in action.

```php
public function handle(): int
{
    $this->demo();  // That's it!
    return self::SUCCESS;
}
```

---

### 1. demo-command.php - Quick Demo
**Purpose:** A simple, focused demonstration of the most common TART features.

**What it shows:**
- Logo display with `logoBlock()`
- Headers and footers
- Basic text output (`say()`, `good()`)
- Block messages (`title()`, `success()`, `warning()`, `notice()`, `failure()`)
- Timing display

**Use this when:** You want a quick reference for building a typical styled command.

```php
$this->logoBlock();        
$this->header('Processing');
$this->say('Processing data...');
$this->good('✓ Step 1 complete');
$this->title('Section Title');
$this->success('Operation succeeded!');
$this->warning('Check this issue');
$this->notice('Important info');
$this->failure('Operation failed');
$this->footer('Process', 'Time: 2.5s');
```

---

### 2. comprehensive-demo.php - Full Feature Showcase
**Purpose:** Comprehensive demonstration of ALL TART features.

**What it shows:**
- All logo types (TART logo, text logos, custom ASCII)
- All output methods (`say()`, `good()`, `bad()`, `state()`, `cool()`)
- All block types (`success()`, `notice()`, `warning()`, `failure()`, `stat()`)
- Dynamic line building with progress indicators
- Path highlighting
- Visual elements (horizontal rules, color blocks)
- Interactive prompts
- Theme switching
- Built-in text demo

**Use this when:** You want to see everything TART can do in one place.

**Run with:**
```bash
php artisan tart:demo-full
php artisan tart:demo-full --theme=success
php artisan tart:demo-full --theme=error
```

---

### 3. laravel-example.php - Real-World Example
**Purpose:** Practical example showing how to use TART in a real Laravel command.

**What it shows:**
- Theme selection via command options
- Simulated work with progressive output
- Interactive confirmations
- Data processing loops
- Path highlighting
- Combining multiple features

**Use this when:** You're building a real Laravel command and want to see practical patterns.

---

### 4. fluent-api-demo.php - Fluent APIs Showcase
**Purpose:** Demonstrates the new fluent, chainable APIs introduced in TART.

**What it shows:**
- Fluent theme creation with `Theme::make()->withColor()->...`
- Fluent logo building with `$this->logo()->text()->boxed()->...`
- Method chaining on command objects
- Complex real-world deployment example
- Comparison of fluent vs traditional APIs

**Use this when:** You want to learn the new expressive, Laravel-like syntax.

**Run with:**
```bash
php artisan tart:fluent-demo
```

---

## Using These Examples

### In Laravel

1. **Run the built-in command (already registered via the service provider):**
```bash
php artisan tart:demo
```

2. **Copy an example when you want to customize it:**
```bash
cp examples/demo-command.php app/Console/Commands/TartDemoCommand.php
```

### Standalone (Outside Laravel)

See the [GETTING-STARTED.md](../docs/GETTING-STARTED.md) guide for using TART outside of Laravel.
It includes a Symfony Console example built on `IGC\Tart\Symfony\StyledCommand`.

---

## Example Output

When you run the demo command, you'll see:

1. **Colorful TART Logo** with animated color blocks
2. **Large Header Block** with your operation name
3. **Progress Indicators** showing work being done
4. **Block Messages** in different colors (green success, red warnings, cyan notices)
5. **Dynamic Line Updates** as tasks complete
6. **Footer Block** with timing information

---

## Customization

All examples can be customized:

### Change Colors
```php
$this->setTheme(new SuccessTheme());  // Green theme
$this->setTheme(new ErrorTheme());    // Red theme
```

### Custom Width (Traditional)
```php
$theme = new Theme(
    color: 'blue',
    textColor: 'white',
    highlightColor: 'cyan',
    maxLineWidth: 100  // Wider output
);
$this->setTheme($theme);
```

### Custom Width (Fluent)
```php
$theme = Theme::make('blue')
    ->withTextColor('white')
    ->withHighlightColor('cyan')
    ->withMaxWidth(100);

$this->setTheme($theme);
```

### Custom Logo (Traditional)
```php
$this->displayTextLogo('MY APP', 'box', [
    'text_color' => 'cyan',
    'padding' => 3
]);
```

### Custom Logo (Fluent)
```php
$this->logo()
    ->text('MY APP')
    ->boxed()
    ->color('cyan')
    ->paddingTop(3)
    ->render();
```

---

## Building Your Own

Use these examples as starting points:

1. **Status Checker:** Copy `demo-command.php` and replace the blocks with your checks
2. **Deployment Script:** Copy `comprehensive-demo.php` and adapt the line building
3. **Data Processor:** Copy `laravel-example.php` and modify the loop

---

## Need Help?

- **API Reference:** [docs/guides/QUICK-REFERENCE.md](../docs/guides/QUICK-REFERENCE.md)
- **Getting Started:** [docs/GETTING-STARTED.md](../docs/GETTING-STARTED.md)
- **Logo Guide:** [docs/guides/LOGO-CREATION.md](../docs/guides/LOGO-CREATION.md)

---

**Pro Tip:** Run the comprehensive demo to see all features in action, then refer to this README to understand what each part does!

