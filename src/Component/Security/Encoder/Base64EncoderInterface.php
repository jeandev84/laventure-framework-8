<?php
namespace Laventure\Component\Security\Encoder;


/**
 * @Base64EncoderInterface
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Security\Encoder
*/
interface Base64EncoderInterface
{
      /**
       * @param string $string
       *
       * @return string
      */
      public function encode(string $string): string;






      /**
       * @param string $string
       *
       * @return string
      */
      public function decode(string $string): string;
}