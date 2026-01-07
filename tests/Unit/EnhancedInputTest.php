<?php

namespace IGC\Tart\Tests\Unit;

use IGC\Tart\Concerns\HasEnhancedInput;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\BufferedOutput;

class EnhancedInputTest extends TestCase
{
    public function test_prompt_returns_default_in_auto_answer_mode(): void
    {
        $command = new class () {
            use HasEnhancedInput;

            public bool $autoAnswer = true;

            public function getOutput()
            {
                return new BufferedOutput();
            }
        };

        $result = $command->prompt('Test question?', 'default_value');

        $this->assertEquals('default_value', $result);
    }

    public function test_hidden_input_methods_exist(): void
    {
        $command = new class () {
            use HasEnhancedInput;

            public bool $autoAnswer = false;

            public function getOutput()
            {
                return new BufferedOutput();
            }
        };

        $this->assertTrue(method_exists($command, 'password'));
        $this->assertTrue(method_exists($command, 'getHiddenInputUnix'));
        $this->assertTrue(method_exists($command, 'getHiddenInputWindows'));
    }
}
