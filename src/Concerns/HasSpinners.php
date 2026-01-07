<?php

namespace IGC\Tart\Concerns;

use Closure;
use IGC\Tart\Support\Spinner;

trait HasSpinners
{
    public function spinner(string $message = '', ?Closure $callback = null): Spinner
    {
        $spinner = new Spinner($this->getOutput(), $message);
        $spinner->start();

        if ($callback !== null) {
            while ($spinner->isRunning()) {
                $spinner->tick();
                usleep(80000);

                $result = $callback();
                if ($result === true) {
                    $spinner->stop();

                    break;
                }
            }
        }

        return $spinner;
    }
}
