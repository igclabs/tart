<?php

namespace IGC\Tart\Support;

class ColorHelper
{
    /**
     * Apply a background color to a message.
     */
    public static function bg(string $message, string $color): string
    {
        return "<bg={$color}>{$message}</bg={$color}>";
    }

    /**
     * Apply a foreground color to a message.
     */
    public static function fg(string $message, string $color): string
    {
        return "<fg={$color}>{$message}</fg={$color}>";
    }

    /**
     * Apply both background and foreground colors to a message.
     */
    public static function color(string $message, string $bgcolor, string $fgcolor): string
    {
        return "<bg={$bgcolor};fg={$fgcolor}>{$message}</fg={$fgcolor};bg={$bgcolor}>";
    }

    /**
     * Make text bold.
     */
    public static function bold(string $message): string
    {
        return "<options=bold>{$message}</options=bold>";
    }
}
