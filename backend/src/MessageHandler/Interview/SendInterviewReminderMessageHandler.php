<?php

namespace App\MessageHandler\Interview;

use App\Message\Interview\SendInterviewReminderMessage;
use App\Repository\InterviewRepository;
use DateTimeImmutable;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
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
        private MailerInterface $mailer,
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

        $user = $interview->getApplication()?->getUser();
        $recipient = $user?->getEmail();

        if ($recipient === null) {
            $this->logger->warning('Interview reminder skipped: recipient email not found.', [
                'interviewId' => $interview->getId(),
            ]);

            return;
        }

        $email = (new Email())
            ->from('no-reply@jobtrack.local')
            ->to($recipient)
            ->subject('Rappel : entretien à venir')
            ->text(sprintf(
                "Bonjour,\n\nVous avez un entretien prévu le %s pour votre candidature chez %s.\n\nJobTrack",
                $interview->getScheduledAt()?->format('d/m/Y H:i'),
                $interview->getApplication()?->getCompany() ?? 'une entreprise'
            ));

        $this->mailer->send($email);

        $interview->setReminderSentAt(new DateTimeImmutable());

        $this->entityManager->flush();
    }
}
