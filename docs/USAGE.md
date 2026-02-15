# TART Usage Guide

This guide is about **using TART in real commands**.

It focuses on the practical workflow:

1. Install it
2. Create a command that extends TART
3. Use the styling helpers while your command runs
4. Reuse common patterns (logos, status messages, progress, input)

---

## 1) Install

```bash
composer require igclabs/tart
```

Optional check:

```bash
composer show igclabs/tart
```

---

## 2) Choose your runtime

TART can be used in:

- **Laravel Artisan commands** via `IGC\Tart\Laravel\StyledCommand`
- **Symfony Console commands** via `IGC\Tart\Symfony\StyledCommand`

If you're in Laravel, start there first.

---

## 3) Laravel: first command

Create a command and extend `IGC\Tart\Laravel\StyledCommand`.

```php
<?php

namespace App\Console\Commands;

use IGC\Tart\Laravel\StyledCommand;

class AppDeployCommand extends StyledCommand
{
    protected $signature = 'app:deploy';
    protected $description = 'Deploy the application with styled terminal output';

    public function handle(): int
    {
        // 1) Branding
        $this->logo()
            ->text('MY APP')
            ->boxed()
            ->color('cyan')
            ->render();

        $this->br();

        // 2) Human-friendly run log
        $this->say('Starting deployment...');
        $this->good('✓ Dependencies installed');
        $this->good('✓ Assets built');

        // 3) Final state block
        $this->success('Deployment complete');

        return self::SUCCESS;
    }
}
```

Run it:

```bash
php artisan app:deploy
```

---

## 4) Symfony: first command

```php
<?php

namespace App\Command;

use IGC\Tart\Symfony\StyledCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AppStatusCommand extends StyledCommand
{
    protected static $defaultName = 'app:status';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->header('Application Status');
        $this->say('All systems operational');
        $this->success('Status check complete');

        return Command::SUCCESS;
    }
}
```

---

## 5) Daily-use output patterns

Use these in your `handle()` / `execute()` method.

### Basic message types

```php
$this->say('Regular message');
$this->good('✓ Success-style line');
$this->bad('✗ Error-style line');
$this->state('⚠ Warning-style line');
$this->cool('ℹ Info-style line');
```

### Block messages

```php
$this->header('Deploy Pipeline');
$this->title('Build Stage');
$this->success('Build completed');
$this->warning('Cache is stale');
$this->notice('Running in maintenance mode');
$this->failure('Rollback triggered');
$this->footer('Deploy Pipeline', 'Finished in 34s');
```

### Spacing and separators

```php
$this->br();     // blank line
$this->br(2);    // 2 blank lines
$this->hr();     // horizontal rule
```

---

## 6) Progress-style output while work is running

### Incremental line updates

```php
$this->openLine('Migrating database');
// ... do the work ...
$this->appendLine(' ✓', 'green');
$this->closeLine();
```

### Column-style status line

```php
$this->openLine('Worker #1');
$this->addColumn('Import Jobs', 22, 'white');
$this->addColumn('Running', 12, 'green');
$this->addColumn('ETA 02:31', 12, 'cyan');
$this->closeLine();
```

---

## 7) Logos (quick branding)

### Fluent logo API (recommended)

```php
$this->logo()
    ->text('MY APP')
    ->boxed()
    ->color('cyan')
    ->render();
```

### Banner style

```php
$this->logo()
    ->text('DEPLOY COMPLETE')
    ->banner()
    ->render();
```

### ASCII art logo

```php
$ascii = <<<'ASCII'
  __  ___  __
 /  |/  / / /_
/ /|_/ / / __/
/_/  /_/  \__/
ASCII;

$this->logo()
    ->ascii($ascii)
    ->colors(['cyan', 'blue', 'white'])
    ->render();
```

---

## 8) Theme usage

### Apply a built-in theme

```php
use IGC\Tart\Themes\SuccessTheme;

$this->setTheme(new SuccessTheme());
$this->header('Release');
```

### Build a theme fluently

```php
use IGC\Tart\Themes\Theme;

$theme = Theme::make('magenta')
    ->withTextColor('white')
    ->withHighlightColor('yellow')
    ->withMaxWidth(90);

$this->setTheme($theme);
```

---

## 9) Interactive terminal input

Use this when the command should ask users for values while running.

```php
$name = $this->prompt('Project name');
$secret = $this->password('API token');

$this->good("Configured project: {$name}");
```

For selection-style interaction:

```php
$choice = $this->select('Choose environment', [
    'local' => 'Local',
    'staging' => 'Staging',
    'production' => 'Production',
]);

$this->notice("Environment: {$choice}");
```

---

## 10) Practical recipe: deployment command skeleton

```php
public function handle(): int
{
    $this->logo()->text('DEPLOY')->boxed()->color('cyan')->render();
    $this->br();

    $this->openLine('Pull latest code');
    // ...
    $this->appendLine(' ✓', 'green');
    $this->closeLine();

    $this->openLine('Run migrations');
    // ...
    $this->appendLine(' ✓', 'green');
    $this->closeLine();

    $this->openLine('Warm cache');
    // ...
    $this->appendLine(' ✓', 'green');
    $this->closeLine();

    $this->br();
    $this->success('Deployment complete');

    return self::SUCCESS;
}
```

---

## 11) Run built-in demos (Laravel)

After install, you can preview usage patterns quickly:

```bash
php artisan tart:demo
php artisan tart:new-features
php artisan tart:fluent-demo
php artisan tart:interactive-demo
php artisan tart:demo-full
```

---

## 12) Which API should I use?

Use the **fluent API** for new code:

```php
$this->logo()->text('APP')->boxed()->color('cyan')->render();
```

The legacy APIs still work for compatibility, but fluent methods are clearer and preferred for new commands.

---

## 13) Quick checklist for production commands

- Keep first output line branded (`logo()` or `header()`)
- Use `openLine()/appendLine()/closeLine()` for each long-running step
- Use one final `success()` or `failure()` block
- Keep colors consistent by applying one theme per command
- Keep interactive prompts grouped at the start when possible

If you follow that structure, your CLI output stays readable and professional.
