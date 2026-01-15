<?php

namespace IGC\Tart\Concerns;

use IGC\Tart\Support\MultiSelect;
use IGC\Tart\Support\Select;

trait HasSelect
{
    /**
     * @param array<string, string> $options
     */
    public function select(string $question, array $options, ?string $default = null): ?string
    {
        $select = new Select($this->getOutput(), $question, $options, $default);

        return $select->ask();
    }

    /**
     * @param array<string, string> $options
     * @param array<string> $defaults
     * @return array<string>
     */
    public function multiSelect(string $question, array $options, array $defaults = [], int $minRequired = 0): array
    {
        $multiSelect = new MultiSelect($this->getOutput(), $question, $options, $defaults);
        $multiSelect->setMinRequired($minRequired);

        return $multiSelect->ask();
    }
}
