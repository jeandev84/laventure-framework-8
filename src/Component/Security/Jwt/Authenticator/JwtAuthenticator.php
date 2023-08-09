<?php
namespace Laventure\Component\Security\Jwt\Authenticator;


use Laventure\Component\Security\Authentication\Authenticator;
use Laventure\Component\Security\Jwt\Provider\JwtProviderInterface;
use Laventure\Component\Security\User\UserInterface;

class JwtAuthenticator extends Authenticator
{


    /**
     * @param JwtProviderInterface $jwtProvider
    */
    public function __construct(protected JwtProviderInterface $jwtProvider)
    {
    }




    /**
     * @inheritDoc
    */
    public function authenticateUser(string $username, string $password, bool $rememberMe = false): bool
    {

    }





    /**
     * @inheritDoc
    */
    public function getUser(): UserInterface
    {

    }




    /**
     * @inheritDoc
    */
    public function logout(): bool
    {

    }
}