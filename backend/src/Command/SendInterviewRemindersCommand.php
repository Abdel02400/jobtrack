<?php

namespace App\Command;

use App\Message\Interview\SendInterviewReminderMessage;
use App\Repository\InterviewRepository;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:send-interview-reminders',
    description: 'Add a short description for your command',
)]
class SendInterviewRemindersCommand extends Command
{
    public function __construct(
        private readonly InterviewRepository $interviewRepository,
        private readonly MessageBusInterface $messageBus,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $interviews = $this->interviewRepository->findScheduledInNext24Hours();

        foreach ($interviews as $interview) {
            $this->messageBus->dispatch(
                new SendInterviewReminderMessage(
                    $interview->getId()
                )
            );
        }

        $io->success(sprintf(
            '%d reminder(s) dispatched.',
            count($interviews)
        ));

        return Command::SUCCESS;
    }
}
