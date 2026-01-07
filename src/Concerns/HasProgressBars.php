<?php

namespace IGC\Tart\Concerns;

use Closure;
use IGC\Tart\Support\ProgressBar;

trait HasProgressBars
{
    public function progressBar(int $total, string $label = '', ?Closure $callback = null): ProgressBar
    {
        $bar = new ProgressBar($this->getOutput(), $total, $label);
        $bar->setBgColor($this->theme->getColor());
        $bar->setMaxLineWidth($this->theme->getMaxLineWidth());
        $bar->start();

        if ($callback !== null) {
            $callback($bar);
            $bar->finish();
        }

        return $bar;
    }
}
