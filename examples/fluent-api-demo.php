<?php

/**
 * TART Fluent API Demo
 *
 * This example demonstrates the new fluent APIs introduced in TART.
 * Shows how to use chainable methods for more expressive, Laravel-like syntax.
 */

namespace App\Console\Commands;

use IGC\Tart\Laravel\StyledCommand;
use IGC\Tart\Themes\Theme;

class FluentApiDemoCommand extends StyledCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tart:fluent-demo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Demonstrate TART\'s new fluent APIs';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // === FLUENT THEME CREATION ===
        $this->demoFluentThemes();

        // === FLUENT LOGO CREATION ===
        $this->demoFluentLogos();

        // === METHOD CHAINING ===
        $this->demoMethodChaining();

        // === COMPLEX EXAMPLE ===
        $this->demoComplexExample();

        $this->footer('Fluent API Demo', 'All examples completed!');
        return self::SUCCESS;
    }

    /**
     * Demonstrate fluent theme creation.
     */
    protected function demoFluentThemes(): void
    {
        $this->header('Fluent Theme Creation');

        // Create a custom theme fluently
        $customTheme = Theme::make('purple')
            ->withTextColor('white')
            ->withHighlightColor('cyan')
            ->withMaxWidth(100)
            ->withColors(['purple', 'cyan', 'white', 'yellow']);

        $this->setTheme($customTheme);

        $this->logo()
            ->text('FLUENT THEMES')
            ->banner()
            ->color('cyan')
            ->render();

        $this->success('✓ Custom theme created with fluent API!');
        $this->notice('Theme properties:');
        $this->say("• Color: {$customTheme->getColor()}");
        $this->say("• Text Color: {$customTheme->getTextColor()}");
        $this->say("• Max Width: {$customTheme->getMaxWidth()}");

        $this->br();
    }

    /**
     * Demonstrate fluent logo creation.
     */
    protected function demoFluentLogos(): void
    {
        $this->header('Fluent Logo Creation');

        // Simple text logo
        $this->logo()
            ->text('SIMPLE')
            ->render();

        $this->br();

        // Boxed logo with custom styling
        $this->logo()
            ->text('BOXED LOGO')
            ->boxed()
            ->color('green')
            ->width(60)
            ->headerLines(1)
            ->footerLines(1)
            ->render();

        $this->br();

        // Banner logo
        $this->logo()
            ->text('BANNER STYLE')
            ->banner()
            ->color('yellow')
            ->render();

        $this->br();

        // ASCII art logo
        $asciiArt = <<<'ASCII'
███╗░░░███╗██╗░░░██╗
████╗░████║╚██╗░██╔╝
██╔████╔██║░╚████╔╝░
██║╚██╔╝██║░░╚██╔╝░░
██║░╚═╝░██║░░░██║░░░
╚═╝░░░░░╚═╝░░░╚═╝░░░
ASCII;

        $this->logo()
            ->ascii($asciiArt)
            ->colors(['cyan', 'blue', 'green'])
            ->width(50)
            ->withoutHeader()
            ->withoutFooter()
            ->render();

        $this->success('✓ All logo types created fluently!');
        $this->br();
    }

    /**
     * Demonstrate method chaining on commands.
     */
    protected function demoMethodChaining(): void
    {
        $this->header('Method Chaining');

        // Chain multiple operations together
        $this->logo()
                ->text('CHAINED OPS')
                ->boxed()
                ->color('magenta')
                ->render()
            ->br()
            ->success('First operation completed!')
            ->notice('Continuing with chained operations...')
            ->warning('This is a chained warning message')
            ->good('✓ All chained operations successful!');

        $this->br();
    }

    /**
     * Demonstrate a complex real-world example.
     */
    protected function demoComplexExample(): void
    {
        $this->header('Complex Real-World Example');

        // Create a deployment theme
        $deployTheme = Theme::make('blue')
            ->withTextColor('white')
            ->withHighlightColor('yellow')
            ->withMaxWidth(90);

        // Set the theme and show deployment header
        $this->setTheme($deployTheme)
            ->logo()
                ->text('DEPLOYMENT STARTED')
                ->banner()
                ->color('cyan')
                ->render()
            ->br();

        // Simulate deployment steps with fluent output
        $steps = [
            'Building application' => 'success',
            'Running tests' => 'success',
            'Deploying to staging' => 'warning',
            'Running migrations' => 'success',
            'Clearing cache' => 'success',
        ];

        foreach ($steps as $step => $type) {
            $this->openLine($step);

            // Simulate work
            usleep(200000);

            $icon = match($type) {
                'success' => '✓',
                'warning' => '⚠',
                'error' => '✗',
                default => '•'
            };

            $color = match($type) {
                'success' => 'green',
                'warning' => 'yellow',
                'error' => 'red',
                default => 'white'
            };

            $this->appendLine(" {$icon}", $color);
            $this->closeLine();
        }

        $this->br();

        // Final success with fluent logo
        $this->logo()
            ->text('DEPLOYMENT COMPLETE')
            ->boxed()
            ->color('green')
            ->render()
            ->success('🎉 Deployment finished successfully!')
            ->stat('Total deployment time: 2.3 seconds');
    }
}
