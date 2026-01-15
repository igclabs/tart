<?php

namespace IGC\Tart\Support;

use RuntimeException;

class TerminalMode
{
    private ?string $sttyMode = null;
    private ?bool $stdinBlocking = null;

    public function enableRawMode(): void
    {
        if (function_exists('stream_isatty') && !stream_isatty(STDIN)) {
            throw new RuntimeException('STDIN is not a TTY.');
        }

        $this->sttyMode = shell_exec('stty -g 2>/dev/null');
        if ($this->sttyMode === null || $this->sttyMode === '') {
            throw new RuntimeException('Unable to read terminal settings via stty.');
        }

        $meta = stream_get_meta_data(STDIN);
        $this->stdinBlocking = $meta['blocked'] ?? null;
        stream_set_blocking(STDIN, true);

        shell_exec('stty -icanon -echo min 1 time 0');
    }

    public function restore(): void
    {
        if ($this->sttyMode !== null) {
            shell_exec(sprintf('stty %s', trim($this->sttyMode)));
        }

        if ($this->stdinBlocking !== null) {
            stream_set_blocking(STDIN, $this->stdinBlocking);
        }
    }
}
