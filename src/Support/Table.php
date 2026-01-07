<?php

namespace IGC\Tart\Support;

use Symfony\Component\Console\Output\OutputInterface;

class Table
{
    protected OutputInterface $output;
    /** @var array<string> */
    protected array $headers = [];
    /** @var array<array<string>> */
    protected array $rows = [];
    /** @var array<string> */
    protected array $align = [];
    protected string $style = 'default';

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    /**
     * @param array<string> $headers
     */
    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @param array<string> $row
     */
    public function addRow(array $row): self
    {
        $this->rows[] = $row;

        return $this;
    }

    /**
     * @param array<array<string>> $rows
     */
    public function setRows(array $rows): self
    {
        $this->rows = $rows;

        return $this;
    }

    public function render(): void
    {
        if (empty($this->headers) && empty($this->rows)) {
            return;
        }

        $columnWidths = $this->calculateColumnWidths();

        if (!empty($this->headers)) {
            $this->renderRow($this->headers, $columnWidths, true);
            $this->renderSeparator($columnWidths);
        }

        foreach ($this->rows as $row) {
            $this->renderRow($row, $columnWidths);
        }
    }

    /**
     * @return array<int>
     */
    protected function calculateColumnWidths(): array
    {
        $widths = [];
        $allRows = $this->headers ? array_merge([$this->headers], $this->rows) : $this->rows;

        foreach ($allRows as $row) {
            foreach ($row as $i => $cell) {
                $length = $this->visualLength($cell);
                $widths[$i] = max($widths[$i] ?? 0, $length);
            }
        }

        return $widths;
    }

    protected function visualLength(string $string): int
    {
        $stripped = strip_tags($string);
        $stripped = preg_replace('/\x1b\[[0-9;]*m/', '', $stripped);

        return mb_strlen($stripped, 'UTF-8');
    }

    /**
     * @param array<string> $row
     * @param array<int> $widths
     */
    protected function renderRow(array $row, array $widths, bool $isHeader = false): void
    {
        $cells = [];

        foreach ($row as $i => $cell) {
            $width = $widths[$i] ?? 0;
            $cellLength = $this->visualLength($cell);
            $padding = max(0, $width - $cellLength);

            $cells[] = $cell . str_repeat(' ', $padding);
        }

        $line = '  │ ' . implode(' │ ', $cells) . ' │  ';

        if ($isHeader) {
            $this->output->writeln("<fg=cyan>{$line}</fg=cyan>");
        } else {
            $this->output->writeln($line);
        }
    }

    /**
     * @param array<int> $widths
     */
    protected function renderSeparator(array $widths): void
    {
        $parts = [];

        foreach ($widths as $width) {
            $parts[] = str_repeat('─', $width);
        }

        $this->output->writeln('  ├─' . implode('─┼─', $parts) . '─┤  ');
    }
}
