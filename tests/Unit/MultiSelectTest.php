<?php

namespace IGC\Tart\Tests\Unit;

use IGC\Tart\Support\MultiSelect;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\BufferedOutput;

class MultiSelectTest extends TestCase
{
    public function test_multiselect_returns_defaults_in_non_interactive_mode(): void
    {
        $output = new BufferedOutput();

        $options = [
            'api' => 'API Access',
            'admin' => 'Admin Panel',
            'reports' => 'Reporting',
        ];

        $multiSelect = new MultiSelect($output, 'Choose features', $options, ['api', 'admin']);
        $result = $multiSelect->ask();

        $this->assertSame(['api', 'admin'], $result);
    }

    public function test_multiselect_returns_empty_array_when_no_defaults(): void
    {
        $output = new BufferedOutput();

        $options = [
            'option1' => 'First Option',
            'option2' => 'Second Option',
        ];

        $multiSelect = new MultiSelect($output, 'Choose options', $options);
        $result = $multiSelect->ask();

        $this->assertSame([], $result);
    }

    public function test_multiselect_returns_empty_array_for_empty_options(): void
    {
        $output = new BufferedOutput();

        $multiSelect = new MultiSelect($output, 'Choose options', []);
        $result = $multiSelect->ask();

        $this->assertSame([], $result);
    }

    public function test_multiselect_can_set_min_required(): void
    {
        $output = new BufferedOutput();

        $options = ['a' => 'Option A', 'b' => 'Option B'];

        $multiSelect = new MultiSelect($output, 'Choose', $options);
        $multiSelect->setMinRequired(1);

        $this->assertInstanceOf(MultiSelect::class, $multiSelect);
    }

    public function test_multiselect_filters_invalid_defaults(): void
    {
        $output = new BufferedOutput();

        $options = [
            'valid1' => 'Valid Option 1',
            'valid2' => 'Valid Option 2',
        ];

        $multiSelect = new MultiSelect($output, 'Choose', $options, ['valid1', 'invalid', 'valid2']);
        $result = $multiSelect->ask();

        $this->assertSame(['valid1', 'valid2'], $result);
    }
}
