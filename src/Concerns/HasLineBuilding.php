<?php

namespace IGC\Tart\Concerns;

use IGC\Tart\Support\LineFormatter;

trait HasLineBuilding
{
    protected bool $active = false;
    protected string $activeLine = '';

    /**
     * Open a line for building (can append to it).
     */
    public function openLine(string $start): void
    {
        $this->active = true;
        $start = LineFormatter::pad($start, 30);
        $this->activeLine = $start;
        $output = $this->getOutput();
        $output->write($this->startLine($start));
    }

    /**
     * Append text to the current open line.
     */
    public function appendLine(string $text, string $color = 'white'): void
    {
        $this->activeLine .= $text;
        $output = $this->getOutput();
        $output->write($this->fg($text, $color));
    }

    /**
     * Close the current open line.
     */
    public function closeLine(): void
    {
        $output = $this->getOutput();
        $output->write($this->finishLine($this->activeLine));
        $this->active = false;
        $this->activeLine = '';
    }

    /**
     * Add a column to the current line.
     */
    public function addColumn(string $text, int $size, string $color = 'white'): void
    {
        $text = LineFormatter::pad($text, $size);
        $text = substr($text, 0, $size);
        $this->appendLine($text, $color);
    }
}

