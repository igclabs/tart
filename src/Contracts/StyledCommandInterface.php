<?php

namespace IGC\Tart\Contracts;

interface StyledCommandInterface
{
    /**
     * Display a header block with the given message.
     */
    public function header(string $message): void;

    /**
     * Display a success message.
     */
    public function success(string $message): void;

    /**
     * Display a warning message.
     */
    public function warning(string $message): void;

    /**
     * Display a notice message.
     */
    public function notice(string $message): void;

    /**
     * Display an error message.
     */
    public function failure(string $message): void;

    /**
     * Display a regular message.
     */
    public function say(string $message): void;

    /**
     * Display a good/positive message.
     */
    public function good(string $message): void;

    /**
     * Display a bad/negative message.
     */
    public function bad(string $message): void;
}

