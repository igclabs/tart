<?php

namespace IGC\Tart\Tests\Unit;

use IGC\Tart\Support\Select;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\BufferedOutput;

class SelectTest extends TestCase
{
    public function test_select_returns_default_in_non_interactive_mode(): void
    {
        $output = new BufferedOutput();

        $options = [
            'local' => 'Local Development',
            'staging' => 'Staging Server',
            'production' => 'Production',
        ];

        $select = new Select($output, 'Choose environment', $options, 'staging');
        $result = $select->ask();

        $this->assertSame('staging', $result);
    }

    public function test_select_returns_first_option_when_no_default(): void
    {
        $output = new BufferedOutput();

        $options = [
            'option1' => 'First Option',
            'option2' => 'Second Option',
        ];

        $select = new Select($output, 'Choose option', $options);
        $result = $select->ask();

        $this->assertSame('option1', $result);
    }

    public function test_select_returns_null_for_empty_options(): void
    {
        $output = new BufferedOutput();

        $select = new Select($output, 'Choose option', []);
        $result = $select->ask();

        $this->assertNull($result);
    }

    public function test_select_can_set_required(): void
    {
        $output = new BufferedOutput();

        $options = ['a' => 'Option A', 'b' => 'Option B'];

        $select = new Select($output, 'Choose', $options);
        $select->setRequired(true);

        $this->assertInstanceOf(Select::class, $select);
    }
}
