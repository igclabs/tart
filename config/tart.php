<?php

use IGC\Tart\Themes\DefaultTheme;
use IGC\Tart\Themes\Theme;

return [
    /*
    |--------------------------------------------------------------------------
    | Auto Answer Mode
    |--------------------------------------------------------------------------
    |
    | When true, interactive prompts such as confirm() will automatically
    | return their default value. This is useful for scheduled jobs or CI.
    |
    */
    'auto_answer' => false,


    /*
    |--------------------------------------------------------------------------
    | Demo Command Registration
    |--------------------------------------------------------------------------
    |
    | Controls whether package demo commands are registered with Artisan.
    | Disable in production to keep your command namespace clean.
    |
    */
    'register_demo_commands' => false,

    /*
    |--------------------------------------------------------------------------
    | Theme Defaults
    |--------------------------------------------------------------------------
    |
    | Control the default Theme implementation. Set "class" to any class that
    | implements ThemeInterface. If you choose the base Theme class you can
    | override its constructor arguments below.
    |
    */
    'theme' => [
        'class' => DefaultTheme::class,
        'color' => 'blue',
        'text_color' => 'white',
        'highlight_color' => 'yellow',
        'max_line_width' => 72,
        'colors' => ['red', 'green', 'yellow', 'cyan', 'white'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Logo Decoration Defaults
    |--------------------------------------------------------------------------
    |
    | These values are used as fallbacks when rendering ASCII art logos via
    | the AsciiArt helper.
    |
    */
    'logo' => [
        'colors' => ['red', 'green', 'yellow', 'cyan', 'white'],
        'text_color' => 'white',
        'header_lines' => 3,
        'footer_lines' => 3,
        'padding_top' => 1,
        'padding_bottom' => 1,
        'blocks_per_line' => 40,
    ],
];

