<?php

namespace App\Enum\Security\Interview;

enum InterviewPermission: string
{
    case View = 'INTERVIEW_VIEW';
    case Edit = 'INTERVIEW_EDIT';
    case Delete = 'INTERVIEW_DELETE';
}
