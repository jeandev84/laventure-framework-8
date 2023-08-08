<?php
namespace Laventure\Component\Security\User\Token;

use Laventure\Component\Security\User\UserInterface;


/**
 * @inheritdoc
*/
class UserToken implements UserTokenInterface
{

    /**
     * @var UserInterface
    */
    protected UserInterface $user;



    /**
     * @param UserInterface $user
     */
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }




    /**
     * @inheritDoc
    */
    public function getUser(): UserInterface
    {
        return $this->user;
    }


    /**
     * @inheritDoc
    */
    public function serialize(): string
    {
        return serialize($this);
    }
}