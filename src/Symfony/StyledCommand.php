<?php

namespace IGC\Tart\Symfony;

use IGC\Tart\Concerns\ConfiguresFormatter;
use IGC\Tart\Concerns\HasBlocks;
use IGC\Tart\Concerns\HasColoredOutput;
use IGC\Tart\Concerns\HasEnhancedInput;
use IGC\Tart\Concerns\HasInteractivity;
use IGC\Tart\Concerns\HasLineBuilding;
use IGC\Tart\Concerns\HasLists;
use IGC\Tart\Concerns\HasProgressBars;
use IGC\Tart\Concerns\HasSpinners;
use IGC\Tart\Concerns\HasTables;
use IGC\Tart\Concerns\InteractsWithStyling;
use IGC\Tart\Contracts\StyledCommandInterface;
use IGC\Tart\Contracts\ThemeInterface;
use IGC\Tart\Support\AsciiArt;
use IGC\Tart\Support\LogoBuilder;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class StyledCommand extends Command implements StyledCommandInterface
{
    use HasColoredOutput;
    use HasBlocks;
    use HasLineBuilding;
    use HasInteractivity;
    use HasEnhancedInput;
    use HasLists;
    use HasTables;
    use HasProgressBars;
    use HasSpinners;
    use InteractsWithStyling;
    use ConfiguresFormatter;

    protected ?OutputInterface $currentOutput = null;

    /**
     * Set the theme for this command.
     */
    public function setTheme(ThemeInterface $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Get the current theme.
     */
    public function getTheme(): ThemeInterface
    {
        return $this->theme;
    }

    /**
     * @param array<string, mixed> $config
     */
    public function __construct(?string $name = null, array $config = [])
    {
        parent::__construct($name);
        $this->bootStyling($config);
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        parent::initialize($input, $output);
        $this->currentOutput = $output;
        $this->configureOutputFormatter($output);
    }

    /**
     * Provide Laravel-like line helper.
     */
    protected function line(string $message): void
    {
        $this->ensureOutput()->writeln($message);
    }

    protected function getOutput(): OutputInterface
    {
        return $this->ensureOutput();
    }

    /**
     * Create a fluent logo builder for advanced logo creation.
     */
    public function logo(): LogoBuilder
    {
        return LogoBuilder::make($this->getTheme());
    }

    /**
     * Display a custom text logo with automatic decoration.
     *
     * @param array<string, mixed> $options
     */
    public function displayTextLogo(string $text, string $style = 'standard', array $options = []): self
    {
        $options = $this->logoOptions($options);
        $options['style'] = $style;

        $lines = AsciiArt::createTextLogo($text, $options);

        foreach ($lines as $line) {
            $this->line($line);
        }

        return $this;
    }

    /**
     * Display a multi-line ASCII art logo with decoration.
     *
     * @param array<string, mixed> $options
     */
    public function displayAsciiLogo(string $asciiArt, array $options = []): self
    {
        $options = $this->logoOptions($options);

        $lines = AsciiArt::createMultiLineLogo($asciiArt, $options);

        foreach ($lines as $line) {
            $this->line($line);
        }

        return $this;
    }

    /**
     * Display custom logo lines with automatic decoration.
     *
     * @param array<string> $lines
     * @param array<string, mixed> $options
     */
    public function displayCustomLogo(array $lines, array $options = []): self
    {
        $options = $this->logoOptions($options);

        $formattedLines = AsciiArt::createLogo($lines, $options);

        foreach ($formattedLines as $line) {
            $this->line($line);
        }

        return $this;
    }

    protected function ensureOutput(): OutputInterface
    {
        if ($this->currentOutput === null) {
            throw new RuntimeException('Output is not yet available.');
        }

        return $this->currentOutput;
    }
}
