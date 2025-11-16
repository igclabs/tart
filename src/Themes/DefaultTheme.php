<?php

namespace IGC\Tart\Themes;

class DefaultTheme extends Theme
{
    public function __construct()
    {
        parent::__construct(
            color: 'blue',
            textColor: 'white',
            highlightColor: 'yellow',
            maxLineWidth: 72
        );
    }
}

