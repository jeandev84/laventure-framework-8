<?php
namespace Laventure\Component\Security\Encoder;


/**
 * @PasswordEncoderInterface
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Security\Encoder
*/
interface PasswordEncoderInterface
{

    /**
     * @param string $plainPassword
     *
     * @param string|null $salt
     *
     * @return string
    */
    public function encodePassword(string $plainPassword, string $salt = null): string;




    /**
     * @param string $plainPassword
     *
     * @param string $hash
     *
     * @return bool
    */
    public function isPasswordValid(string $plainPassword, string $hash): bool;






    /**
     * @param string $hash
     *
     * @return bool
    */
    public function needsRehash(string $hash): bool;








    /**
     * @return string
    */
    public function getAlgo(): string;
}