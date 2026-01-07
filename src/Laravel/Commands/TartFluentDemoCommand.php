<?php

namespace IGC\Tart\Laravel\Commands;

use IGC\Tart\Laravel\StyledCommand;
use IGC\Tart\Themes\DefaultTheme;
use IGC\Tart\Themes\Theme;

/**
 * TART Fluent API Demo Command
 *
 * Demonstrates the new fluent APIs introduced in TART.
 * Shows how to use chainable methods for more expressive, Laravel-like syntax.
 */
class TartFluentDemoCommand extends StyledCommand
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

        $this->logoBlock();
        $this->header('Fluent Demo');


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


        // Create a custom theme fluently
        $customTheme = Theme::make('magenta')
            ->withTextColor('bright-white')
            ->withHighlightColor('bright-red')
            ->withMaxWidth(90)
            ->withColors(['magenta', 'cyan', 'white', 'yellow']);

        $this->setTheme($customTheme);

        $this->header('Fluent Theme Creation');

        $this->logo()
            ->text('FLUENT THEMES')
            ->banner()
            ->color('cyan')
            ->render();

        $this->success('✓ Custom theme created with fluent API!');
        $this->notice('Theme properties:');
        $this->say("• Color: {$customTheme->getColor()}");
        $this->say("• Text Color: {$customTheme->getTextColor()}");
        $this->say("• Max Width: {$customTheme->getMaxLineWidth()}");

        $this->footer('Fluent Theme Creation', 'All themes created!');

        $this->setTheme(new DefaultTheme());
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
            ->render();

        $this->br();

        $this->success('First operation completed!');
        $this->notice('Continuing with chained operations...');
        $this->warning('This is a chained warning message');
        $this->good('✓ All chained operations successful!');

        $this->br();
    }

    /**
     * Demonstrate a complex real-world example.
     */
    protected function demoComplexExample(): void
    {

        // Create a deployment theme
        $deployTheme = Theme::make('white')
            ->withTextColor('black')
            ->withHighlightColor('bright-yellow');

        // Set the theme and show deployment header
        $this->setTheme($deployTheme)
            ->logo()
                ->text('DEPLOYMENT STARTED')
                ->banner()
                ->color('cyan')
                ->render();

        $this->header('Complex Real-World Example');

        $this->br();

        // Simulate deployment steps with fluent output
        $steps = [
            'Building application' => 'success',
            'Running tests' => 'success',
            'Deploying to staging' => 'warning',
            'Running migrations' => 'error',
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
            };

            $color = match($type) {
                'success' => 'green',
                'warning' => 'yellow',
                'error' => 'red',
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
            ->render();

        $this->success('Deployment finished successfully!');
        $this->stat('Total deployment time: 2.3 seconds');
    }
}
