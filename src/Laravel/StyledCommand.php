<?php

namespace IGC\Tart\Laravel;

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
use Illuminate\Console\Command;
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

    public function __construct()
    {
        parent::__construct();
        $this->bootStyling();
    }

    /**
     * Confirm a question with the user (styled version).
     *
     * Overrides Laravel's confirm() to add beautiful styling.
     * Signature matches parent for compatibility.
     *
     * @param string $question
     * @param bool $default
     * @return bool
     */
    public function confirm($question, $default = false)
    {
        // If auto-answer mode is enabled, return the default
        if ($this->autoAnswer === true) {
            return $default;
        }

        // For styled confirmation, use our custom styling
        // Note: Laravel 9+ has a different implementation, so we'll use the parent's method
        // but could enhance it with styling if needed
        return parent::confirm($question, $default);
    }

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
     * Run the command (override to set up custom styles).
     */
    public function run(InputInterface $input, OutputInterface $output): int
    {
        $this->configureOutputFormatter($output);

        return parent::run($input, $output);
    }

    /**
     * Display a demo of all available text styles.
     */
    public function demoText(): void
    {
        $this->title('New Activity');
        $this->say('Some general stuff is going on...');
        $this->good('Gooooood...');
        $this->bad('Baaaaaaaaaaad...');
        $this->state('X is a F in B and needs a K up the A...');
        $this->cool('Coconut Mojhitos with ICE CUBES...');
        $this->success('IGC WOOP!');
        $this->notice('Ice is cold like Cyan...');
        $this->error('Postboxes are Red too...');
    }

    /**
     * Display a comprehensive demo of all TART features.
     *
     * This method showcases the most common TART features in a single call.
     * Perfect for testing, demonstrations, and learning what TART can do.
     */
    public function demo(): void
    {
        // Logo
        $this->logoBlock();

        // Header
        $this->header('Processing');

        // Basic output
        $this->say('Processing data...');
        $this->good('✓ Step 1 complete');

        $this->br();

        // Title block
        $this->title('Section Title');

        // Block messages
        $this->success('Operation succeeded!');
        $this->warning('Check this issue');
        $this->notice('Important info');
        $this->failure('Operation failed');

        // Final success
        $this->success('Deployment complete!');

        // Footer
        $this->footer('Process', 'Time: 2.5s');
    }

    /**
     * Display the TART logo (Terminal Art for Artisan).
     * Each letter is colored: T=Red, A=Blue, R=Green, T=Yellow
     */
    public function tartLogo(): void
    {
        $maxWidth = 80;
        $logoWidth = 39;
        $leftPad = (int) floor(($maxWidth - $logoWidth) / 2);
        $rightPad = $maxWidth - $logoWidth - $leftPad;
        
        $left = str_repeat(' ', $leftPad);
        $right = str_repeat(' ', $rightPad);

        $this->colorBlocks(3);
        $this->line('<igc>' . str_repeat(' ', $maxWidth) . '</igc>');
        $this->line('<igc>' . $left . '<bg=black;fg=red;options=bold>████████╗</bg=black;fg=red;options=bold> <bg=black;fg=blue;options=bold> █████╗ </bg=black;fg=blue;options=bold> <bg=black;fg=green;options=bold>██████╗ </bg=black;fg=green;options=bold> <bg=black;fg=yellow;options=bold>████████╗</bg=black;fg=yellow;options=bold>' . $right . '</igc>');
        $this->line('<igc>' . $left . '<bg=black;fg=red;options=bold>╚══██╔══╝</bg=black;fg=red;options=bold> <bg=black;fg=blue;options=bold>██╔══██╗</bg=black;fg=blue;options=bold> <bg=black;fg=green;options=bold>██╔══██╗</bg=black;fg=green;options=bold> <bg=black;fg=yellow;options=bold>╚══██╔══╝</bg=black;fg=yellow;options=bold>' . $right . '</igc>');
        $this->line('<igc>' . $left . '<bg=black;fg=red;options=bold>   ██║   </bg=black;fg=red;options=bold> <bg=black;fg=blue;options=bold>███████║</bg=black;fg=blue;options=bold> <bg=black;fg=green;options=bold>██████╔╝</bg=black;fg=green;options=bold> <bg=black;fg=yellow;options=bold>   ██║   </bg=black;fg=yellow;options=bold>' . $right . '</igc>');
        $this->line('<igc>' . $left . '<bg=black;fg=red;options=bold>   ██║   </bg=black;fg=red;options=bold> <bg=black;fg=blue;options=bold>██╔══██║</bg=black;fg=blue;options=bold> <bg=black;fg=green;options=bold>██╔══██╗</bg=black;fg=green;options=bold> <bg=black;fg=yellow;options=bold>   ██║   </bg=black;fg=yellow;options=bold>' . $right . '</igc>');
        $this->line('<igc>' . $left . '<bg=black;fg=red;options=bold>   ██║   </bg=black;fg=red;options=bold> <bg=black;fg=blue;options=bold>██║  ██║</bg=black;fg=blue;options=bold> <bg=black;fg=green;options=bold>██║  ██║</bg=black;fg=green;options=bold> <bg=black;fg=yellow;options=bold>   ██║   </bg=black;fg=yellow;options=bold>' . $right . '</igc>');
        $this->line('<igc>' . $left . '<bg=black;fg=red;options=bold>   ╚═╝   </bg=black;fg=red;options=bold> <bg=black;fg=blue;options=bold>╚═╝  ╚═╝</bg=black;fg=blue;options=bold> <bg=black;fg=green;options=bold>╚═╝  ╚═╝</bg=black;fg=green;options=bold> <bg=black;fg=yellow;options=bold>   ╚═╝   </bg=black;fg=yellow;options=bold>' . $right . '</igc>');
        $this->line('<igc>' . str_repeat(' ', $maxWidth) . '</igc>');
        
        $taglineWidth = 24;
        $taglineLeft = (int) floor(($maxWidth - $taglineWidth) / 2);
        $taglineRight = $maxWidth - $taglineWidth - $taglineLeft;
        $this->line('<igc>' . str_repeat(' ', $taglineLeft) . '<fg=cyan;options=bold>Terminal Art for Artisan</fg=cyan;options=bold>' . str_repeat(' ', $taglineRight) . '</igc>');
        
        $this->line('<igc>' . str_repeat(' ', $maxWidth) . '</igc>');
        $this->colorBlocks(3);
    }

    /**
     * Display the ProFusion logo (legacy).
     *
     * @deprecated Use tartLogo() instead
     */
    public function proFusionLogo(): void
    {
        $this->tartLogo();
    }

    /**
     * Display the EnMasse logo.
     */
    public function enMasseLogo(): void
    {
        $this->line('    ______   __   __   __    __   ______   ______   ______   ______    ');
        $this->line("   /\  ___\ /\ \"-.\ \ /\ \"-./  \ /\  __ \ /\  ___\ /\  ___\ /\  ___\   ");
        $this->line("   \ \  __\ \ \ \-.  \\\\ \ \-./\ \\\\ \  __ \\\\ \___  \\\\ \___  \\\\ \  __\   ");
        $this->line("    \ \_____\\\\ \_\\\\\"\_\\\\ \_\ \ \_\\\\ \_\ \_\\\\/\_____\\\\/\_____\\\\ \_____\ ");
        $this->line("     \/_____/ \/_/ \/_/ \/_/  \/_/ \/_/\/_/ \/_____/ \/_____/ \/_____/ ");
        $this->line(' ');
    }

    /**
     * Display the IGC ProFusion logo block (legacy).
     *
     * @deprecated Use tartLogo() instead
     */
    public function logoBlock(): void
    {
        $this->tartLogo();
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
     * @param string $text The text to display
     * @param string $style Style: 'standard', 'box', or 'banner'
     * @param array<string, mixed> $options Additional options
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
     * @param string $asciiArt Multi-line ASCII art
     * @param array<string, mixed> $options Additional options
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
     * @param array<string> $lines Array of logo lines
     * @param array<string, mixed> $options Configuration options
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
}
