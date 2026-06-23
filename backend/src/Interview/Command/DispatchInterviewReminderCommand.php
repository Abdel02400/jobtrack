<?php

namespace App\Interview\Command;

use App\Interview\Message\SendInterviewReminderMessage;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'app:dispatch-interview-reminder',
)]
final class DispatchInterviewReminderCommand extends Command
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('interviewId', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $interviewId = (int) $input->getArgument('interviewId');

        $this->messageBus->dispatch(
            new SendInterviewReminderMessage($interviewId),
        );

        $output->writeln(sprintf(
            'Interview reminder message dispatched for interview #%d',
            $interviewId,
        ));

        return Command::SUCCESS;
    }
}
