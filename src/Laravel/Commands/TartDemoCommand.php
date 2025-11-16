<?php

namespace IGC\Tart\Laravel\Commands;

use IGC\Tart\Laravel\StyledCommand;
use IGC\Tart\Themes\SuccessTheme;

class TartDemoCommand extends StyledCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tart:demo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Showcase the most common TART formatting features';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $originalTheme = $this->getTheme();

        $this->logoBlock();
        $this->header('TART Demo Guide');

        $this->narrate('Welcome! This self-documenting tour walks through the typography, spacing, and theming helpers that ship with TART.');
        $this->narrate('Every line you see is produced by a helper method so you can copy/paste the snippets straight into your own commands.');
        $this->br();

        $this->title('Typography Basics');
        $this->narrate('Use say() for neutral narrative text like this paragraph.');
        $this->good('good() highlights wins or completed work.');
        $this->state('state() is perfect for heads-up display style updates.');
        $this->bad('bad() keeps failures loud and impossible to miss.');
        $this->cool('cool() adds an informational cyan tone for helpful hints.');
        $this->br();

        $this->title('Layout & Rhythm');
        $this->narrate('br() inserts blank lines. Call br(2) for extra breathing room, and hr() when you want a clean divider:');
        $this->br();
        $this->hr();
        $this->br();
        $this->narrate('Use these helpers whenever you need to give the eye a break.');
        $this->br(2);

        $this->title('Line Building & Columns');
        $this->narrate('openLine(), appendLine(), and closeLine() let you narrate progress inline:');
        $this->openLine('Download Assets');
        $this->appendLine(' ...', 'yellow');
        $this->appendLine(' Done', 'green');
        $this->closeLine();

        $this->openLine('Compile Frontend');
        $this->appendLine(' ...', 'yellow');
        $this->appendLine(' Done', 'green');
        $this->closeLine();
        $this->br();

        $this->narrate('Need structured columns? addColumn() pads everything for you:');
        $this->openLine('Module');
        $this->addColumn('Status', 15, 'yellow');
        $this->addColumn('Duration', 15, 'cyan');
        $this->closeLine();
        $this->openLine('Auth');
        $this->addColumn('Healthy', 15, 'green');
        $this->addColumn('213ms', 15, 'cyan');
        $this->closeLine();
        $this->openLine('Billing');
        $this->addColumn('Investigate', 15, 'yellow');
        $this->addColumn('1.4s', 15, 'cyan');
        $this->closeLine();
        $this->br();

        $this->title('Path Highlighting');
        $this->narrate('PathHighlight() keeps file references readable even inside dense logs:');
        $this->say($this->pathHighlight('/var/www/html/app/Console/Commands/TartDemoCommand.php'));
        $this->br();

        $this->title('Theme Switching & Logos');
        $this->narrate('Calling setTheme() lets different moments in your workflow adopt their own palettes.');
        $this->setTheme(new SuccessTheme());
        $this->success('SuccessTheme engaged — perfect for celebratory summaries.');
        $this->displayTextLogo('SUCCESS MODE', 'box', [
            'text_color' => 'green',
        ]);
        $this->displayTextLogo('TYPOGRAPHY MATTERS', 'banner', [
            'text_color' => 'cyan',
        ]);
        $this->setTheme($originalTheme);
        $this->br();

        $this->title('Block Messages Recap');
        $this->success('success() wraps paragraphs in vivid green blocks.');
        $this->warning('warning() grabs attention for risky operations.');
        $this->notice('notice() shines a cyan spotlight on FYIs.');
        $this->failure('failure() keeps post-mortems readable.');
        $this->br();

        $this->narrate('Each of these sections came straight from the methods documented in docs/guides/QUICK-REFERENCE.md — run `php artisan vendor:publish --tag=tart-config` to tune the theme defaults for your team.');

        $this->br();
        $this->footer('Demo', 'Walkthrough complete');

        return self::SUCCESS;
    }

    /**
     * Wrap long paragraphs to the current theme width.
     */
    protected function narrate(string $text): void
    {
        $width = max(10, $this->getTheme()->getMaxLineWidth() - 4);
        foreach (explode("\n", wordwrap($text, $width)) as $line) {
            $this->say($line);
        }
    }
}

