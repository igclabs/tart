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

    public function __construct(OutputInterface $output, int $total, string $label = '')
    {
        $this->output = $output;
        $this->total = $total;
        $this->label = $label;
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
        $this->output->writeln('');
    }

    protected function render(): void
    {
        $percent = $this->total > 0 ? ($this->current / $this->total) : 0;
        $filledWidth = (int) round($this->barWidth * $percent);
        $emptyWidth = $this->barWidth - $filledWidth;

        $bar = str_repeat($this->barChar, $filledWidth) . str_repeat($this->emptyChar, $emptyWidth);
        $percentText = sprintf('%3d%%', $percent * 100);

        $label = $this->label ? "{$this->label} " : '';

        $this->output->write("\r{$label}[{$bar}] {$percentText} ({$this->current}/{$this->total})");
    }
}
