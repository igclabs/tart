<?php

namespace IGC\Tart\Support;

class TerminalInput
{
    public function readKey(int $timeoutMs = 0): ?KeyPress
    {
        if ($timeoutMs > 0) {
            $read = [STDIN];
            $write = null;
            $except = null;
            $ready = stream_select($read, $write, $except, 0, $timeoutMs * 1000);

            if ($ready === 0 || $ready === false) {
                return null;
            }
        }

        $char = stream_get_contents(STDIN, 1);
        if ($char === false || $char === '') {
            return null;
        }

        if ($char === "\x1b") {
            $sequence = $char . $this->readAdditionalEscapeBytes();

            return KeyPress::fromBytes($sequence);
        }

        return KeyPress::fromBytes($char);
    }

    private function readAdditionalEscapeBytes(): string
    {
        $read = [STDIN];
        $write = null;
        $except = null;
        $ready = stream_select($read, $write, $except, 0, 10000);

        if ($ready === 0 || $ready === false) {
            return '';
        }

        $bytes = stream_get_contents(STDIN, 2);

        return $bytes === false ? '' : $bytes;
    }
}
