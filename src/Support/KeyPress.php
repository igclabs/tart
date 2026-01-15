<?php

namespace IGC\Tart\Support;

class KeyPress
{
    public const UP = 'up';
    public const DOWN = 'down';
    public const LEFT = 'left';
    public const RIGHT = 'right';
    public const ENTER = 'enter';
    public const ESCAPE = 'escape';
    public const BACKSPACE = 'backspace';
    public const SPACE = 'space';
    public const CHAR = 'char';

    public string $type;
    public ?string $char;

    public function __construct(string $type, ?string $char = null)
    {
        $this->type = $type;
        $this->char = $char;
    }

    public static function fromBytes(string $bytes): self
    {
        if ($bytes === "\n" || $bytes === "\r") {
            return new self(self::ENTER);
        }

        if ($bytes === "\x7f" || $bytes === "\x08") {
            return new self(self::BACKSPACE);
        }

        if ($bytes === ' ') {
            return new self(self::SPACE);
        }

        if ($bytes === "\x1b[A") {
            return new self(self::UP);
        }

        if ($bytes === "\x1b[B") {
            return new self(self::DOWN);
        }

        if ($bytes === "\x1b[C") {
            return new self(self::RIGHT);
        }

        if ($bytes === "\x1b[D") {
            return new self(self::LEFT);
        }

        if ($bytes === "\x1b") {
            return new self(self::ESCAPE);
        }

        if ($bytes !== '') {
            return new self(self::CHAR, $bytes);
        }

        return new self(self::CHAR, '');
    }

    public function isChar(): bool
    {
        return $this->type === self::CHAR && $this->char !== null;
    }
}
