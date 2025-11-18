<?php

namespace IGC\Tart\Tests\Unit;

use IGC\Tart\Support\LogoBuilder;
use IGC\Tart\Themes\Theme;
use PHPUnit\Framework\TestCase;

class FluentApiTest extends TestCase
{
    public function test_theme_fluent_api(): void
    {
        $theme = Theme::make('blue')
            ->withColor('red')
            ->withTextColor('white')
            ->withHighlightColor('yellow')
            ->withMaxWidth(100)
            ->withColors(['red', 'green', 'blue']);

        $this->assertEquals('red', $theme->getColor());
        $this->assertEquals('white', $theme->getTextColor());
        $this->assertEquals('yellow', $theme->getHighlightColor());
        $this->assertEquals(100, $theme->getMaxLineWidth());
        $this->assertEquals(['red', 'green', 'blue'], $theme->getColors());
    }

    public function test_logo_builder_fluent_api(): void
    {
        $builder = LogoBuilder::make()
            ->text('TEST APP')
            ->boxed()
            ->color('cyan')
            ->width(60)
            ->headerLines(2)
            ->footerLines(2)
            ->paddingTop(0)
            ->paddingBottom(0);

        $options = $builder->getOptions();

        $this->assertEquals('TEST APP', $builder->getText());
        $this->assertEquals('box', $options['style']);
        $this->assertEquals('cyan', $options['text_color']);
        $this->assertEquals(60, $options['width']);
        $this->assertEquals(2, $options['header_lines']);
        $this->assertEquals(2, $options['footer_lines']);
        $this->assertEquals(0, $options['padding_top']);
        $this->assertEquals(0, $options['padding_bottom']);
    }

    public function test_logo_builder_ascii_art(): void
    {
        $ascii = "███╗░░░███╗██╗░░░██╗\n████╗░████║╚██╗░██╔╝";

        $builder = LogoBuilder::make()
            ->ascii($ascii)
            ->color('green')
            ->withoutHeader()
            ->withoutFooter();

        $options = $builder->getOptions();

        $this->assertEquals($ascii, $builder->getAsciiArt());
        $this->assertEquals('ascii', $builder->getType());
        $this->assertEquals('green', $options['text_color']);
        $this->assertEquals(0, $options['header_lines']);
        $this->assertEquals(0, $options['footer_lines']);
    }

    public function test_logo_builder_banner_style(): void
    {
        $builder = LogoBuilder::make()
            ->text('DEPLOYMENT')
            ->banner()
            ->color('red');

        $options = $builder->getOptions();

        $this->assertEquals('banner', $options['style']);
        $this->assertEquals('red', $options['text_color']);
    }

    public function test_logo_builder_build_method(): void
    {
        $builder = LogoBuilder::make()
            ->text('HELLO')
            ->withoutHeader()
            ->withoutFooter()
            ->withoutPadding();

        $lines = $builder->build();

        $this->assertIsArray($lines);
        $this->assertNotEmpty($lines);
        $this->assertStringContainsString('HELLO', implode('', $lines));
    }

    public function test_theme_chaining_returns_self(): void
    {
        $theme = new Theme();

        $result = $theme->withColor('green');

        $this->assertSame($theme, $result);
        $this->assertEquals('green', $theme->getColor());
    }

    public function test_logo_builder_chaining_returns_self(): void
    {
        $builder = new LogoBuilder();

        $result = $builder->text('test')->color('blue')->width(50);

        $this->assertSame($builder, $result);
        $this->assertEquals('test', $builder->getText());
        $this->assertEquals('blue', $builder->getOptions()['text_color']);
        $this->assertEquals(50, $builder->getOptions()['width']);
    }
}
