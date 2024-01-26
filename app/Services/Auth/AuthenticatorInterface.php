<?php

namespace App\Services\Auth;

interface AuthenticatorInterface
{
    public function authenticate(string $login, string $password): bool;
}

