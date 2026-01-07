<?php

namespace IGC\Tart\Tests\Integration;

use IGC\Tart\Symfony\StyledCommand as SymfonyStyledCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Tester\CommandTester;

class SymfonyStyledCommandTest extends TestCase
{
    public function test_symfony_command_executes_successfully(): void
    {
        $application = new Application();

        $command = new class ('symfony:tart-demo') extends SymfonyStyledCommand {
            protected function execute(InputInterface $input, OutputInterface $output): int
            {
                $this->say('Hello Symfony');
                $this->success('Done!');

                return Command::SUCCESS;
            }
        };

        $application->add($command);

        $tester = new CommandTester($application->find('symfony:tart-demo'));
        $exitCode = $tester->execute([]);

        $this->assertSame(Command::SUCCESS, $exitCode);
        $this->assertStringContainsString('Hello Symfony', $tester->getDisplay());
    }
}
