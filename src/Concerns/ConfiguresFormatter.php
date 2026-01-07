<?php

namespace IGC\Tart\Concerns;

use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Output\OutputInterface;

trait ConfiguresFormatter
{
    protected function configureOutputFormatter(OutputInterface $output): void
    {
        $formatter = new OutputFormatter($output->isDecorated());
        $formatter->setStyle('red', new OutputFormatterStyle('red', 'black'));
        $formatter->setStyle('green', new OutputFormatterStyle('green', 'black'));
        $formatter->setStyle('yellow', new OutputFormatterStyle('yellow', 'black'));
        $formatter->setStyle('blue', new OutputFormatterStyle('blue', 'black'));
        $formatter->setStyle('magenta', new OutputFormatterStyle('magenta', 'black'));
        $formatter->setStyle('cyan', new OutputFormatterStyle('cyan', 'black'));
        $formatter->setStyle('yellow-blue', new OutputFormatterStyle('yellow', 'blue'));
        $formatter->setStyle('igc', new OutputFormatterStyle('white', 'black'));

        $output->setFormatter($formatter);
    }
}
