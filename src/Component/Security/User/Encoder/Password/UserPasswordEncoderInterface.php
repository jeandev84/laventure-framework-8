<?php
namespace Laventure\Component\Security\User\Encoder\Password;

use Laventure\Component\Security\User\UserInterface;

/**
 * @UserPasswordEncoderInterface
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Security\User\Encoder\Password
 */
interface UserPasswordEncoderInterface
{


    /**
     * @param UserInterface $user
     *
     * @param string $plainPassword
     *
     * @return string
    */
    public function encodePassword(UserInterface $user, string $plainPassword): string;







    /**
     * @param UserInterface $user
     *
     * @param string $plainPassword
     *
     * @return bool
    */
    public function isPasswordValid(UserInterface $user, string $plainPassword): bool;






    /**
     * @param UserInterface $user
     *
     * @return mixed
    */
    public function needsRehash(UserInterface $user);
}