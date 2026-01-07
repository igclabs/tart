<?php

namespace IGC\Tart\Tests\Unit;

use IGC\Tart\Support\Table;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\BufferedOutput;

class TableTest extends TestCase
{
    public function test_table_renders_headers_and_rows(): void
    {
        $output = new BufferedOutput();
        $table = new Table($output);

        $table->setHeaders(['Name', 'Status'])
            ->addRow(['Database', 'Online'])
            ->addRow(['API', 'Offline'])
            ->render();

        $content = $output->fetch();

        $this->assertStringContainsString('Name', $content);
        $this->assertStringContainsString('Status', $content);
        $this->assertStringContainsString('Database', $content);
        $this->assertStringContainsString('API', $content);
    }

    public function test_table_calculates_column_widths(): void
    {
        $output = new BufferedOutput();
        $table = new Table($output);

        $table->setHeaders(['Short', 'VeryLongHeader'])
            ->addRow(['A', 'B'])
            ->render();

        $content = $output->fetch();

        $this->assertStringContainsString('VeryLongHeader', $content);
    }

    public function test_empty_table_renders_nothing(): void
    {
        $output = new BufferedOutput();
        $table = new Table($output);

        $table->render();

        $this->assertEmpty($output->fetch());
    }
}
