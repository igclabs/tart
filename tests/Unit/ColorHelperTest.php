<?php

namespace IGC\Tart\Tests\Unit;

use PHPUnit\Framework\TestCase;
use IGC\Tart\Support\ColorHelper;

class ColorHelperTest extends TestCase
{
    public function test_bg_wraps_message_with_background_tag(): void
    {
        $result = ColorHelper::bg('Test', 'red');
        
        $this->assertEquals('<bg=red>Test</bg=red>', $result);
    }

    public function test_fg_wraps_message_with_foreground_tag(): void
    {
        $result = ColorHelper::fg('Test', 'blue');
        
        $this->assertEquals('<fg=blue>Test</fg=blue>', $result);
    }

    public function test_color_wraps_message_with_both_tags(): void
    {
        $result = ColorHelper::color('Test', 'red', 'white');
        
        $this->assertEquals('<bg=red;fg=white>Test</fg=white;bg=red>', $result);
    }

    public function test_bold_wraps_message_with_bold_tag(): void
    {
        $result = ColorHelper::bold('Test');
        
        $this->assertEquals('<options=bold>Test</options=bold>', $result);
    }
}

