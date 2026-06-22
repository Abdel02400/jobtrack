<?php

namespace App\MessageHandler\Interview;

use App\Message\Interview\SendInterviewReminderMessage;
use App\Repository\InterviewRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class SendInterviewReminderMessageHandler
{
    public function __construct(
        private InterviewRepository $interviewRepository,
        private LoggerInterface $logger,
        private EntityManagerInterface $entityManager,
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

        if ($interview->getReminderSentAt() !== null) {
            $this->logger->info('Interview reminder skipped: reminder already sent.', [
                'interviewId' => $interview->getId(),
                'reminderSentAt' => $interview->getReminderSentAt()->format(DATE_ATOM),
            ]);

            return;
        }

        $this->logger->info('Interview reminder ready to be sent.', [
            'interviewId' => $interview->getId(),
            'scheduledAt' => $interview->getScheduledAt()?->format(DATE_ATOM),
            'company' => $interview->getApplication()?->getCompany(),
        ]);

        $interview->setReminderSentAt(new DateTimeImmutable());

        $this->entityManager->flush();
    }
}
