<?php

namespace App\JobApplication\Enum\Security;

enum ApplicationPermission: string
{
    case View = 'APPLICATION_VIEW';
    case Edit = 'APPLICATION_EDIT';
    case Delete = 'APPLICATION_DELETE';
}
