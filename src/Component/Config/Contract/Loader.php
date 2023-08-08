<?php
namespace Laventure\Component\Config\Contract;

/**
 * @Loader
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Config\Contract
*/
interface Loader
{

      /**
       * Parse config params
       *
       * @return mixed
      */
      public function parse(): mixed;
}