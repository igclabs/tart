<?php

namespace IGC\Tart\Laravel\Commands;

use IGC\Tart\Laravel\StyledCommand;

class TartNewFeaturesDemo extends StyledCommand
{
    protected $signature = 'tart:new-features';

    protected $description = 'Demo of new TART features (input, spinners, lists, tables, progress bars)';

    public function handle(): int
    {
        $this->header('NEW TART FEATURES DEMO');

        $this->demoLists();
        $this->demoTables();
        $this->demoProgressBar();
        $this->demoInput();

        $this->success('Demo Complete!');

        return self::SUCCESS;
    }

    protected function demoLists(): void
    {
        $this->title('Lists');

        $this->say('Bullet List:');
        $this->bulletList([
            'First item',
            'Second item',
            'Nested' => [
                'Sub-item A',
                'Sub-item B',
            ],
            'Third item',
        ]);

        $this->br();
        $this->say('Ordered List:');
        $this->orderedList([
            'Step one',
            'Step two',
            'Step three',
        ]);

        $this->br();
        $this->say('Task List:');
        $this->taskList([
            '✓ Completed task',
            '✗ Failed task',
            '• Pending task',
        ]);

        $this->br();
    }

    protected function demoTables(): void
    {
        $this->title('Tables');

        $this->renderTable(
            ['Name', 'Status', 'Count'],
            [
                ['Database', 'Online', '127'],
                ['API', 'Online', '89'],
                ['Cache', 'Degraded', '42'],
            ]
        );

        $this->br();
    }

    protected function demoProgressBar(): void
    {
        $this->title('Progress Bar');

        $this->progressBar(100, 'Processing', function ($bar) {
            for ($i = 0; $i < 100; $i += 10) {
                usleep(100000);
                $bar->advance(10);
            }
        });

        $this->br();
    }

    protected function demoInput(): void
    {
        $this->title('Interactive Input');

        if ($this->confirm('Try text input demo?', false)) {
            $name = $this->prompt('What is your name?', 'Anonymous');
            $this->good("Hello, {$name}!");
            $this->br();
        } else {
            $this->notice('Skipped input demo');
            $this->br();
        }
    }
}
