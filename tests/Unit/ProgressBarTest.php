<?php

namespace IGC\Tart\Tests\Unit;

use IGC\Tart\Support\ProgressBar;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\BufferedOutput;

class ProgressBarTest extends TestCase
{
    public function test_progress_bar_starts_at_zero(): void
    {
        $output = new BufferedOutput();
        $bar = new ProgressBar($output, 100);

        $bar->start();

        $content = $output->fetch();
        $this->assertStringContainsString('0%', $content);
        $this->assertStringContainsString('(0/100)', $content);
    }

    public function test_progress_bar_advances(): void
    {
        $output = new BufferedOutput();
        $bar = new ProgressBar($output, 100);

        $bar->start();
        $output->fetch();

        $bar->advance(50);

        $content = $output->fetch();
        $this->assertStringContainsString('50%', $content);
        $this->assertStringContainsString('(50/100)', $content);
    }

    public function test_progress_bar_finishes_at_100_percent(): void
    {
        $output = new BufferedOutput();
        $bar = new ProgressBar($output, 100);

        $bar->start();
        $bar->finish();

        $content = $output->fetch();
        $this->assertStringContainsString('100%', $content);
        $this->assertStringContainsString('(100/100)', $content);
    }

    public function test_progress_bar_with_label(): void
    {
        $output = new BufferedOutput();
        $bar = new ProgressBar($output, 50, 'Processing');

        $bar->start();

        $content = $output->fetch();
        $this->assertStringContainsString('Processing', $content);
    }
}
