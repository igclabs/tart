<?php

namespace Profss\Tart\Themes;

class SuccessTheme extends Theme
{
    public function __construct()
    {
        parent::__construct(
            color: 'green',
            textColor: 'white',
            highlightColor: 'cyan',
            maxLineWidth: 72
        );
    }
}

