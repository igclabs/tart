<?php

/**
 * TART Demo Command
 * 
 * This example demonstrates all the available TART features and styling options.
 * Use this as a reference for what TART can do.
 */

namespace App\Console\Commands;

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
    protected $description = 'Showcase all TART features and capabilities';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // Display the TART logo
        $this->logoBlock();        

        // Large header
        $this->header('Processing');

        // Basic text output
        $this->say('Processing data...');
        $this->good('✓ Step 1 complete');

        $this->br();

        // Title block
        $this->title('Section Title');

        // Various block types
        $this->success('Operation succeeded!');
        $this->warning('Check this issue');
        $this->notice('Important info');
        $this->failure('Operation failed');

        // Final success message
        $this->success('Deployment complete!');

        // Footer with timing
        $this->footer('Process', 'Time: 2.5s');

        return self::SUCCESS;
    }
}

