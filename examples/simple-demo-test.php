<?php

/**
 * Simple TART Demo Test
 * 
 * The easiest way to test TART - just call $this->demo()!
 * 
 * Usage:
 * 1. Copy this file to: app/Console/Commands/TestTartCommand.php
 * 2. Run: php artisan tart:test
 */

namespace App\Console\Commands;

use IGC\Tart\Laravel\StyledCommand;

class TestTartCommand extends StyledCommand
{
    protected $signature = 'tart:test';
    protected $description = 'Test TART with the built-in demo';

    public function handle(): int
    {
        // That's it! Just one line to see all TART features:
        $this->demo();

        return self::SUCCESS;
    }
}


