<?php

namespace App\Interview\Message;

final readonly class SendInterviewReminderMessage
{
    public function __construct(
        public int $interviewId,
    ) {
    }
}
