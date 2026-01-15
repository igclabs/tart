<?php

namespace IGC\Tart\Support;

use IGC\Tart\Contracts\ThemeInterface;
use IGC\Tart\Themes\DefaultTheme;
use Symfony\Component\Console\Output\OutputInterface;

class FrameRenderer
{
    private OutputInterface $output;
    private ThemeInterface $theme;
    private string $pad;
    private string $gap;

    public function __construct(OutputInterface $output, ?ThemeInterface $theme = null, string $pad = '  ', string $gap = '  ')
    {
        $this->output = $output;
        $this->theme = $theme ?? new DefaultTheme();
        $this->pad = $pad;
        $this->gap = $gap;
    }

    public function format(string $content, ?string $textColor = null, ?string $bgColor = null): string
    {
        $line = LineFormatter::pad($content, $this->theme->getMaxLineWidth());

        if ($bgColor !== null) {
            $textColor = $textColor ?? $this->theme->getTextColor();
            $line = sprintf('<fg=%s;bg=%s>%s</>', $textColor, $bgColor, $line);
        } elseif ($textColor !== null) {
            $line = "<fg={$textColor}>{$line}</fg={$textColor}>";
        }

        $gap = ($this->pad === '') ? $this->gap . '  ' : $this->gap;
        $borderColor = $this->theme->getColor();

        return "<bg={$borderColor}>{$gap}</bg={$borderColor}>{$this->pad}{$line}{$this->pad}<bg={$borderColor}>{$gap}</bg={$borderColor}>";
    }

    public function writeln(string $content, ?string $textColor = null, ?string $bgColor = null): void
    {
        $this->output->writeln($this->format($content, $textColor, $bgColor));
    }

    public function writeStart(string $content): void
    {
        $gap = ($this->pad === '') ? $this->gap . '  ' : $this->gap;
        $borderColor = $this->theme->getColor();

        $this->output->write("<bg={$borderColor}>{$gap}</bg={$borderColor}>{$this->pad}{$content}");
    }

    public function writeFinish(string $content): void
    {
        $gap = ($this->pad === '') ? $this->gap . '  ' : $this->gap;
        $borderColor = $this->theme->getColor();
        $padding = LineFormatter::padding($content, $this->theme->getMaxLineWidth());

        $this->output->write($padding . "{$this->pad}<bg={$borderColor}>{$gap}</bg={$borderColor}>" . PHP_EOL);
    }
}
