<?php

namespace App\JobApplication\Domain;

use App\JobApplication\Enum\ApplicationStatus;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

final class ApplicationStatusTransitionService
{
    private const ALLOWED_TRANSITIONS = [
        ApplicationStatus::Applied->value => [
            ApplicationStatus::Screening,
            ApplicationStatus::Rejected,
        ],
        ApplicationStatus::Screening->value => [
            ApplicationStatus::Interview,
            ApplicationStatus::Rejected,
        ],
        ApplicationStatus::Interview->value => [
            ApplicationStatus::Offer,
            ApplicationStatus::Rejected,
        ],
        ApplicationStatus::Offer->value => [],
        ApplicationStatus::Rejected->value => [],
    ];

    public function canTransition(
        ApplicationStatus $from,
        ApplicationStatus $to,
    ): bool {
        if ($from === $to) {
            return true;
        }

        return in_array(
            $to,
            self::ALLOWED_TRANSITIONS[$from->value] ?? [],
            true
        );
    }

    public function assertCanTransition(
        ApplicationStatus $from,
        ApplicationStatus $to,
    ): void {
        if ($this->canTransition($from, $to)) {
            return;
        }

        throw new UnprocessableEntityHttpException(sprintf(
            'Invalid application status transition from "%s" to "%s".',
            $from->value,
            $to->value
        ));
    }
}
