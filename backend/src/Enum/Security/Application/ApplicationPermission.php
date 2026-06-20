<?php

namespace App\Enum\Security\Application;

enum ApplicationPermission: string
{
    case View = 'APPLICATION_VIEW';
    case Edit = 'APPLICATION_EDIT';
    case Delete = 'APPLICATION_DELETE';
}
