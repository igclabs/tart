<?php

namespace Profss\Tart\Themes;

class ErrorTheme extends Theme
{
    public function __construct()
    {
        parent::__construct(
            color: 'red',
            textColor: 'white',
            highlightColor: 'yellow',
            maxLineWidth: 72
        );
    }
}

