<?php

namespace IGC\Tart\Support;

use Symfony\Component\Console\Output\OutputInterface;

class ProgressBar
{
    protected OutputInterface $output;
    protected int $total;
    protected int $current = 0;
    protected string $label = '';
    protected int $barWidth = 40;
    protected string $barChar = '█';
    protected string $emptyChar = '░';
    protected ?string $bgColor = null;
    protected int $maxLineWidth = 72;

    public function __construct(OutputInterface $output, int $total, string $label = '')
    {
        $this->output = $output;
        $this->total = $total;
        $this->label = $label;
    }

    public function setBgColor(?string $color): self
    {
        $this->bgColor = $color;

        return $this;
    }

    public function setMaxLineWidth(int $width): self
    {
        $this->maxLineWidth = $width;

        return $this;
    }

    public function start(): self
    {
        $this->current = 0;
        $this->render();

        return $this;
    }

    public function advance(int $step = 1): void
    {
        $this->current = min($this->current + $step, $this->total);
        $this->render();
    }

    public function finish(): void
    {
        $this->current = $this->total;
        $this->render();
        $this->output->write("\n");
    }

    protected function render(): void
    {
        $percent = $this->total > 0 ? ($this->current / $this->total) : 0;
        $filledWidth = (int) round($this->barWidth * $percent);
        $emptyWidth = $this->barWidth - $filledWidth;

        $bar = str_repeat($this->barChar, $filledWidth) . str_repeat($this->emptyChar, $emptyWidth);
        $percentText = sprintf('%3d%%', $percent * 100);

        $label = $this->label ? "{$this->label} " : '';
        $content = "{$label}[{$bar}] {$percentText} ({$this->current}/{$this->total})";

        $line = $this->wrapLine($content);
        $this->output->write("\r{$line}");
    }

    protected function wrapLine(string $content): string
    {
        if ($this->bgColor === null) {
            return '  ' . $content . '  ';
        }

        $contentLength = mb_strlen($content, 'UTF-8');
        $paddingNeeded = max(0, $this->maxLineWidth - $contentLength);
        $rightPadding = str_repeat(' ', $paddingNeeded);

        $gap = '  ';
        $pad = '  ';

        return "<bg={$this->bgColor}>{$gap}</bg={$this->bgColor}>{$pad}{$content}{$rightPadding}{$pad}<bg={$this->bgColor}>{$gap}</bg={$this->bgColor}>";
    }
}
