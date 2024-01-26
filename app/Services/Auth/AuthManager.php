<?php

namespace App\Services\Auth;

use External\Bar\Auth\LoginService;
use External\Baz\Auth\Authenticator;
use External\Foo\Auth\AuthWS;
use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Token\Builder as TokenBuilder;

class AuthManager
{
    protected $loginPrefix;
    protected $generatedToken;

    // Method to set the login prefix
    public function setLoginPrefix($loginPrefix)
    {
        $this->loginPrefix = $loginPrefix;
    }

    // Method to authenticate a user
    public function authenticateUser($login, $password): bool
    {
        $this->setLoginPrefix($this->determineLoginPrefix($login));
        $authenticator = $this->getAuthenticator();

        // If authentication is successful, generate JWT token
        if ($authenticator->authenticate($login, $password)) {
            $this->generatedToken = $this->generateJwtToken($login);
            return true;
        }

        return false;
    }

    // Method to determine the login prefix based on the provided login
    protected function determineLoginPrefix($login): string
    {
        if (preg_match("/^FOO_.*/", $login)) {
            return 'FOO';
        } elseif (preg_match("/^BAR_.*/", $login)) {
            return 'BAR';
        } elseif (preg_match("/^BAZ_.*/", $login)) {
            return 'BAZ';
        } else {
            throw new \Exception('Undefined login prefix for: ' . $login);
        }
    }

    // Method to generate a JWT token
    public function generateJwtToken($login)
    {
        $tokenBuilder = new TokenBuilder(new JoseEncoder(), ChainedFormatter::default());
        $algorithm = new Sha256();

        // Generate a random 32-byte key and convert it to a 64-character hexadecimal string
        $randomBytes = random_bytes(32);
        $hexKey = bin2hex($randomBytes);
        $signingKey = InMemory::plainText($hexKey);

        $now = new \DateTimeImmutable();
        $token = $tokenBuilder
            ->issuedBy('http://example.com')
            ->permittedFor('http://example.com')
            ->identifiedBy('MY_TEST_TOKEN_JWT')
            ->issuedAt($now)
            ->expiresAt($now->modify('+1 hour'))
            ->withClaim('login', $login)
            ->withClaim('system', $this->loginPrefix)
            ->getToken($algorithm, $signingKey);

        // Return the generated token as a string
        return $token->toString();
    }

    // Getter method to retrieve the generated token
    public function getGeneratedToken()
    {
        return $this->generatedToken;
    }

    // Method to get the appropriate authenticator based on the login prefix
    protected function getAuthenticator(): AuthenticatorInterface
    {
        switch ($this->loginPrefix) {
            case 'FOO':
                return new FooAuthenticator(new AuthWS());
            case 'BAR':
                return new BarAuthenticator(new LoginService());
            case 'BAZ':
                return new BazAuthenticator(new Authenticator());
            default:
                throw new \Exception('Undefined Authenticator for login prefix: ' . $this->loginPrefix);
        }
    }
}
