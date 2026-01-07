<?php

namespace IGC\Tart\Support;

class LineFormatter
{
    /**
     * Get the visual length of a string (handles multi-byte characters like emojis).
     * Strips ANSI color codes before measuring.
     */
    public static function visualLength(string $string): int
    {
        // Strip ANSI color codes
        $stripped = strip_tags($string);
        $stripped = preg_replace('/\x1b\[[0-9;]*m/', '', $stripped);

        // Use mb_strlen for proper multi-byte character counting
        return mb_strlen($stripped, 'UTF-8');
    }

    /**
     * Pad a line to the specified maximum length.
     */
    public static function pad(string $line, int $max): string
    {
        $line .= self::padding($line, $max);
        $length = self::visualLength($line);

        if ($length > $max) {
            $line = mb_substr($line, 0, $max, 'UTF-8');
        }

        return $line;
    }

    /**
     * Generate padding for a line.
     */
    public static function padding(string $line, int $max): string
    {
        $length = self::visualLength($line);

        if ($length < $max && ($max - $length) > 0) {
            return str_repeat(' ', abs($max - $length));
        }

        return '';
    }

    /**
     * Center a message within the given width.
     */
    public static function center(string $message, int $maxWidth): string
    {
        $mlen = self::visualLength($message);
        $spare = $maxWidth - $mlen;
        $half = $spare / 2;
        $padl = str_repeat(' ', abs((int) ceil($half)));
        $padr = str_repeat(' ', abs((int) floor($half)));

        return $padl . $message . $padr;
    }

    /**
     * Highlight a file path with colors.
     */
    public static function highlightPath(string $path): string
    {
        $tokens = preg_split('/(\/|\\\\)/', $path, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

        // Handle preg_split failure
        if ($tokens === false) {
            return $path;
        }

        $segments = array_values(array_filter($tokens, fn ($token) => $token !== '/' && $token !== '\\'));
        $totalSegments = count($segments);
        $segmentIndex = 0;
        $output = '';

        foreach ($tokens as $token) {
            if ($token === '/' || $token === '\\') {
                $output .= "<fg=yellow>{$token}</fg=yellow>";

                continue;
            }

            $segmentIndex++;
            $color = ($segmentIndex === $totalSegments) ? 'white' : 'cyan';
            $output .= "<fg={$color}>{$token}</fg={$color}>";
        }

        return $output;
    }
}
