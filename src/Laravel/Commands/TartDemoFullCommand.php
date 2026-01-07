<?php

namespace IGC\Tart\Laravel\Commands;

use IGC\Tart\Laravel\StyledCommand;
use IGC\Tart\Themes\ErrorTheme;
use IGC\Tart\Themes\SuccessTheme;

/**
 * Comprehensive TART Demo Command
 *
 * This command demonstrates ALL available TART features in one place.
 * Perfect for testing, showcasing, and learning what TART can do.
 */
class TartDemoFullCommand extends StyledCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tart:demo-full {--theme=default : Theme to use (default|success|error)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comprehensive demonstration of all TART features';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // Theme selection
        $this->handleThemeOption();

        // === LOGOS ===
        $this->demoLogos();

        // === BASIC OUTPUT ===
        $this->demoBasicOutput();

        // === BLOCK MESSAGES ===
        $this->demoBlockMessages();

        // === LISTS ===
        $this->demoLists();

        // === TABLES ===
        $this->demoTables();

        // === PROGRESS BARS ===
        $this->demoProgressBars();

        // === LINE BUILDING ===
        $this->demoLineBuilding();

        // === PATH HIGHLIGHTING ===
        $this->demoPathHighlighting();

        // === VISUAL ELEMENTS ===
        $this->demoVisualElements();

        // === INTERACTIVE FEATURES ===
        if ($this->demoInteractivity()) {
            $this->demoTextStyles();
        }

        // Final footer
        $this->footer('Demo', 'Execution time: 3.2s');

        return self::SUCCESS;
    }

    /**
     * Handle theme option from command.
     */
    protected function handleThemeOption(): void
    {
        $theme = $this->option('theme');

        if ($theme === 'success') {
            $this->setTheme(new SuccessTheme());
        } elseif ($theme === 'error') {
            $this->setTheme(new ErrorTheme());
        }
    }

    /**
     * Demonstrate logo display options.
     */
    protected function demoLogos(): void
    {
        $this->logoBlock();

        // Optional: Show text logo
        $this->displayTextLogo('TART', 'banner', [
            'color' => 'cyan',
            'padding' => 2,
        ]);

        $this->br();
    }

    /**
     * Demonstrate basic output methods.
     */
    protected function demoBasicOutput(): void
    {
        $this->header('Basic Output');

        $this->say('This is a regular message using say()');
        $this->good('✓ This is a success message using good()');
        $this->state('⚠ This is a status message using state()');
        $this->cool('ℹ This is an info message using cool()');
        $this->bad('✗ This is an error message using bad()');

        $this->br();
    }

    /**
     * Demonstrate block message types.
     */
    protected function demoBlockMessages(): void
    {
        $this->title('Block Message Types');

        $this->success('SUCCESS: Operation completed successfully!');
        $this->notice('NOTICE: This is important information');
        $this->warning('WARNING: Please check this issue');
        $this->failure('FAILURE: Operation failed');
        $this->stat('STAT: Processing took 2.5 seconds');

        $this->br();
    }

    /**
     * Demonstrate lists.
     */
    protected function demoLists(): void
    {
        $this->title('Lists');

        $this->say('Bullet list:');
        $this->bulletList([
            'First item',
            'Second item',
            'Nested items' => [
                'Sub-item A',
                'Sub-item B',
            ],
            'Third item',
        ]);

        $this->br();

        $this->say('Ordered list:');
        $this->orderedList([
            'Step one: Initialize',
            'Step two: Process',
            'Step three: Complete',
        ]);

        $this->br();

        $this->say('Task list:');
        $this->taskList([
            '✓ Setup complete',
            '✓ Tests passing',
            '✗ Deployment failed',
            '• Documentation pending',
        ]);

        $this->br();
    }

    /**
     * Demonstrate tables.
     */
    protected function demoTables(): void
    {
        $this->title('Tables');

        $this->say('Service status table:');
        $this->renderTable(
            ['Service', 'Status', 'Response Time', 'Uptime'],
            [
                ['Database', 'Online', '12ms', '99.99%'],
                ['API Gateway', 'Online', '45ms', '99.95%'],
                ['Cache Server', 'Degraded', '120ms', '98.50%'],
                ['Queue Worker', 'Online', '8ms', '100.00%'],
            ]
        );

        $this->br();
    }

    /**
     * Demonstrate progress bars.
     */
    protected function demoProgressBars(): void
    {
        $this->title('Progress Bars');

        $this->say('Processing items with progress bar:');
        $this->progressBar(100, 'Processing', function ($bar) {
            for ($i = 0; $i < 100; $i += 20) {
                usleep(150000);
                $bar->advance(20);
            }
        });

        $this->br();
        $this->good('✓ Processing complete');
        $this->br();
    }

    /**
     * Demonstrate line building (dynamic output).
     */
    protected function demoLineBuilding(): void
    {
        $this->title('Dynamic Line Building');

        $items = ['Users', 'Posts', 'Comments', 'Tags', 'Categories'];

        foreach ($items as $item) {
            $this->openLine("Processing {$item}");
            usleep(300000);
            $this->appendLine('...', 'yellow');
            usleep(200000);
            $this->appendLine(' Done!', 'green');
            $this->closeLine();
        }

        $this->br();
        $this->good('✓ All items processed');
        $this->br();
    }

    /**
     * Demonstrate path highlighting.
     */
    protected function demoPathHighlighting(): void
    {
        $this->title('Path Highlighting');

        $paths = [
            '/var/www/html/app/Console/Commands/DemoCommand.php',
            '/home/user/projects/laravel/routes/web.php',
            '/Users/Developer/Projects/app/Http/Controllers/UserController.php',
        ];

        $this->say('File paths are automatically highlighted:');
        $this->br();

        foreach ($paths as $path) {
            $this->say($this->pathHighlight($path));
        }

        $this->br();
    }

    /**
     * Demonstrate visual elements.
     */
    protected function demoVisualElements(): void
    {
        $this->title('Visual Elements');

        $this->say('Horizontal rule:');
        $this->hr();

        $this->say('Blank lines using br():');
        $this->br(3);

        $this->say('Color blocks for visual separation:');
        $this->colorBlocks(2);

        $this->br();
    }

    /**
     * Demonstrate interactive features.
     *
     * @return bool User's choice to continue
     */
    protected function demoInteractivity(): bool
    {
        $this->title('Interactive Features');

        $this->say('TART includes styled interactive prompts.');
        $this->br();

        if ($this->confirm('Would you like to see the built-in text style demo?', true)) {
            return true;
        }

        $this->notice('Skipping text style demo');

        return false;
    }

    /**
     * Demonstrate all text styles (built-in method).
     */
    protected function demoTextStyles(): void
    {
        $this->br();
        $this->demoText();
        $this->br();
    }
}
