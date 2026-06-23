<?php

namespace App\Interview\Enum;

enum InterviewType: string
{
    case Phone = 'phone';
    case Video = 'video';
    case OnSite = 'on_site';
}
