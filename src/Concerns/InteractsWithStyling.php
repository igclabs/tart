<?php

namespace IGC\Tart\Concerns;

use IGC\Tart\Contracts\ThemeInterface;
use IGC\Tart\Themes\DefaultTheme;
use IGC\Tart\Themes\Theme;

trait InteractsWithStyling
{
    protected ThemeInterface $theme;
    /** @var array<string, mixed> */
    protected array $tartConfig = [];

    /**
     * @param array<string, mixed> $overrides
     */
    protected function bootStyling(array $overrides = []): void
    {
        $baseConfig = $this->resolveTartConfig();
        $this->tartConfig = array_replace_recursive($baseConfig, $overrides);
        $this->theme = $this->resolveConfiguredTheme();
        $this->applyAutoAnswerDefault();
    }

    /**
     * Load the package configuration when available.
     *
     * @return array<string, mixed>
     */
    protected function resolveTartConfig(): array
    {
        if (function_exists('app') && function_exists('config')) {
            try {
                $app = app();
                if ($app && method_exists($app, 'bound') && $app->bound('config')) {
                    return config('tart', []);
                }
            } catch (\Throwable $e) {
                // Ignore when the helper is unavailable outside Laravel.
            }
        }

        return [];
    }

    /**
     * Determine the theme to use based on configuration.
     */
    protected function resolveConfiguredTheme(): ThemeInterface
    {
        $themeConfig = $this->tartConfig['theme'] ?? [];
        $themeClass = $themeConfig['class'] ?? DefaultTheme::class;

        if (
            is_string($themeClass)
            && class_exists($themeClass)
            && is_subclass_of($themeClass, ThemeInterface::class)
        ) {
            if ($themeClass === Theme::class) {
                return new Theme(
                    color: $themeConfig['color'] ?? 'blue',
                    textColor: $themeConfig['text_color'] ?? 'white',
                    highlightColor: $themeConfig['highlight_color'] ?? 'yellow',
                    maxLineWidth: $themeConfig['max_line_width'] ?? 72,
                    colors: $themeConfig['colors'] ?? ['red', 'green', 'yellow', 'cyan', 'white']
                );
            }

            if (property_exists($this, 'laravel') && $this->laravel) {
                return $this->laravel->make($themeClass);
            }

            return new $themeClass();
        }

        return new DefaultTheme();
    }

    /**
     * Apply auto-answer preference from configuration when set.
     */
    protected function applyAutoAnswerDefault(): void
    {
        if (array_key_exists('auto_answer', $this->tartConfig)) {
            $this->autoAnswer = (bool) $this->tartConfig['auto_answer'];
        }
    }

    /**
     * Resolve logo decoration options merged with overrides.
     *
     * @param array<string, mixed> $overrides
     * @return array<string, mixed>
     */
    protected function logoOptions(array $overrides = []): array
    {
        $defaults = array_merge([
            'colors' => $this->theme->getColors(),
            'text_color' => $this->theme->getTextColor(),
            'header_lines' => 3,
            'footer_lines' => 3,
            'padding_top' => 1,
            'padding_bottom' => 1,
            'blocks_per_line' => 40,
            'width' => $this->theme->getMaxLineWidth(),
        ], $this->tartConfig['logo'] ?? []);

        return array_merge($defaults, $overrides);
    }
}
