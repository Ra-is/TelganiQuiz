<?php

namespace App\Services\Auth;

use External\Bar\Auth\LoginService;

class BarAuthenticator implements AuthenticatorInterface
{
    private $loginService;

    // Constructor to inject an instance of LoginService
    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    // Method to authenticate a user using the provided login and password
    public function authenticate(string $login, string $password): bool
    {
        // Call the login method of the injected LoginService and return the result
        return $this->loginService->login($login, $password);
    }
}
