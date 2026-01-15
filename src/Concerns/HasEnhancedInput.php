<?php

namespace IGC\Tart\Concerns;

use Closure;
use IGC\Tart\Support\FrameRenderer;

trait HasEnhancedInput
{
    /**
     * Prompt the user for text input.
     *
     * @param string $question The question to ask
     * @param string|null $default Default value if user provides no input
     * @param Closure|null $validator Optional validation callback
     * @return string
     */
    public function prompt(string $question, ?string $default = null, ?Closure $validator = null): string
    {
        // Check auto-answer mode
        if ($this->autoAnswer === true && $default !== null) {
            return $default;
        }

        $defaultText = $default ? " [{$default}]" : '';
        $prompt = "<fg=cyan>{$question}{$defaultText}:</fg=cyan> ";
        $frame = new FrameRenderer($this->getOutput(), $this->getTheme());

        while (true) {
            $frame->writeStart($prompt);
            $rawAnswer = trim((string) fgets(STDIN));
            $frame->writeFinish($prompt . $rawAnswer);

            // Use default if no answer provided
            $answer = $rawAnswer;
            if ($answer === '' && $default !== null) {
                $answer = $default;
            }

            // Validate if validator provided
            if ($validator !== null) {
                try {
                    $isValid = $validator($answer);
                    if ($isValid === false) {
                        $this->bad('Invalid input. Please try again.');

                        continue;
                    }
                } catch (\Throwable $e) {
                    $this->bad('Validation error: ' . $e->getMessage());

                    continue;
                }
            }

            return $answer;
        }
    }

    /**
     * Prompt the user for hidden input (password).
     *
     * @param string $question The question to ask
     * @return string
     */
    public function password(string $question): string
    {
        $prompt = "<fg=cyan>{$question}:</fg=cyan> ";
        $frame = new FrameRenderer($this->getOutput(), $this->getTheme());
        $frame->writeStart($prompt);

        // Disable echo for password input
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            // Windows
            $answer = $this->getHiddenInputWindows();
        } else {
            // Unix/Linux/Mac
            $answer = $this->getHiddenInputUnix();
        }

        $frame->writeFinish($prompt);

        return $answer;
    }

    /**
     * Get hidden input on Unix/Linux/Mac systems.
     *
     * @return string
     */
    protected function getHiddenInputUnix(): string
    {
        $sttyMode = shell_exec('stty -g');

        shell_exec('stty -echo');
        $answer = trim((string) fgets(STDIN));
        shell_exec(sprintf('stty %s', $sttyMode));

        return $answer;
    }

    /**
     * Get hidden input on Windows systems.
     *
     * @return string
     */
    protected function getHiddenInputWindows(): string
    {
        $exe = __DIR__ . '/../../bin/hiddeninput.exe';

        if (file_exists($exe)) {
            $value = shell_exec($exe);

            return rtrim($value ?: '');
        }

        // Fallback: read character by character (limited compatibility)
        $answer = '';
        while (true) {
            $char = fgetc(STDIN);
            if ($char === "\n" || $char === "\r" || $char === false) {
                break;
            }
            $answer .= $char;
        }

        return $answer;
    }

    /**
     * Prompt for input with validation message.
     *
     * @param string $question
     * @param string|null $default
     * @param string $validationMessage
     * @param Closure $validator
     * @return string
     */
    public function promptWithValidation(
        string $question,
        ?string $default,
        string $validationMessage,
        Closure $validator
    ): string {
        return $this->prompt($question, $default, function ($value) use ($validator, $validationMessage) {
            if (!$validator($value)) {
                throw new \InvalidArgumentException($validationMessage);
            }

            return true;
        });
    }
}
