<?php

namespace App\Enum\Interview;

enum InterviewType: string
{
    case Phone = 'phone';
    case Video = 'video';
    case OnSite = 'on_site';
}
