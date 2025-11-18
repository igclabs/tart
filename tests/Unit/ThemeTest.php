<?php

namespace IGC\Tart\Tests\Unit;

use PHPUnit\Framework\TestCase;
use IGC\Tart\Themes\Theme;
use IGC\Tart\Themes\DefaultTheme;
use IGC\Tart\Themes\SuccessTheme;
use IGC\Tart\Themes\ErrorTheme;

class ThemeTest extends TestCase
{
    public function test_theme_returns_correct_values(): void
    {
        $theme = new Theme('magenta', 'white', 'yellow', 80);

        $this->assertEquals('magenta', $theme->getColor());
        $this->assertEquals('white', $theme->getTextColor());
        $this->assertEquals('yellow', $theme->getHighlightColor());
        $this->assertEquals(80, $theme->getMaxLineWidth());
    }

    public function test_default_theme_has_correct_values(): void
    {
        $theme = new DefaultTheme();
        
        $this->assertEquals('blue', $theme->getColor());
        $this->assertEquals('white', $theme->getTextColor());
        $this->assertEquals('yellow', $theme->getHighlightColor());
        $this->assertEquals(72, $theme->getMaxLineWidth());
    }

    public function test_success_theme_has_correct_values(): void
    {
        $theme = new SuccessTheme();
        
        $this->assertEquals('green', $theme->getColor());
        $this->assertEquals('white', $theme->getTextColor());
    }

    public function test_error_theme_has_correct_values(): void
    {
        $theme = new ErrorTheme();
        
        $this->assertEquals('red', $theme->getColor());
        $this->assertEquals('white', $theme->getTextColor());
    }

    public function test_theme_returns_colors_array(): void
    {
        $theme = new DefaultTheme();
        $colors = $theme->getColors();
        
        $this->assertIsArray($colors);
        $this->assertNotEmpty($colors);
    }
}

