<?php
namespace Laventure\Component\Security\Encoder;


/**
 * @EncoderInterface
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Security\Encoder
 */
interface EncoderInterface
{

    /**
     * @param array $data
     *
     * @return string
    */
    public function encode(array $data): string;




    /**
     * @param string $string
     *
     * @return mixed
    */
    public function decode(string $string): array;
}