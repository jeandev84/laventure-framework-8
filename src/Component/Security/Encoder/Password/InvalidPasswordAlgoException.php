<?php
namespace Laventure\Component\Security\Encoder\Password;


/**
 * @inheritdoc
*/
class InvalidPasswordAlgoException extends \InvalidArgumentException
{
    /**
     * @param string $algo
   */
    public function __construct(string $algo)
    {
        parent::__construct("'$algo' invalid password algorithm name.", 409);
    }
}