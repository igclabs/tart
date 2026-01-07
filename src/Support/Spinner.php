<?php

namespace IGC\Tart\Support;

use Symfony\Component\Console\Output\OutputInterface;

class Spinner
{
    protected OutputInterface $output;
    protected string $message;
    protected string $style = 'dots';
    protected bool $running = false;
    protected int $frame = 0;

    /** @var array<string, array<string>> */
    protected array $styles = [
        'dots' => ['⠋', '⠙', '⠹', '⠸', '⠼', '⠴', '⠦', '⠧', '⠇', '⠏'],
        'dots2' => ['⣾', '⣽', '⣻', '⢿', '⡿', '⣟', '⣯', '⣷'],
        'dots3' => ['⠋', '⠙', '⠚', '⠞', '⠖', '⠦', '⠴', '⠲', '⠳', '⠓'],
        'line' => ['-', '\\', '|', '/'],
        'arrow' => ['←', '↖', '↑', '↗', '→', '↘', '↓', '↙'],
        'pulse' => ['█', '▓', '▒', '░', ' ', '░', '▒', '▓'],
        'bounce' => ['⠁', '⠂', '⠄', '⡀', '⢀', '⠠', '⠐', '⠈'],
    ];

    public function __construct(OutputInterface $output, string $message = '')
    {
        $this->output = $output;
        $this->message = $message;
    }

    public function setStyle(string $style): self
    {
        if (!isset($this->styles[$style])) {
            throw new \InvalidArgumentException("Unknown spinner style: {$style}");
        }

        $this->style = $style;

        return $this;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function start(): self
    {
        $this->running = true;
        $this->frame = 0;

        return $this;
    }

    public function stop(string $finalMessage = ''): void
    {
        $this->running = false;

        $this->output->write("\r\033[K");

        if ($finalMessage) {
            $this->output->writeln($finalMessage);
        }
    }

    public function tick(): void
    {
        if (!$this->running) {
            return;
        }

        $frames = $this->styles[$this->style];
        $frame = $frames[$this->frame % count($frames)];

        $this->output->write("\r{$frame} {$this->message}");

        $this->frame++;
    }

    public function isRunning(): bool
    {
        return $this->running;
    }
}
