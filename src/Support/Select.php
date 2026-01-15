<?php

namespace IGC\Tart\Support;

use Symfony\Component\Console\Output\OutputInterface;

class Select
{
    protected OutputInterface $output;
    protected string $question;
    /** @var array<string, string> */
    protected array $options;
    protected ?string $default = null;
    protected int $selectedIndex = 0;
    protected bool $required = false;

    /**
     * @param array<string, string> $options
     */
    public function __construct(OutputInterface $output, string $question, array $options, ?string $default = null)
    {
        $this->output = $output;
        $this->question = $question;
        $this->options = $options;
        $this->default = $default;

        if ($default !== null && isset($options[$default])) {
            $keys = array_keys($options);
            $this->selectedIndex = array_search($default, $keys, true) ?: 0;
        }
    }

    public function setRequired(bool $required): self
    {
        $this->required = $required;

        return $this;
    }

    public function ask(): ?string
    {
        if (empty($this->options)) {
            return null;
        }

        $keys = array_keys($this->options);
        $values = array_values($this->options);

        if (!$this->isInteractive()) {
            return $keys[$this->selectedIndex] ?? ($this->default ?? null);
        }

        $this->output->writeln("<fg=cyan>{$this->question}</fg=cyan>");
        $this->output->writeln('');

        $this->render($keys, $values);

        $selected = $this->readInput($keys);

        $this->output->write("\033[" . (count($this->options) + 1) . "A");
        $this->output->write("\033[0J");

        if ($selected !== null) {
            $selectedLabel = $this->options[$selected];
            $this->output->writeln("<fg=cyan>{$this->question}</fg=cyan> <fg=green>{$selectedLabel}</fg=green>");
        }

        return $selected;
    }

    /**
     * @param array<string> $keys
     * @param array<string> $values
     */
    protected function render(array $keys, array $values): void
    {
        foreach ($values as $index => $label) {
            if ($index === $this->selectedIndex) {
                $this->output->writeln("<fg=cyan>❯ {$label}</fg=cyan>");
            } else {
                $this->output->writeln("  {$label}");
            }
        }
    }

    /**
     * @param array<string> $keys
     */
    protected function readInput(array $keys): ?string
    {
        $sttyMode = shell_exec('stty -g');

        system('stty -icanon -echo');

        while (true) {
            $char = fread(STDIN, 3);

            if ($char === "\n") {
                break;
            }

            if ($char === "\033") {
                $arrow = fread(STDIN, 2);

                if ($arrow === '[A') {
                    $this->selectedIndex = max(0, $this->selectedIndex - 1);
                    $this->updateDisplay($keys, array_values($this->options));
                } elseif ($arrow === '[B') {
                    $this->selectedIndex = min(count($this->options) - 1, $this->selectedIndex + 1);
                    $this->updateDisplay($keys, array_values($this->options));
                }
            }
        }

        if ($sttyMode !== null && $sttyMode !== false) {
            system("stty {$sttyMode}");
        }

        return $keys[$this->selectedIndex] ?? null;
    }

    /**
     * @param array<string> $keys
     * @param array<string> $values
     */
    protected function updateDisplay(array $keys, array $values): void
    {
        $this->output->write("\033[" . count($this->options) . "A");

        foreach ($values as $index => $label) {
            $this->output->write("\033[2K");

            if ($index === $this->selectedIndex) {
                $this->output->writeln("<fg=cyan>❯ {$label}</fg=cyan>");
            } else {
                $this->output->writeln("  {$label}");
            }
        }
    }

    protected function isInteractive(): bool
    {
        return stream_isatty(STDIN) && stream_isatty(STDOUT);
    }
}
