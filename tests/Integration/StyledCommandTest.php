<?php

namespace IGC\Tart\Tests\Integration;

use IGC\Tart\Laravel\StyledCommand;
use IGC\Tart\Themes\SuccessTheme;
use IGC\Tart\Themes\Theme;
use Orchestra\Testbench\TestCase;

class StyledCommandTest extends TestCase
{
    public function test_styled_command_can_be_instantiated(): void
    {
        $command = new class () extends StyledCommand {
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
        $command = new class () extends StyledCommand {
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
        $command = new class () extends StyledCommand {
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
        $command = new class () extends StyledCommand {
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

    public function test_theme_can_be_configured_via_config_file(): void
    {
        config()->set('tart.theme', [
            'class' => Theme::class,
            'color' => 'magenta',
            'text_color' => 'white',
            'highlight_color' => 'yellow',
            'max_line_width' => 100,
            'colors' => ['magenta', 'white'],
        ]);

        $command = new class () extends StyledCommand {
            protected $signature = 'test:command';

            public function handle()
            {
                return 0;
            }
        };

        $theme = $command->getTheme();

        $this->assertEquals('magenta', $theme->getColor());
        $this->assertEquals('white', $theme->getTextColor());
        $this->assertEquals(100, $theme->getMaxLineWidth());
    }

    public function test_auto_answer_default_can_be_configured(): void
    {
        config()->set('tart.auto_answer', true);

        $command = new class () extends StyledCommand {
            protected $signature = 'test:command';

            public function handle()
            {
                return 0;
            }
        };

        $this->assertTrue($command->autoAnswer);
    }
}
