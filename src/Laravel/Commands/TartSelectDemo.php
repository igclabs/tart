<?php

namespace IGC\Tart\Laravel\Commands;

use IGC\Tart\Laravel\StyledCommand;

class TartSelectDemo extends StyledCommand
{
    protected $signature = 'tart:select-demo';

    protected $description = 'Demo of TART select and multi-select features';

    public function handle(): int
    {
        $this->header('SELECT & MULTI-SELECT DEMO');
        $this->br();

        $this->demoSelect();
        $this->br();

        $this->demoMultiSelect();
        $this->br();

        $this->success('Select demo complete!');

        return self::SUCCESS;
    }

    protected function demoSelect(): void
    {
        $this->title('Single Select');
        $this->say('Choose your deployment environment:');
        $this->br();

        $environment = $this->select('Select environment', [
            'local' => 'Local Development',
            'staging' => 'Staging Server',
            'production' => 'Production',
        ], 'staging');

        $this->br();
        $this->good("You selected: {$environment}");
        $this->br();

        $this->say('Choose your framework:');
        $this->br();

        $framework = $this->select('Select framework', [
            'laravel' => 'Laravel',
            'symfony' => 'Symfony',
            'slim' => 'Slim',
            'lumen' => 'Lumen',
        ]);

        $this->br();
        $this->good("You selected: {$framework}");
    }

    protected function demoMultiSelect(): void
    {
        $this->title('Multi-Select');
        $this->say('Choose features to enable:');
        $this->br();

        $features = $this->multiSelect('Select features', [
            'api' => 'API Access',
            'admin' => 'Admin Panel',
            'reports' => 'Reporting',
            'notifications' => 'Email Notifications',
            'analytics' => 'Analytics Dashboard',
        ], ['api']);

        $this->br();

        if (empty($features)) {
            $this->bad('No features selected');
        } else {
            $this->good('Selected features: ' . implode(', ', $features));
        }

        $this->br();
        $this->say('Choose permissions (at least 1 required):');
        $this->br();

        $permissions = $this->multiSelect('Select permissions', [
            'read' => 'Read Access',
            'write' => 'Write Access',
            'delete' => 'Delete Access',
            'admin' => 'Admin Access',
        ], [], 1);

        $this->br();
        $this->good('Selected permissions: ' . implode(', ', $permissions));
    }
}
