<?php

namespace IGC\Tart\Concerns;

use IGC\Tart\Support\ColorHelper;
use IGC\Tart\Support\LineFormatter;

trait HasColoredOutput
{
    /**
     * Prepare a line with color formatting.
     */
    protected function prepLine(string $line, string $text = 'white', string $pad = '  ', string $gap = '  '): string
    {
        $line = LineFormatter::pad($line, $this->theme->getMaxLineWidth());
        
        if ($pad === '') {
            $gap .= '  ';
        }

        $color = $this->theme->getColor();
        
        return "<bg={$color}>{$gap}</bg={$color}>{$pad}<fg={$text}>{$line}</fg={$text}>{$pad}<bg={$color}>{$gap}</bg={$color}>";
    }

    /**
     * Start a line (opening tag).
     */
    protected function startLine(string $line, string $text = 'white', string $pad = '  ', string $gap = '  '): string
    {
        if ($pad === '') {
            $gap .= '  ';
        }

        $color = $this->theme->getColor();
        
        return "<bg={$color}>{$gap}</bg={$color}>{$pad}<fg={$text}>{$line}";
    }

    /**
     * Finish a line (closing tag).
     */
    protected function finishLine(string $line, string $text = 'white', string $pad = '  ', string $gap = '  '): string
    {
        if ($pad === '') {
            $gap .= '  ';
        }

        $color = $this->theme->getColor();
        
        return LineFormatter::padding($line, $this->theme->getMaxLineWidth()) . "</fg={$text}>{$pad}<bg={$color}>{$gap}</bg={$color}>" . PHP_EOL;
    }

    /**
     * Output a basic line with color.
     */
    protected function bline(string $line, string $text = 'white', string $pad = '  ', string $gap = '  '): void
    {
        $line = $this->prepLine($line, $text, $pad, $gap);
        
        if ($this->active) {
            $this->closeLine();
        }
        
        $this->line($line);
    }

    /**
     * Apply background color to a message.
     */
    protected function bg(string $message, string $color): string
    {
        return ColorHelper::bg($message, $color);
    }

    /**
     * Apply foreground color to a message.
     */
    protected function fg(string $message, string $color): string
    {
        return ColorHelper::fg($message, $color);
    }

    /**
     * Apply both colors to a message.
     */
    protected function color(string $message, string $bgcolor, string $fgcolor): string
    {
        return ColorHelper::color($message, $bgcolor, $fgcolor);
    }

    /**
     * Make text bold.
     */
    protected function bold(string $message): string
    {
        return ColorHelper::bold($message);
    }

    /**
     * Highlight a file path.
     */
    public function pathHighlight(string $path): string
    {
        return LineFormatter::highlightPath($path);
    }

    /**
     * Display a horizontal rule.
     */
    public function hr(): void
    {
        $this->bline(str_repeat('-', $this->theme->getMaxLineWidth()));
    }

    /**
     * Display one or more blank lines.
     */
    public function br(int $n = 1): void
    {
        for ($i = 0; $i < $n; ++$i) {
            $this->bline(' ');
        }
    }

    /**
     * Display a regular white line.
     */
    public function say(string $message): void
    {
        $this->bline($message);
    }

    /**
     * Display a green line (positive message).
     */
    public function good(string $message): void
    {
        $this->bline($message, 'green');
    }

    /**
     * Display a yellow line (state message).
     */
    public function state(string $message): void
    {
        $this->bline(substr($message, -$this->theme->getMaxLineWidth()), 'yellow');
    }

    /**
     * Display a red line (error message).
     */
    public function bad(string $error): void
    {
        $parts = explode('#2', $error);
        $error = $parts[0];
        $maxLine = $this->theme->getMaxLineWidth();
        
        foreach (explode("\n", $error) as $message) {
            foreach (str_split($message, $maxLine - 1) as $m) {
                $m .= ' ';
                $m = str_pad($m, $maxLine - 1, ' ', STR_PAD_RIGHT);
                $this->bline($m, 'red');
            }
        }
    }

    /**
     * Display a cyan line (cool message).
     */
    public function cool(string $message): void
    {
        $this->bline($this->color($message, 'blue', 'cyan'));
    }
}

