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

    public function test_demo_command_is_available(): void
    {
        $this->artisan('tart:demo')->assertExitCode(0);
    }
}
