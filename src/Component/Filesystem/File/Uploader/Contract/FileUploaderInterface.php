<?php
namespace Laventure\Component\Filesystem\File\Uploader\Contract;

/**
 * @FileUploaderInterface
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Filesystem\File\Uploader\Contract
*/
interface FileUploaderInterface
{
      /**
       * Upload file
       *
       * @param string $from
       *
       * @param string $to
       *
       * @return mixed
      */
      public function upload(string $from, string $to): mixed;
}