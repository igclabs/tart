<?php

namespace IGC\Tart\Concerns;

use IGC\Tart\Support\InteractiveMenu;

trait HasInteractiveMenus
{
    /**
     * Present a single-select menu and return the chosen value.
     *
     * @param array<int|string, string> $items
     */
    public function menu(string $title, array $items, int $defaultIndex = 0): string
    {
        $menu = new InteractiveMenu($this->getOutput());

        return $menu->select($title, $items, $defaultIndex);
    }

    /**
     * Present a multi-select checkbox menu and return the chosen values.
     *
     * @param array<int|string, string> $items
     * @param array<int|string> $defaults
     * @return array<int|string>
     */
    public function checkboxMenu(string $title, array $items, array $defaults = []): array
    {
        $menu = new InteractiveMenu($this->getOutput());

        return $menu->checkbox($title, $items, $defaults);
    }

    /**
     * Present a single-select radio menu and return the chosen value.
     *
     * @param array<int|string, string> $items
     */
    public function radioMenu(string $title, array $items, int $defaultIndex = 0): string
    {
        $menu = new InteractiveMenu($this->getOutput());

        return $menu->radio($title, $items, $defaultIndex);
    }
}
