<?php

namespace IGC\Tart\Tests\Unit;

use IGC\Tart\Concerns\HasLists;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\BufferedOutput;

class ListsTest extends TestCase
{
    public function test_bullet_list_renders(): void
    {
        $output = new BufferedOutput();
        $command = new class ($output) {
            use HasLists;

            private $output;

            public function __construct($output)
            {
                $this->output = $output;
            }

            public function say(string $message): void
            {
                $this->output->writeln($message);
            }
        };

        $command->bulletList(['Item 1', 'Item 2']);

        $content = $output->fetch();
        $this->assertStringContainsString('• Item 1', $content);
        $this->assertStringContainsString('• Item 2', $content);
    }

    public function test_ordered_list_renders(): void
    {
        $output = new BufferedOutput();
        $command = new class ($output) {
            use HasLists;

            private $output;

            public function __construct($output)
            {
                $this->output = $output;
            }

            public function say(string $message): void
            {
                $this->output->writeln($message);
            }
        };

        $command->orderedList(['First', 'Second', 'Third']);

        $content = $output->fetch();
        $this->assertStringContainsString('1. First', $content);
        $this->assertStringContainsString('2. Second', $content);
        $this->assertStringContainsString('3. Third', $content);
    }

    public function test_task_list_renders(): void
    {
        $output = new BufferedOutput();
        $command = new class ($output) {
            use HasLists;

            private $output;

            public function __construct($output)
            {
                $this->output = $output;
            }

            public function say(string $message): void
            {
                $this->output->writeln($message);
            }

            public function bline(string $line, string $color): void
            {
                $this->output->writeln($line);
            }
        };

        $command->taskList(['✓ Done', '✗ Failed', '• Pending']);

        $content = $output->fetch();
        $this->assertStringContainsString('✓ Done', $content);
        $this->assertStringContainsString('✗ Failed', $content);
        $this->assertStringContainsString('• Pending', $content);
    }
}
