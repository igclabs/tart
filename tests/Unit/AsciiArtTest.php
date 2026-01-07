<?php

namespace IGC\Tart\Tests\Unit;

use IGC\Tart\Support\AsciiArt;
use PHPUnit\Framework\TestCase;

class AsciiArtTest extends TestCase
{
    public function test_text_logo_respects_header_footer_and_padding_options(): void
    {
        $options = [
            'header_lines' => 1,
            'footer_lines' => 2,
            'padding_top' => 0,
            'padding_bottom' => 0,
            'blocks_per_line' => 1,
            'colors' => ['magenta'],
            'width' => 20,
        ];

        $lines = AsciiArt::createTextLogo('APP', $options);

        // header + padding + content + padding + footer
        $expectedLineCount = 1 + 0 + 1 + 0 + 2;
        $this->assertCount($expectedLineCount, $lines);
        $this->assertStringContainsString('<bg=magenta>', $lines[0]);
        $this->assertStringContainsString('<bg=magenta>', $lines[array_key_last($lines)]);
    }

    public function test_banner_logo_honors_custom_padding(): void
    {
        $options = [
            'style' => 'banner',
            'padding_top' => 2,
            'padding_bottom' => 2,
            'header_lines' => 0,
            'footer_lines' => 0,
            'width' => 30,
        ];

        $lines = AsciiArt::createTextLogo('APP', $options);

        $this->assertStringContainsString('<igc>', $lines[0]);
        $this->assertStringContainsString('<igc>', $lines[1]);
        // Center line should include the text itself
        $this->assertStringContainsString('APP', $lines[3]);
    }

    public function test_multi_line_logo_uses_custom_block_count(): void
    {
        $options = [
            'header_lines' => 1,
            'footer_lines' => 0,
            'blocks_per_line' => 2,
            'colors' => ['cyan'],
            'width' => 10,
        ];

        $logo = <<<ASCII
AB
ASCII;

        $lines = AsciiArt::createMultiLineLogo($logo, $options);

        $this->assertStringContainsString('<bg=cyan>  </bg=cyan><bg=cyan>  </bg=cyan>', $lines[0]);
    }
}
