<?php

namespace IGC\Tart\Laravel\Commands;

use IGC\Tart\Laravel\StyledCommand;

class TartDemoCommand extends StyledCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tart:demo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Showcase the most common TART formatting features';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->logoBlock();

        $this->header('TART Feature Showcase');

        $this->say('Welcome to TART - Terminal Art for Artisan!');
        $this->br();

        $this->demoBasicOutput();
        $this->demoLists();
        $this->demoTables();
        $this->demoProgressIndicators();
        $this->demoBlocks();

        $this->footer('Demo Complete', 'Time: 3.2s');

        return self::SUCCESS;
    }

    protected function demoBasicOutput(): void
    {
        $this->title('Basic Output');

        $this->say('Regular text output');
        $this->good('✓ Success message');
        $this->state('⚠ Status message');
        $this->cool('ℹ Info message');
        $this->bad('✗ Error message');

        $this->br();
    }

    protected function demoLists(): void
    {
        $this->title('Lists');

        $this->say('Bullet list:');
        $this->bulletList([
            'Feature-rich CLI toolkit',
            'Multiple output styles',
            'Interactive components',
        ]);

        $this->br();

        $this->say('Task checklist:');
        $this->taskList([
            '✓ Text styling',
            '✓ Progress tracking',
            '✓ Interactive input',
        ]);

        $this->br();
    }

    protected function demoTables(): void
    {
        $this->title('Tables');

        $this->renderTable(
            ['Component', 'Status', 'Version'],
            [
                ['Core', 'Active', '1.1.3'],
                ['Lists', 'Active', '1.2.0'],
                ['Tables', 'Active', '1.2.0'],
                ['Progress', 'Active', '1.2.0'],
            ]
        );

        $this->br();
    }

    protected function demoProgressIndicators(): void
    {
        $this->title('Progress Tracking');

        $this->say('Line-by-line progress:');
        $steps = ['Initialize', 'Process', 'Finalize'];

        foreach ($steps as $step) {
            $this->openLine($step);
            usleep(200000);
            $this->appendLine(' ✓', 'green');
            $this->closeLine();
        }

        $this->br();

        $this->say('Progress bar:');
        $this->progressBar(50, 'Loading', function ($bar) {
            for ($i = 0; $i < 50; $i += 10) {
                usleep(100000);
                $bar->advance(10);
            }
        });

        $this->br();
    }

    protected function demoBlocks(): void
    {
        $this->title('Block Messages');

        $this->success('Operation completed successfully!');
        $this->notice('This is an informational message');
        $this->warning('Please review this warning');
        $this->stat('Processed 1,234 items in 2.5s');

        $this->br();
    }

    /**
     * Wrap long paragraphs to the current theme width.
     */
    protected function narrate(string $text): void
    {
        $width = max(10, $this->getTheme()->getMaxLineWidth() - 4);
        foreach (explode("\n", wordwrap($text, $width)) as $line) {
            $this->say($line);
        }
    }

    /**
     * Calculate the inner logo width (excluding outer framing).
     */
    protected function logoWidth(): int
    {
        return max(24, $this->getTheme()->getMaxLineWidth() + 8);
    }
}
