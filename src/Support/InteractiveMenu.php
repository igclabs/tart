<?php

namespace IGC\Tart\Support;

use IGC\Tart\Contracts\ThemeInterface;
use IGC\Tart\Themes\DefaultTheme;
use RuntimeException;
use Symfony\Component\Console\Output\OutputInterface;

class InteractiveMenu
{
    private OutputInterface $output;
    private TerminalInput $input;
    private ThemeInterface $theme;
    private FrameRenderer $frame;
    private string $highlightColor = 'cyan';
    private string $highlightTextColor = 'black';
    private int $renderedLines = 0;

    public function __construct(OutputInterface $output, ?ThemeInterface $theme = null, ?TerminalInput $input = null)
    {
        $this->output = $output;
        $this->theme = $theme ?? new DefaultTheme();
        $this->frame = new FrameRenderer($output, $this->theme);
        $this->input = $input ?? new TerminalInput();
        $this->highlightColor = $this->theme->getHighlightColor();
        $this->highlightTextColor = $this->theme->getTextColor();
    }

    public function setHighlightColor(string $color, string $textColor = 'black'): self
    {
        $this->highlightColor = $color;
        $this->highlightTextColor = $textColor;

        return $this;
    }

    /**
     * @param array<int|string, string> $items
     */
    public function select(string $title, array $items, int $defaultIndex = 0): string
    {
        return $this->runSelection($title, $items, $defaultIndex, 'menu');
    }

    /**
     * @param array<int|string, string> $items
     * @param array<int|string> $defaults
     * @return array<int|string>
     */
    public function checkbox(string $title, array $items, array $defaults = []): array
    {
        [$keys, $labels, $isAssoc] = $this->normalizeItems($items);
        $selected = [];

        foreach ($defaults as $default) {
            if ($isAssoc) {
                $index = array_search($default, $keys, true);
            } else {
                $index = array_search($default, $labels, true);
            }

            if ($index === false && is_int($default) && isset($labels[$default])) {
                $index = $default;
            }

            if ($index !== false) {
                $selected[$index] = true;
            }
        }

        $result = $this->runCheckboxSelection($title, $items, $selected);

        return $result;
    }

    /**
     * @param array<int|string, string> $items
     */
    public function radio(string $title, array $items, int $defaultIndex = 0): string
    {
        return $this->runSelection($title, $items, $defaultIndex, 'radio');
    }

    /**
     * @param array<int|string, string> $items
     */
    private function runSelection(string $title, array $items, int $defaultIndex, string $mode): string
    {
        [$keys, $labels, $isAssoc] = $this->normalizeItems($items);
        $count = count($labels);

        if ($count === 0) {
            throw new RuntimeException('Menu items cannot be empty.');
        }

        $index = max(0, min($defaultIndex, $count - 1));
        $terminal = new TerminalMode();

        $terminal->enableRawMode();

        try {
            $this->output->write(TerminalControl::hideCursor());
            $this->render($title, $labels, $index, [], $mode);

            while (true) {
                $key = $this->input->readKey();
                if ($key === null) {
                    continue;
                }

                if ($key->type === KeyPress::UP) {
                    $index = max(0, $index - 1);
                } elseif ($key->type === KeyPress::DOWN) {
                    $index = min($count - 1, $index + 1);
                } elseif ($key->type === KeyPress::ENTER) {
                    $selectedKey = $keys[$index];

                    return $isAssoc ? (string) $selectedKey : (string) $labels[$index];
                } elseif ($key->type === KeyPress::ESCAPE) {
                    $selectedKey = $keys[$index];

                    return $isAssoc ? (string) $selectedKey : (string) $labels[$index];
                } elseif ($mode === 'radio' && $key->type === KeyPress::SPACE) {
                    $selectedKey = $keys[$index];

                    return $isAssoc ? (string) $selectedKey : (string) $labels[$index];
                }

                $this->render($title, $labels, $index, [], $mode);
            }
        } finally {
            $this->output->write(TerminalControl::showCursor());
            $terminal->restore();
        }
    }

    /**
     * @param array<int|string, string> $items
     * @param array<int, bool> $selected
     * @return array<int|string>
     */
    private function runCheckboxSelection(string $title, array $items, array $selected): array
    {
        [$keys, $labels, $isAssoc] = $this->normalizeItems($items);
        $count = count($labels);

        if ($count === 0) {
            throw new RuntimeException('Menu items cannot be empty.');
        }

        $index = 0;
        $terminal = new TerminalMode();

        $terminal->enableRawMode();

        try {
            $this->output->write(TerminalControl::hideCursor());
            $this->render($title, $labels, $index, $selected, 'checkbox');

            while (true) {
                $key = $this->input->readKey();
                if ($key === null) {
                    continue;
                }

                if ($key->type === KeyPress::UP) {
                    $index = max(0, $index - 1);
                } elseif ($key->type === KeyPress::DOWN) {
                    $index = min($count - 1, $index + 1);
                } elseif ($key->type === KeyPress::SPACE) {
                    $selected[$index] = !($selected[$index] ?? false);
                } elseif ($key->type === KeyPress::ENTER || $key->type === KeyPress::ESCAPE) {
                    return $this->selectedValues($keys, $labels, $selected, $isAssoc);
                }

                $this->render($title, $labels, $index, $selected, 'checkbox');
            }
        } finally {
            $this->output->write(TerminalControl::showCursor());
            $terminal->restore();
        }
    }

    /**
     * @param array<int|string> $keys
     * @param array<int, string> $labels
     * @param array<int, bool> $selected
     * @return array<int|string>
     */
    private function selectedValues(array $keys, array $labels, array $selected, bool $isAssoc): array
    {
        $values = [];
        foreach ($selected as $index => $isSelected) {
            if ($isSelected) {
                $values[] = $isAssoc ? $keys[$index] : $labels[$index];
            }
        }

        return $values;
    }

    /**
     * @param array<int|string, string> $items
     * @return array{0: array<int|string>, 1: array<int, string>, 2: bool}
     */
    private function normalizeItems(array $items): array
    {
        $keys = array_keys($items);
        $labels = array_values($items);
        $isAssoc = $keys !== range(0, count($keys) - 1);

        return [$keys, $labels, $isAssoc];
    }

    /**
     * @param array<int, string> $labels
     * @param array<int, bool> $selected
     */
    private function render(string $title, array $labels, int $index, array $selected, string $mode): void
    {
        $lines = [];

        if ($title !== '') {
            $lines[] = $this->frame->format($title, 'cyan');
            $lines[] = $this->frame->format('');
        }

        foreach ($labels as $current => $label) {
            $marker = $this->markerFor($mode, $current, $selected, $current === $index);
            $line = "{$marker} {$label}";

            if ($current === $index) {
                $lines[] = $this->frame->format($line, $this->highlightTextColor, $this->highlightColor);
            } else {
                $lines[] = $this->frame->format($line, $this->theme->getTextColor());
            }
        }

        if ($this->renderedLines > 0) {
            $this->output->write(TerminalControl::moveUp($this->renderedLines));
        }

        foreach ($lines as $line) {
            $this->output->write(TerminalControl::clearLine());
            $this->output->writeln($line);
        }

        $this->renderedLines = count($lines);
    }

    /**
     * @param array<int, bool> $selected
     */
    private function markerFor(string $mode, int $index, array $selected, bool $isActive): string
    {
        if ($mode === 'checkbox') {
            return ($selected[$index] ?? false) ? '[x]' : '[ ]';
        }

        if ($mode === 'radio') {
            return $isActive ? '(o)' : '( )';
        }

        if ($mode === 'menu') {
            return $isActive ? '>' : ' ';
        }

        return ' ';
    }
}
