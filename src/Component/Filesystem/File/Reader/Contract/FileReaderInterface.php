<?php
namespace Laventure\Component\Filesystem\File\Reader\Contract;

/**
 * @FileReaderInterface
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Filesystem\File\Reader\Contract
*/
interface FileReaderInterface
{

      /**
       * Read file as string
       *
       * @param string $path
       *
       * @return mixed
      */
      public function read(string $path): mixed;
}