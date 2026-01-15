<?php

namespace IGC\Tart\Tests\Unit;

use IGC\Tart\Support\KeyPress;
use PHPUnit\Framework\TestCase;

class KeyPressTest extends TestCase
{
    public function test_parses_arrow_keys(): void
    {
        $this->assertSame(KeyPress::UP, KeyPress::fromBytes("\x1b[A")->type);
        $this->assertSame(KeyPress::DOWN, KeyPress::fromBytes("\x1b[B")->type);
        $this->assertSame(KeyPress::RIGHT, KeyPress::fromBytes("\x1b[C")->type);
        $this->assertSame(KeyPress::LEFT, KeyPress::fromBytes("\x1b[D")->type);
    }

    public function test_parses_enter_escape_and_space(): void
    {
        $this->assertSame(KeyPress::ENTER, KeyPress::fromBytes("\n")->type);
        $this->assertSame(KeyPress::ESCAPE, KeyPress::fromBytes("\x1b")->type);
        $this->assertSame(KeyPress::SPACE, KeyPress::fromBytes(' ')->type);
    }

    public function test_parses_backspace_variants(): void
    {
        $this->assertSame(KeyPress::BACKSPACE, KeyPress::fromBytes("\x7f")->type);
        $this->assertSame(KeyPress::BACKSPACE, KeyPress::fromBytes("\x08")->type);
    }

    public function test_parses_character_input(): void
    {
        $result = KeyPress::fromBytes('a');

        $this->assertSame(KeyPress::CHAR, $result->type);
        $this->assertSame('a', $result->char);
        $this->assertTrue($result->isChar());
    }
}
