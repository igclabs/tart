<?php

namespace IGC\Tart\Themes;

use IGC\Tart\Contracts\ThemeInterface;

class Theme implements ThemeInterface
{
    protected string $color;
    protected string $textColor;
    protected string $highlightColor;
    protected int $maxLineWidth;
    /** @var array<string> */
    protected array $colors;

    /**
     * @param array<string> $colors
     */
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

    /**
     * @return array<string>
     */
    public function getColors(): array
    {
        return $this->colors;
    }

    /**
     * Set the primary color and return self for method chaining.
     */
    public function withColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Set the text color and return self for method chaining.
     */
    public function withTextColor(string $textColor): self
    {
        $this->textColor = $textColor;

        return $this;
    }

    /**
     * Set the highlight color and return self for method chaining.
     */
    public function withHighlightColor(string $highlightColor): self
    {
        $this->highlightColor = $highlightColor;

        return $this;
    }

    /**
     * Set the maximum line width and return self for method chaining.
     */
    public function withMaxWidth(int $maxLineWidth): self
    {
        $this->maxLineWidth = $maxLineWidth;

        return $this;
    }

    /**
     * Set the color palette and return self for method chaining.
     *
     * @param array<string> $colors
     */
    public function withColors(array $colors): self
    {
        $this->colors = $colors;

        return $this;
    }

    /**
     * Create a new theme instance with the specified color.
     */
    public static function make(string $color = 'blue'): self
    {
        return new self(color: $color);
    }
}
