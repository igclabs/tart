<?php

namespace IGC\Tart\Tests\Integration;

use IGC\Tart\Laravel\TartServiceProvider;
use Orchestra\Testbench\TestCase;

class TartServiceProviderTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            TartServiceProvider::class,
        ];
    }

    public function test_demo_command_is_available_when_enabled(): void
    {
        $this->app['config']->set('tart.register_demo_commands', true);

        $this->artisan('tart:demo')->assertExitCode(0);
    }

    public function test_demo_command_is_not_registered_when_disabled(): void
    {
        $this->app['config']->set('tart.register_demo_commands', false);

        $this->artisan('tart:demo')
            ->expectsOutputToContain('Command "tart:demo" is not defined')
            ->assertExitCode(1);
    }
}
