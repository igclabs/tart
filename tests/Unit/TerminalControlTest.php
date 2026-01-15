<?php

namespace IGC\Tart\Tests\Unit;

use IGC\Tart\Support\TerminalControl;
use PHPUnit\Framework\TestCase;

class TerminalControlTest extends TestCase
{
    public function test_clear_and_home_sequences(): void
    {
        $this->assertSame("\033[2J", TerminalControl::clearScreen());
        $this->assertSame("\033[H", TerminalControl::home());
        $this->assertSame("\033[H\033[2J", TerminalControl::clearScreenAndHome());
    }

    public function test_cursor_movement_sequences(): void
    {
        $this->assertSame("\033[5;10H", TerminalControl::moveCursor(5, 10));
        $this->assertSame("\033[2A", TerminalControl::moveUp(2));
        $this->assertSame("\033[3B", TerminalControl::moveDown(3));
        $this->assertSame("\033[4C", TerminalControl::moveRight(4));
        $this->assertSame("\033[5D", TerminalControl::moveLeft(5));
    }

    public function test_cursor_visibility_sequences(): void
    {
        $this->assertSame("\033[?25l", TerminalControl::hideCursor());
        $this->assertSame("\033[?25h", TerminalControl::showCursor());
    }

    public function test_text_styles(): void
    {
        $this->assertSame("\033[1m", TerminalControl::bold());
        $this->assertSame("\033[4m", TerminalControl::underline());
        $this->assertSame("\033[7m", TerminalControl::reverse());
        $this->assertSame("\033[0m", TerminalControl::reset());
    }
}
