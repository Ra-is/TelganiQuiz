<?php

namespace App\Services\Auth;

use External\Baz\Auth\Authenticator;
use External\Baz\Auth\Responses\Success;

class BazAuthenticator implements AuthenticatorInterface
{
    private $authenticator;

    // Constructor to inject an instance of Baz\Authenticator
    public function __construct(Authenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    // Method to authenticate a user using the provided login and password
    public function authenticate(string $login, string $password): bool
    {
        // Call the auth method of the injected Baz\Authenticator
        // and check if the response is an instance of Success
        $response = $this->authenticator->auth($login, $password);
        return $response instanceof Success;
    }
}
