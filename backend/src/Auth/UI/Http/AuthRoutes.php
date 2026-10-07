<?php

namespace App\Auth\UI\Http;

final class AuthRoutes
{
    private const PREFIX = '/auth';

    public const REGISTER = self::PREFIX . '/register';
    public const LOGIN = self::PREFIX . '/login';
    public const ME = self::PREFIX . '/me';
}
