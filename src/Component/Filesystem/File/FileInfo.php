<?php
namespace Laventure\Component\Filesystem\File;

/**
 * @FileInfo
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Filesystem\File
*/
class FileInfo extends \SplFileInfo
{
     /**
      * @return string
     */
     public function getDirname(): string
     {
         return $this->getPath();
     }
}