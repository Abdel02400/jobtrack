<?php

namespace App\Message\Interview;

final readonly class SendInterviewReminderMessage
{
    public function __construct(
        public int $interviewId,
    ) {
    }
}
