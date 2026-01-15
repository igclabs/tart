<?php

namespace IGC\Tart\Laravel\Commands;

use IGC\Tart\Laravel\StyledCommand;

class TartInteractiveDemoCommand extends StyledCommand
{
    protected $signature = 'tart:interactive-demo';

    protected $description = 'Comprehensive demo of interactive menu, checkbox, and radio inputs';

    public function handle(): int
    {
        if (function_exists('stream_isatty') && !stream_isatty(STDIN)) {
            $this->bad('Interactive demo requires a TTY terminal.');

            return self::FAILURE;
        }

        $this->header('INTERACTIVE MENU DEMO');
        $this->say('Use ↑/↓ to move, Space to toggle, Enter to confirm.');
        $this->br();

        $environment = $this->menu('Pick a deployment environment', [
            'Staging',
            'Production',
            'Development',
        ]);

        $this->good("Environment selected: {$environment}");
        $this->br();

        $features = $this->checkboxMenu('Select TART features to enable', [
            'Spinners',
            'Progress bars',
            'Tables',
            'Blocks',
            'Lists',
        ], ['Spinners', 'Tables']);

        if ($features === []) {
            $this->notice('No features selected.');
        } else {
            $this->good('Selected features: ' . implode(', ', $features));
        }

        $this->br();

        $theme = $this->radioMenu('Choose a theme preset', [
            'Default',
            'Success',
            'Error',
        ]);

        $this->success("Theme selected: {$theme}");

        $this->br();
        $this->success('Interactive demo complete!');

        return self::SUCCESS;
    }
}
