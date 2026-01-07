<?php

namespace IGC\Tart\Concerns;

use Closure;
use IGC\Tart\Support\ProgressBar;

trait HasProgressBars
{
    public function progressBar(int $total, string $label = '', ?Closure $callback = null): ProgressBar
    {
        $color = $this->theme->getColor();
        $gap = '  ';

        $this->getOutput()->write("<bg={$color}>{$gap}</bg={$color}>");

        $bar = new ProgressBar($this->getOutput(), $total, $label);
        $bar->start();

        if ($callback !== null) {
            $callback($bar);
            $bar->finish();
            $this->getOutput()->writeln("<bg={$color}>{$gap}</bg={$color}>");
        }

        return $bar;
    }
}
