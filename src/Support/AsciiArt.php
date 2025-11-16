<?php

namespace IGC\Tart\Support;

class AsciiArt
{
    /**
     * Create a logo with automatic header and footer decoration.
     *
     * @param array $lines Array of text lines for the logo
     * @param array $options Configuration options
     * @return array Array of formatted lines ready for output
     */
    public static function createLogo(array $lines, array $options = []): array
    {
        $defaults = [
            'header_lines' => 3,           // Number of random color block lines above
            'footer_lines' => 3,           // Number of random color block lines below
            'padding_top' => 1,            // Blank lines before logo text
            'padding_bottom' => 1,         // Blank lines after logo text
            'colors' => ['red', 'green', 'yellow', 'cyan', 'white'], // Colors for decoration
            'width' => 80,                 // Width of the logo area
            'blocks_per_line' => 40,       // Number of color blocks per line
        ];

        $config = array_merge($defaults, $options);
        $output = [];

        // Header decoration
        if ($config['header_lines'] > 0) {
            $output = array_merge($output, self::generateColorBlocks(
                $config['header_lines'],
                $config['blocks_per_line'],
                $config['colors']
            ));
        }

        // Top padding
        for ($i = 0; $i < $config['padding_top']; $i++) {
            $output[] = self::createBlankLine($config['width']);
        }

        // Logo lines
        foreach ($lines as $line) {
            $output[] = self::padLine($line, $config['width']);
        }

        // Bottom padding
        for ($i = 0; $i < $config['padding_bottom']; $i++) {
            $output[] = self::createBlankLine($config['width']);
        }

        // Footer decoration
        if ($config['footer_lines'] > 0) {
            $output = array_merge($output, self::generateColorBlocks(
                $config['footer_lines'],
                $config['blocks_per_line'],
                $config['colors']
            ));
        }

        return $output;
    }

    /**
     * Generate random colored block lines for decoration.
     */
    protected static function generateColorBlocks(int $lines, int $blocksPerLine, array $colors): array
    {
        $output = [];

        for ($r = 0; $r < $lines; $r++) {
            $line = '';
            for ($c = 0; $c < $blocksPerLine; $c++) {
                $color = $colors[array_rand($colors)];
                $line .= "<bg={$color}>  </bg={$color}>";
            }
            $output[] = $line;
        }

        return $output;
    }

    /**
     * Create a blank line with the specified width.
     */
    protected static function createBlankLine(int $width): string
    {
        return '<igc>' . str_repeat(' ', $width) . '</igc>';
    }

    /**
     * Pad a line to the specified width.
     */
    protected static function padLine(string $line, int $width): string
    {
        $visualLength = LineFormatter::visualLength($line);
        $padding = max(0, $width - $visualLength);
        
        return '<igc>' . $line . str_repeat(' ', $padding) . '</igc>';
    }

    /**
     * Create a simple text logo with automatic styling.
     *
     * @param string $text The text to display
     * @param array $options Configuration options
     * @return array Array of formatted lines
     */
    public static function createTextLogo(string $text, array $options = []): array
    {
        $defaults = [
            'style' => 'standard',         // standard, box, banner
            'colors' => ['red', 'green', 'yellow', 'cyan', 'white'],
            'text_color' => 'white',
            'width' => 80,
        ];

        $config = array_merge($defaults, $options);

        switch ($config['style']) {
            case 'box':
                return self::createBoxedTextLogo($text, $config);
            case 'banner':
                return self::createBannerTextLogo($text, $config);
            default:
                return self::createStandardTextLogo($text, $config);
        }
    }

    /**
     * Create a standard text logo (just the text with decoration).
     */
    protected static function createStandardTextLogo(string $text, array $config): array
    {
        $textLine = "<options=bold><fg={$config['text_color']}>{$text}</fg={$config['text_color']}></options=bold>";
        $centered = LineFormatter::center($textLine, $config['width']);

        return self::createLogo([$centered], [
            'colors' => $config['colors'],
            'width' => $config['width'],
        ]);
    }

    /**
     * Create a boxed text logo.
     */
    protected static function createBoxedTextLogo(string $text, array $config): array
    {
        $textLength = mb_strlen($text, 'UTF-8');
        $boxWidth = $textLength + 4; // 2 spaces padding on each side
        
        $topLine = '╔' . str_repeat('═', $boxWidth) . '╗';
        $textLine = '║  ' . "<options=bold><fg={$config['text_color']}>{$text}</fg={$config['text_color']}></options=bold>" . '  ║';
        $bottomLine = '╚' . str_repeat('═', $boxWidth) . '╝';

        return self::createLogo([
            LineFormatter::center($topLine, $config['width']),
            LineFormatter::center($textLine, $config['width']),
            LineFormatter::center($bottomLine, $config['width']),
        ], [
            'colors' => $config['colors'],
            'width' => $config['width'],
        ]);
    }

    /**
     * Create a banner style text logo.
     */
    protected static function createBannerTextLogo(string $text, array $config): array
    {
        $separator = str_repeat('━', $config['width']);
        $textLine = "<options=bold><fg={$config['text_color']}>{$text}</fg={$config['text_color']}></options=bold>";
        $centered = LineFormatter::center($textLine, $config['width']);

        return self::createLogo([
            $separator,
            $centered,
            $separator,
        ], [
            'colors' => $config['colors'],
            'width' => $config['width'],
            'padding_top' => 0,
            'padding_bottom' => 0,
        ]);
    }

    /**
     * Create a multi-line ASCII art logo.
     *
     * @param string $asciiArt Multi-line ASCII art string
     * @param array $options Configuration options
     * @return array Array of formatted lines
     */
    public static function createMultiLineLogo(string $asciiArt, array $options = []): array
    {
        $lines = explode("\n", $asciiArt);
        
        $defaults = [
            'colors' => ['red', 'green', 'yellow', 'cyan', 'white'],
            'width' => 80,
        ];

        $config = array_merge($defaults, $options);

        // Process each line
        $processedLines = array_map(function($line) use ($config) {
            return self::padLine($line, $config['width']);
        }, $lines);

        return self::createLogo($processedLines, [
            'colors' => $config['colors'],
            'width' => $config['width'],
        ]);
    }

    /**
     * Create a gradient color block decoration.
     *
     * @param int $lines Number of lines
     * @param array $colors Colors to use
     * @return array Array of formatted lines
     */
    public static function createGradientBlocks(int $lines, array $colors = null): array
    {
        if ($colors === null) {
            $colors = ['red', 'yellow', 'green', 'cyan', 'blue', 'magenta'];
        }

        $output = [];
        $colorCount = count($colors);

        for ($r = 0; $r < $lines; $r++) {
            $line = '';
            // Create a gradient effect
            for ($c = 0; $c < 40; $c++) {
                $colorIndex = (int) floor(($c / 40) * $colorCount);
                $color = $colors[$colorIndex % $colorCount];
                $line .= "<bg={$color}>  </bg={$color}>";
            }
            $output[] = $line;
        }

        return $output;
    }

    /**
     * Create a repeating pattern decoration.
     *
     * @param int $lines Number of lines
     * @param string $pattern Pattern character(s)
     * @param string $color Color for the pattern
     * @param int $width Width of the line
     * @return array Array of formatted lines
     */
    public static function createPatternDecoration(
        int $lines,
        string $pattern = '═',
        string $color = 'cyan',
        int $width = 80
    ): array {
        $output = [];
        
        for ($i = 0; $i < $lines; $i++) {
            $patternLength = mb_strlen($pattern, 'UTF-8');
            $repetitions = (int) ceil($width / $patternLength);
            $line = str_repeat($pattern, $repetitions);
            $line = mb_substr($line, 0, $width, 'UTF-8');
            
            $output[] = "<fg={$color}>{$line}</fg={$color}>";
        }

        return $output;
    }
}

