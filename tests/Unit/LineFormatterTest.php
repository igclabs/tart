<?php

namespace IGC\Tart\Tests\Unit;

use IGC\Tart\Support\LineFormatter;
use PHPUnit\Framework\TestCase;

class LineFormatterTest extends TestCase
{
    public function test_padding_adds_correct_spaces(): void
    {
        $line = 'Hello';
        $result = LineFormatter::padding($line, 10);

        $this->assertEquals(5, strlen($result));
        $this->assertEquals('     ', $result);
    }

    public function test_padding_returns_empty_when_line_is_longer(): void
    {
        $line = 'Hello World!';
        $result = LineFormatter::padding($line, 5);

        $this->assertEquals('', $result);
    }

    public function test_pad_adds_padding_to_line(): void
    {
        $line = 'Test';
        $result = LineFormatter::pad($line, 10);

        $this->assertEquals(10, strlen(strip_tags($result)));
    }

    public function test_center_centers_text(): void
    {
        $message = 'Test';
        $result = LineFormatter::center($message, 12);

        $this->assertEquals(12, strlen($result));
        $this->assertStringContainsString('Test', $result);
    }

    public function test_highlight_path_formats_correctly(): void
    {
        $path = '/var/www/app.php';
        $result = LineFormatter::highlightPath($path);

        $this->assertStringContainsString('app.php', $result);
        $this->assertStringContainsString('<fg=', $result);

        $windowsPath = 'C:\\Users\\demo\\app.php';
        $windowsResult = LineFormatter::highlightPath($windowsPath);
        $this->assertStringContainsString('<fg=yellow>\\</fg=yellow>', $windowsResult);
        $this->assertStringContainsString('demo', $windowsResult);
    }

    public function test_visual_length_handles_emojis(): void
    {
        // Single-byte characters
        $this->assertEquals(5, LineFormatter::visualLength('Hello'));

        // Multi-byte emoji characters (should count as 1 each)
        $this->assertEquals(1, LineFormatter::visualLength('✓'));
        $this->assertEquals(1, LineFormatter::visualLength('✗'));
        $this->assertEquals(1, LineFormatter::visualLength('⚠'));
        $this->assertEquals(1, LineFormatter::visualLength('ℹ'));
        $this->assertEquals(1, LineFormatter::visualLength('🎉'));

        // Mixed text and emoji
        $this->assertEquals(6, LineFormatter::visualLength('✓ Done'));
        $this->assertEquals(13, LineFormatter::visualLength('✓ Step 1 done'));
    }

    public function test_visual_length_strips_ansi_codes(): void
    {
        // With ANSI color codes
        $colored = '<fg=green>Hello</fg=green>';
        $this->assertEquals(5, LineFormatter::visualLength($colored));

        // With ANSI escape sequences
        $ansi = "\x1b[32mHello\x1b[0m";
        $this->assertEquals(5, LineFormatter::visualLength($ansi));
    }

    public function test_padding_with_emojis(): void
    {
        $line = '✓ Success';
        $result = LineFormatter::padding($line, 15);

        // Should pad to the remaining visual characters
        $expectedPadding = 15 - LineFormatter::visualLength($line);
        $this->assertEquals($expectedPadding, strlen($result));
        $this->assertEquals(15, LineFormatter::visualLength($line . $result));
    }

    public function test_center_with_emojis(): void
    {
        $message = '✓ Done';
        $result = LineFormatter::center($message, 20);

        // Should be centered within 20 characters
        $this->assertEquals(20, LineFormatter::visualLength($result));
        $this->assertStringContainsString('✓ Done', $result);
    }
}
