<?php

namespace IGC\Tart\Themes;

use IGC\Tart\Contracts\ThemeInterface;

class Theme implements ThemeInterface
{
    protected string $color;
    protected string $textColor;
    protected string $highlightColor;
    protected int $maxLineWidth;
    protected array $colors;

    public function __construct(
        string $color = 'blue',
        string $textColor = 'white',
        string $highlightColor = 'yellow',
        int $maxLineWidth = 72,
        array $colors = ['red', 'green', 'yellow', 'cyan', 'white']
    ) {
        $this->color = $color;
        $this->textColor = $textColor;
        $this->highlightColor = $highlightColor;
        $this->maxLineWidth = $maxLineWidth;
        $this->colors = $colors;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function getTextColor(): string
    {
        return $this->textColor;
    }

    public function getHighlightColor(): string
    {
        return $this->highlightColor;
    }

    public function getMaxLineWidth(): int
    {
        return $this->maxLineWidth;
    }

    public function getColors(): array
    {
        return $this->colors;
    }
}

