<?php
namespace Laventure\Component\Security\User\Encoder\Password;


use Laventure\Component\Security\Encoder\PasswordEncoderInterface;
use Laventure\Component\Security\User\UserInterface;


/**
 * @UserPasswordEncoder
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package  Laventure\Component\Security\User\Encoder\Password
 */
class UserPasswordEncoder implements UserPasswordEncoderInterface
{


    /**
     * @var PasswordEncoderInterface
     */
    protected PasswordEncoderInterface $encoder;




    /**
     * @param PasswordEncoderInterface $encoder
    */
    public function __construct(PasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }




    /**
     * @inheritDoc
     */
    public function encodePassword(UserInterface $user, string $plainPassword): string
    {
        return $this->encoder->encodePassword($plainPassword, $user->getSalt());
    }





    /**
     * @inheritDoc
     */
    public function isPasswordValid(UserInterface $user, string $plainPassword): bool
    {
        return $this->encoder->isPasswordValid($plainPassword, $user->getPassword());
    }




    /**
     * @inheritDoc
    */
    public function needsRehash(UserInterface $user)
    {
        return $this->encoder->needsRehash($user->getPassword());
    }
}