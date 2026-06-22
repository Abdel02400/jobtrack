<?php

namespace App\MessageHandler\Interview;

use App\Message\Interview\SendInterviewReminderMessage;
use App\Repository\InterviewRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class SendInterviewReminderMessageHandler
{
    public function __construct(
        private InterviewRepository $interviewRepository,
        private LoggerInterface $logger,
    ) {
    }

    public function __invoke(SendInterviewReminderMessage $message): void
    {
        $interview = $this->interviewRepository->find($message->interviewId);

        if ($interview === null) {
            $this->logger->warning('Interview reminder skipped: interview not found.', [
                'interviewId' => $message->interviewId,
            ]);

            return;
        }

        $this->logger->info('Interview reminder ready to be sent.', [
            'interviewId' => $interview->getId(),
            'scheduledAt' => $interview->getScheduledAt()?->format(DATE_ATOM),
            'company' => $interview->getApplication()?->getCompany(),
        ]);
    }
}
