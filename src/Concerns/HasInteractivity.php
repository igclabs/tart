<?php

namespace IGC\Tart\Concerns;

/**
 * Trait for interactive command features.
 * 
 * Note: The confirm() method is implemented directly in StyledCommand
 * to properly override Laravel's parent method with the correct signature.
 */
trait HasInteractivity
{
    public bool $autoAnswer = false;
}

