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
        $this->header('Processing');

        $this->say('Processing data...');
        $this->good('✓ Step 1 complete');

        $this->br();

        $this->title('Section Title');
        $this->success('Operation succeeded!');
        $this->warning('Check this issue');
        $this->notice('Important info');
        $this->failure('Operation failed');

        $this->success('Deployment complete!');
        $this->footer('Process', 'Time: 2.5s');

        return self::SUCCESS;
    }
}

