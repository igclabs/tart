<?php

namespace IGC\Tart\Tests\Unit;

use IGC\Tart\Support\Spinner;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\BufferedOutput;

class SpinnerTest extends TestCase
{
    public function test_spinner_starts(): void
    {
        $output = new BufferedOutput();
        $spinner = new Spinner($output, 'Loading...');

        $spinner->start();

        $this->assertTrue($spinner->isRunning());
    }

    public function test_spinner_stops(): void
    {
        $output = new BufferedOutput();
        $spinner = new Spinner($output, 'Loading...');

        $spinner->start();
        $spinner->stop();

        $this->assertFalse($spinner->isRunning());
    }

    public function test_spinner_can_change_style(): void
    {
        $output = new BufferedOutput();
        $spinner = new Spinner($output);

        $result = $spinner->setStyle('line');

        $this->assertSame($spinner, $result);
    }

    public function test_spinner_throws_on_invalid_style(): void
    {
        $output = new BufferedOutput();
        $spinner = new Spinner($output);

        $this->expectException(\InvalidArgumentException::class);
        $spinner->setStyle('invalid_style');
    }

    public function test_spinner_renders_frames(): void
    {
        $output = new BufferedOutput();
        $spinner = new Spinner($output, 'Test');

        $spinner->start();
        $spinner->tick();

        $content = $output->fetch();
        $this->assertStringContainsString('Test', $content);
    }
}
