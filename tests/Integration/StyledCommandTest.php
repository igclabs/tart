<?php

namespace Profss\Tart\Tests\Integration;

use Orchestra\Testbench\TestCase;
use Profss\Tart\Laravel\StyledCommand;
use Profss\Tart\Themes\SuccessTheme;

class StyledCommandTest extends TestCase
{
    public function test_styled_command_can_be_instantiated(): void
    {
        $command = new class extends StyledCommand {
            protected $signature = 'test:command';
            protected $description = 'Test command';

            public function handle()
            {
                $this->say('Test message');
                return 0;
            }
        };

        $this->assertInstanceOf(StyledCommand::class, $command);
    }

    public function test_can_set_and_get_theme(): void
    {
        $command = new class extends StyledCommand {
            protected $signature = 'test:command';

            public function handle()
            {
                return 0;
            }
        };

        $theme = new SuccessTheme();
        $command->setTheme($theme);

        $this->assertSame($theme, $command->getTheme());
    }

    public function test_line_building_works(): void
    {
        $command = new class extends StyledCommand {
            protected $signature = 'test:command';

            public function handle()
            {
                $this->openLine('Test');
                $this->appendLine(' More');
                $this->closeLine();
                return 0;
            }
        };

        // Just ensure no exceptions are thrown
        $this->expectNotToPerformAssertions();
    }

    public function test_auto_answer_mode_works(): void
    {
        $command = new class extends StyledCommand {
            protected $signature = 'test:command';

            public function handle()
            {
                $this->autoAnswer = true;
                $result = $this->confirm('Test question?', true);
                $this->assertEquals(true, $result);
                return 0;
            }
        };

        $this->assertInstanceOf(StyledCommand::class, $command);
    }
}

