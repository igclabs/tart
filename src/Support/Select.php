<?php

namespace IGC\Tart\Support;

use IGC\Tart\Contracts\ThemeInterface;
use IGC\Tart\Themes\DefaultTheme;
use Symfony\Component\Console\Output\OutputInterface;

class Select
{
    protected OutputInterface $output;
    protected ThemeInterface $theme;
    protected FrameRenderer $frame;
    protected string $question;
    /** @var array<string, string> */
    protected array $options;
    protected ?string $default = null;
    protected int $selectedIndex = 0;
    protected bool $required = false;
    protected string $highlightColor;
    protected string $highlightTextColor;

    /**
     * @param array<string, string> $options
     */
    public function __construct(
        OutputInterface $output,
        string $question,
        array $options,
        ?string $default = null,
        ?ThemeInterface $theme = null
    )
    {
        $this->output = $output;
        $this->question = $question;
        $this->options = $options;
        $this->default = $default;
        $this->theme = $theme ?? new DefaultTheme();
        $this->frame = new FrameRenderer($output, $this->theme);
        $this->highlightColor = $this->theme->getHighlightColor();
        $this->highlightTextColor = $this->theme->getTextColor();

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

        $this->frame->writeln($this->question, 'cyan');
        $this->frame->writeln('');

        $this->render($keys, $values);

        $selected = $this->readInput($keys);

        $this->output->write(TerminalControl::moveUp(count($this->options) + 1));
        $this->output->write("\033[0J");

        if ($selected !== null) {
            $selectedLabel = $this->options[$selected];
            $summary = "<fg=cyan>{$this->question}</fg=cyan> <fg=green>{$selectedLabel}</fg=green>";
            $this->output->writeln($this->frame->format($summary));
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
                $this->output->writeln($this->frame->format("❯ {$label}", $this->highlightTextColor, $this->highlightColor));
            } else {
                $this->output->writeln($this->frame->format("  {$label}", $this->theme->getTextColor()));
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
        $this->output->write(TerminalControl::moveUp(count($this->options)));

        foreach ($values as $index => $label) {
            $this->output->write("\033[2K");

            if ($index === $this->selectedIndex) {
                $this->output->writeln($this->frame->format("❯ {$label}", $this->highlightTextColor, $this->highlightColor));
            } else {
                $this->output->writeln($this->frame->format("  {$label}", $this->theme->getTextColor()));
            }
        }
    }

    protected function isInteractive(): bool
    {
        return stream_isatty(STDIN) && stream_isatty(STDOUT);
    }
}
