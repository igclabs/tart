<?php

namespace IGC\Tart\Support;

use IGC\Tart\Contracts\ThemeInterface;

/**
 * Fluent builder for creating logos with method chaining.
 *
 * Provides an expressive, chainable API for logo creation following Laravel conventions.
 */
class LogoBuilder
{
    protected array $options = [];
    protected string $text = '';
    protected string $asciiArt = '';
    protected array $lines = [];
    protected string $type = 'text'; // 'text', 'ascii', 'custom'

    /**
     * Create a new logo builder instance.
     */
    public function __construct(?ThemeInterface $theme = null)
    {
        if ($theme) {
            $this->options = [
                'colors' => $theme->getColors(),
                'text_color' => $theme->getTextColor(),
                'width' => $theme->getMaxLineWidth(),
            ];
        }
    }

    /**
     * Create a new logo builder with optional theme.
     */
    public static function make(?ThemeInterface $theme = null): self
    {
        return new static($theme);
    }

    /**
     * Set the text for a text-based logo.
     */
    public function text(string $text): self
    {
        $this->text = $text;
        $this->type = 'text';
        return $this;
    }

    /**
     * Set ASCII art for multi-line logo.
     */
    public function ascii(string $asciiArt): self
    {
        $this->asciiArt = $asciiArt;
        $this->type = 'ascii';
        return $this;
    }

    /**
     * Set custom logo lines.
     */
    public function lines(array $lines): self
    {
        $this->lines = $lines;
        $this->type = 'custom';
        return $this;
    }

    /**
     * Set the logo style (standard, box, banner).
     */
    public function style(string $style): self
    {
        $this->options['style'] = $style;
        return $this;
    }

    /**
     * Set as box style logo.
     */
    public function boxed(): self
    {
        return $this->style('box');
    }

    /**
     * Set as banner style logo.
     */
    public function banner(): self
    {
        return $this->style('banner');
    }

    /**
     * Set the text color.
     */
    public function color(string $color): self
    {
        $this->options['text_color'] = $color;
        return $this;
    }

    /**
     * Set the color palette for decorations.
     */
    public function colors(array $colors): self
    {
        $this->options['colors'] = $colors;
        return $this;
    }

    /**
     * Set the width of the logo.
     */
    public function width(int $width): self
    {
        $this->options['width'] = $width;
        return $this;
    }

    /**
     * Set the number of header decoration lines.
     */
    public function headerLines(int $lines): self
    {
        $this->options['header_lines'] = $lines;
        return $this;
    }

    /**
     * Set the number of footer decoration lines.
     */
    public function footerLines(int $lines): self
    {
        $this->options['footer_lines'] = $lines;
        return $this;
    }

    /**
     * Set padding above the logo content.
     */
    public function paddingTop(int $padding): self
    {
        $this->options['padding_top'] = $padding;
        return $this;
    }

    /**
     * Set padding below the logo content.
     */
    public function paddingBottom(int $padding): self
    {
        $this->options['padding_bottom'] = $padding;
        return $this;
    }

    /**
     * Set the number of color blocks per decoration line.
     */
    public function blocksPerLine(int $blocks): self
    {
        $this->options['blocks_per_line'] = $blocks;
        return $this;
    }

    /**
     * Remove header decoration.
     */
    public function withoutHeader(): self
    {
        $this->options['header_lines'] = 0;
        return $this;
    }

    /**
     * Remove footer decoration.
     */
    public function withoutFooter(): self
    {
        $this->options['footer_lines'] = 0;
        return $this;
    }

    /**
     * Remove all padding.
     */
    public function withoutPadding(): self
    {
        $this->options['padding_top'] = 0;
        $this->options['padding_bottom'] = 0;
        return $this;
    }

    /**
     * Build and return the logo lines.
     */
    public function build(): array
    {
        return match ($this->type) {
            'ascii' => AsciiArt::createMultiLineLogo($this->asciiArt, $this->options),
            'custom' => AsciiArt::createLogo($this->lines, $this->options),
            default => AsciiArt::createTextLogo($this->text, $this->options),
        };
    }

    /**
     * Render the logo directly to output lines.
     * This is a convenience method for immediate rendering.
     */
    public function render(): array
    {
        return $this->build();
    }

    /**
     * Get the current configuration options.
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Get the current text content.
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * Get the current ASCII art content.
     */
    public function getAsciiArt(): string
    {
        return $this->asciiArt;
    }

    /**
     * Get the current type.
     */
    public function getType(): string
    {
        return $this->type;
    }
}
