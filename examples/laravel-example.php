<?php

/**
 * Laravel TART Example
 * 
 * This example demonstrates how to use TART in a Laravel command.
 */

namespace App\Console\Commands;

use IGC\Tart\Laravel\StyledCommand;
use IGC\Tart\Themes\SuccessTheme;

class ExampleCommand extends StyledCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'example:demo {--theme=default : Theme to use (default|success|error)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Demonstrate TART features';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // Optionally set a different theme
        if ($this->option('theme') === 'success') {
            $this->setTheme(new SuccessTheme());
        }

        // Display a header
        $this->header('TART Demo');

        // Basic output
        $this->say('This is a regular message');
        $this->good('✓ This is a success message');
        $this->state('⚠ This is a status message');
        $this->cool('ℹ This is an info message');
        
        $this->br();

        // Block messages
        $this->title('Processing Data');
        $this->say('Starting data processing...');
        
        // Simulate some work
        $items = ['Users', 'Posts', 'Comments', 'Tags'];
        foreach ($items as $item) {
            $this->openLine("Processing {$item}");
            usleep(500000); // Simulate work
            $this->appendLine('... ', 'yellow');
            $this->appendLine('Done!', 'green');
            $this->closeLine();
        }

        $this->br();
        $this->success('All items processed successfully!');

        // Interactive confirmation
        if ($this->confirm('Would you like to see more examples?', true)) {
            $this->br();
            $this->notice('Here are some additional features:');
            
            // Path highlighting
            $path = '/var/www/html/app/Console/Commands/ExampleCommand.php';
            $this->say($this->pathHighlight($path));
            
            $this->br();
            
            // Horizontal rule
            $this->hr();
            
            // Different block types
            $this->stat('Operation completed in 2.5 seconds');
        }

        // Footer
        $this->footer('Demo', 'Total time: 2.5s');

        return self::SUCCESS;
    }
}

