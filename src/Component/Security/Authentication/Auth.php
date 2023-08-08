<?php
namespace Laventure\Component\Security\Authentication;


use Laventure\Component\Security\User\UserInterface;

/**
 * @Auth
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Authentication
*/
class Auth
{


    /**
     * @param AuthenticatorInterface $authenticator
    */
    public function __construct(protected AuthenticatorInterface $authenticator)
    {
    }





    /**
     * authenticate user
     *
     * @param string $username
     *
     * @param string $password
     *
     * @param bool $rememberMe
     *
     * @return bool
    */
    public function attempt(string $username, string $password, bool $rememberMe = false): bool
    {
        return $this->authenticator->authenticateUser($username, $password, $rememberMe);
    }








    /**
     * @return UserInterface
    */
    public function getUser(): UserInterface
    {
        return $this->authenticator->getUser();
    }







    /**
     * @param array $roles
     *
     * @return bool
    */
    public function isGranted(array $roles): bool
    {
        return $this->authenticator->isGranted($roles);
    }






    /**
     * @return bool
    */
    public function logout(): bool
    {
        return $this->authenticator->logout();
    }
}