<?php

namespace IGC\Tart\Contracts;

interface ThemeInterface
{
    /**
     * Get the primary color for the theme.
     */
    public function getColor(): string;

    /**
     * Get the text color for the theme.
     */
    public function getTextColor(): string;

    /**
     * Get the highlight color for the theme.
     */
    public function getHighlightColor(): string;

    /**
     * Get the maximum line width.
     */
    public function getMaxLineWidth(): int;

    /**
     * Get all theme colors.
     */
    public function getColors(): array;
}

