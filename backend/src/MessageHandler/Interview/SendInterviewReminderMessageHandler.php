<?php

namespace App\MessageHandler\Interview;

use App\Message\Interview\SendInterviewReminderMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class SendInterviewReminderMessageHandler
{
    public function __construct(
        private LoggerInterface $logger,
    ) {
    }

    public function __invoke(SendInterviewReminderMessage $message): void
    {
        $this->logger->info('JOBTRACK_CUSTOM_INTERVIEW_REMINDER_HANDLER_EXECUTED', [
            'interviewId' => $message->interviewId,
        ]);
    }
}
