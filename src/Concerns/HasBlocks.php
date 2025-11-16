<?php

namespace Profss\Tart\Concerns;

use Profss\Tart\Support\LineFormatter;

trait HasBlocks
{
    /**
     * Display a block with the given message.
     */
    protected function block(
        string $message,
        string $bgcolor = 'white',
        string $fgcolor = 'black',
        string $bit = ' ',
        bool $big = false,
        string $pad = '  '
    ): void {
        $this->blockLine($bit, $bgcolor, $this->theme->getHighlightColor(), $pad);
        
        if ($big) {
            $this->blockLine(' ', $bgcolor, $fgcolor, $pad);
        }
        
        $centered = LineFormatter::center($message, $this->theme->getMaxLineWidth());
        $this->bline($this->color($centered, $bgcolor, $fgcolor), $this->theme->getColor(), $pad);
        
        if ($big) {
            $this->blockLine(' ', $bgcolor, $fgcolor, $pad);
        }
        
        $this->blockLine($bit, $bgcolor, $this->theme->getHighlightColor(), $pad);
    }

    /**
     * Display a line filled with a character.
     */
    protected function blockLine(string $bit = ' ', string $bgcolor = 'white', string $fgcolor = 'black', string $pad = '  '): void
    {
        $maxLine = $this->theme->getMaxLineWidth();
        $times = (int) ceil($maxLine / strlen($bit));
        $line = '';
        
        if ($times > 0) {
            $line = str_repeat($bit, abs($times));
        }
        
        $line = substr($line, 0, $maxLine);
        $this->bline($this->color($line, $bgcolor, $fgcolor), $this->theme->getColor(), $pad);
    }

    /**
     * Display a header block.
     */
    public function header(string $reportname): void
    {
        $this->block(
            strtoupper($reportname . ' Reporting'),
            $this->theme->getColor(),
            $this->theme->getTextColor(),
            '*',
            true,
            ''
        );
        $this->br();
    }

    /**
     * Display a footer block.
     */
    public function footer(string $reportname, string $timing = ''): void
    {
        if ($timing) {
            $this->stat($timing);
        } else {
            $this->br();
        }
        
        $this->block(
            $reportname . ' Finished',
            $this->theme->getColor(),
            $this->theme->getTextColor(),
            ' ',
            false,
            ''
        );
    }

    /**
     * Display a title block.
     */
    public function title(string $message): void
    {
        $this->block($message, $this->theme->getHighlightColor());
        $this->br();
    }

    /**
     * Display a success block.
     */
    public function success(string $message): void
    {
        $this->block($message, 'green');
        $this->br();
    }

    /**
     * Display a notice block.
     */
    public function notice(string $message): void
    {
        $this->block($message, 'cyan');
        $this->br();
    }

    /**
     * Display a stat block.
     */
    public function stat(string $message): void
    {
        $this->block($message, 'black', 'blue');
        $this->br();
    }

    /**
     * Display a warning block.
     */
    public function warning(string $message): void
    {
        $this->block($message, 'red');
        $this->br();
    }

    /**
     * Display a failure block.
     */
    public function failure(string $message): void
    {
        $this->block($message, 'white', 'red');
        $this->br();
    }

    /**
     * Display colored blocks (visual effect).
     */
    protected function colorBlocks(int $lines = 8): void
    {
        $colors = $this->theme->getColors();
        
        for ($r = 0; $r < $lines; ++$r) {
            $rw = '';
            for ($c = 0; $c < 40; ++$c) {
                shuffle($colors);
                $color = $colors[0];
                $rw .= "<bg={$color}>  </bg={$color}>";
            }
            $this->line($rw);
        }
    }
}

