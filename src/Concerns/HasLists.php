<?php

namespace IGC\Tart\Concerns;

trait HasLists
{
    /**
     * @param array<int|string, mixed> $items
     */
    public function bulletList(array $items, int $indent = 0): void
    {
        $prefix = str_repeat('  ', $indent);

        foreach ($items as $key => $item) {
            if (is_array($item)) {
                $this->say($prefix . '• ' . $key);
                $this->bulletList($item, $indent + 1);
            } else {
                $this->say($prefix . '• ' . $item);
            }
        }
    }

    /**
     * @param array<string> $items
     */
    public function orderedList(array $items, int $indent = 0, int $start = 1): void
    {
        $prefix = str_repeat('  ', $indent);
        $number = $start;

        foreach ($items as $key => $item) {
            if (is_array($item)) {
                $this->say($prefix . $number . '. ' . $key);
                $this->orderedList($item, $indent + 1);
                $number++;
            } else {
                $this->say($prefix . $number . '. ' . $item);
                $number++;
            }
        }
    }

    /**
     * @param array<string> $items
     */
    public function taskList(array $items): void
    {
        foreach ($items as $item) {
            $color = 'white';
            if (str_starts_with($item, '✓') || str_starts_with($item, '✔')) {
                $color = 'green';
            } elseif (str_starts_with($item, '✗') || str_starts_with($item, '✘')) {
                $color = 'red';
            } elseif (str_starts_with($item, '•')) {
                $color = 'yellow';
            }

            if ($color === 'white') {
                $this->say($item);
            } else {
                $this->bline($item, $color);
            }
        }
    }
}
