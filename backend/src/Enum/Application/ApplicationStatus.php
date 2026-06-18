<?php

namespace App\Enum\Application;

enum ApplicationStatus: string
{
    case Applied = 'applied';
    case Screening = 'screening';
    case Interview = 'interview';
    case Offer = 'offer';
    case Rejected = 'rejected';
}
