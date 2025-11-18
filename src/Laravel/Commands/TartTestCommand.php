<?php

namespace IGC\Tart\Laravel\Commands;

use IGC\Tart\Laravel\StyledCommand;

/**
 * Simple TART Test Command
 *
 * The easiest way to test TART - just call $this->demo()!
 * This command demonstrates the built-in demo method that showcases
 * all TART features with a single method call.
 */
class TartTestCommand extends StyledCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tart:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test TART with the built-in demo';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // That's it! Just one line to see all TART features:
        $this->demo();

        return self::SUCCESS;
    }
}
