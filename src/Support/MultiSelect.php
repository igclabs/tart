<?php

namespace IGC\Tart\Support;

use Symfony\Component\Console\Output\OutputInterface;

class MultiSelect
{
    protected OutputInterface $output;
    protected string $question;
    /** @var array<string, string> */
    protected array $options;
    /** @var array<string> */
    protected array $selected = [];
    protected int $cursorIndex = 0;
    protected int $minRequired = 0;

    /**
     * @param array<string, string> $options
     * @param array<string> $defaults
     */
    public function __construct(OutputInterface $output, string $question, array $options, array $defaults = [])
    {
        $this->output = $output;
        $this->question = $question;
        $this->options = $options;
        $this->selected = array_values(array_intersect($defaults, array_keys($options)));
    }

    public function setMinRequired(int $min): self
    {
        $this->minRequired = $min;

        return $this;
    }

    /**
     * @return array<string>
     */
    public function ask(): array
    {
        if (empty($this->options)) {
            return [];
        }

        $keys = array_keys($this->options);
        $values = array_values($this->options);

        if (!$this->isInteractive()) {
            return $this->selected;
        }

        $this->output->writeln("<fg=cyan>{$this->question}</fg=cyan>");
        $this->output->writeln("<fg=yellow>Use arrow keys to navigate, Space to select/deselect, Enter to confirm</fg=yellow>");
        $this->output->writeln('');

        $this->render($keys, $values);

        $selected = $this->readInput($keys, $values);

        $this->output->write("\033[" . (count($this->options) + 2) . "A");
        $this->output->write("\033[0J");

        if (!empty($selected)) {
            $selectedLabels = array_map(fn($key) => $this->options[$key], $selected);
            $this->output->writeln("<fg=cyan>{$this->question}</fg=cyan> <fg=green>" . implode(', ', $selectedLabels) . "</fg=green>");
        } else {
            $this->output->writeln("<fg=cyan>{$this->question}</fg=cyan> <fg=yellow>None selected</fg=yellow>");
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
            $key = $keys[$index];
            $isSelected = in_array($key, $this->selected, true);
            $checkbox = $isSelected ? '☑' : '☐';
            $cursor = $index === $this->cursorIndex ? '❯' : ' ';

            if ($index === $this->cursorIndex) {
                $this->output->writeln("<fg=cyan>{$cursor} {$checkbox} {$label}</fg=cyan>");
            } else {
                $this->output->writeln("  {$checkbox} {$label}");
            }
        }
    }

    /**
     * @param array<string> $keys
     * @param array<string> $values
     * @return array<string>
     */
    protected function readInput(array $keys, array $values): array
    {
        $sttyMode = shell_exec('stty -g');

        system('stty -icanon -echo');

        while (true) {
            $char = fread(STDIN, 1);

            if ($char === "\n") {
                if ($this->minRequired > 0 && count($this->selected) < $this->minRequired) {
                    continue;
                }
                break;
            }

            if ($char === ' ') {
                $key = $keys[$this->cursorIndex];
                $index = array_search($key, $this->selected, true);

                if ($index !== false) {
                    unset($this->selected[$index]);
                    $this->selected = array_values($this->selected);
                } else {
                    $this->selected[] = $key;
                }

                $this->updateDisplay($keys, $values);
            } elseif ($char === "\033") {
                $arrow = fread(STDIN, 2);

                if ($arrow === '[A') {
                    $this->cursorIndex = max(0, $this->cursorIndex - 1);
                    $this->updateDisplay($keys, $values);
                } elseif ($arrow === '[B') {
                    $this->cursorIndex = min(count($this->options) - 1, $this->cursorIndex + 1);
                    $this->updateDisplay($keys, $values);
                }
            }
        }

        if ($sttyMode !== null && $sttyMode !== false) {
            system("stty {$sttyMode}");
        }

        return $this->selected;
    }

    /**
     * @param array<string> $keys
     * @param array<string> $values
     */
    protected function updateDisplay(array $keys, array $values): void
    {
        $this->output->write("\033[" . count($this->options) . "A");

        foreach ($values as $index => $label) {
            $key = $keys[$index];
            $isSelected = in_array($key, $this->selected, true);
            $checkbox = $isSelected ? '☑' : '☐';
            $cursor = $index === $this->cursorIndex ? '❯' : ' ';

            $this->output->write("\033[2K");

            if ($index === $this->cursorIndex) {
                $this->output->writeln("<fg=cyan>{$cursor} {$checkbox} {$label}</fg=cyan>");
            } else {
                $this->output->writeln("  {$checkbox} {$label}");
            }
        }
    }

    protected function isInteractive(): bool
    {
        return stream_isatty(STDIN) && stream_isatty(STDOUT);
    }
}
