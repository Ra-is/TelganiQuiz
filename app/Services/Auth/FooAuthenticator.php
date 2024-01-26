<?php

namespace App\Services\Auth;

use External\Foo\Auth\AuthWS;
use External\Foo\Exceptions\AuthenticationFailedException;

class FooAuthenticator implements AuthenticatorInterface
{
    private $authWS;

    // Constructor to inject an instance of Foo\Auth\AuthWS
    public function __construct(AuthWS $authWS)
    {
        $this->authWS = $authWS;
    }

    // Method to authenticate a user using the provided login and password
    public function authenticate(string $login, string $password): bool
    {
        try {
            // Call the authenticate method of the injected Foo\Auth\AuthWS
            // and return true if authentication is successful
            $this->authWS->authenticate($login, $password);
            return true;
        } catch (AuthenticationFailedException $exception) {
            // Catch AuthenticationFailedException and return false
            return false;
        }
    }
}
