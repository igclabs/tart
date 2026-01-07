<?php

namespace IGC\Tart\Concerns;

use IGC\Tart\Support\Table;

trait HasTables
{
    /**
     * @param array<string> $headers
     * @param array<array<string>> $rows
     */
    public function renderTable(array $headers, array $rows = []): void
    {
        $table = new Table($this->getOutput());
        $table->setHeaders($headers);
        $table->setRows($rows);
        $table->setBgColor($this->theme->getColor());
        $table->setMaxLineWidth($this->theme->getMaxLineWidth());
        $table->render();
    }
}
