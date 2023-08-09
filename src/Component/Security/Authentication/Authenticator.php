<?php
namespace Laventure\Component\Security\Authentication;


/**
 * @inheritdoc
*/
abstract class Authenticator implements AuthenticatorInterface
{
    /**
     * @inheritDoc
    */
    public function isGranted(array $roles): bool
    {
        return ! empty(array_intersect($roles, $this->getUser()->getRoles()));
    }

}