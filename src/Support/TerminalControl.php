<?php

namespace IGC\Tart\Support;

class TerminalControl
{
    public static function clearScreen(): string
    {
        return "\033[2J";
    }

    public static function home(): string
    {
        return "\033[H";
    }

    public static function clearScreenAndHome(): string
    {
        return "\033[H\033[2J";
    }

    public static function clearLine(): string
    {
        return "\033[K";
    }

    public static function moveCursor(int $row, int $col): string
    {
        return "\033[{$row};{$col}H";
    }

    public static function moveUp(int $lines = 1): string
    {
        return "\033[{$lines}A";
    }

    public static function moveDown(int $lines = 1): string
    {
        return "\033[{$lines}B";
    }

    public static function moveRight(int $columns = 1): string
    {
        return "\033[{$columns}C";
    }

    public static function moveLeft(int $columns = 1): string
    {
        return "\033[{$columns}D";
    }

    public static function hideCursor(): string
    {
        return "\033[?25l";
    }

    public static function showCursor(): string
    {
        return "\033[?25h";
    }

    public static function bold(): string
    {
        return "\033[1m";
    }

    public static function underline(): string
    {
        return "\033[4m";
    }

    public static function reverse(): string
    {
        return "\033[7m";
    }

    public static function reset(): string
    {
        return "\033[0m";
    }
}
