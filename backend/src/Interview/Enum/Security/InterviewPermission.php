<?php

namespace App\Interview\Enum\Security;

enum InterviewPermission: string
{
    case View = 'INTERVIEW_VIEW';
    case Edit = 'INTERVIEW_EDIT';
    case Delete = 'INTERVIEW_DELETE';
}
