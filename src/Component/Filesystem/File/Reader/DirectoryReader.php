<?php
namespace Laventure\Component\Filesystem\File\Reader;

use DirectoryIterator;

/**
 * @DirectoryReader
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Filesystem\File\Reader
*/
class DirectoryReader extends DirectoryIterator
{

     /**
      * @param string $directory
     */
     public function __construct(string $directory)
     {
         parent::__construct($directory);
     }


     /**
      * @return string
     */
     public function current(): string
     {
         return parent::getFilename();
     }


     /**
      * @return bool
     */
     public function valid(): bool
     {
         if(parent::valid()) {
             if (! parent::isDir()) {
                 parent::next();
                 return $this->valid();
             }
             return true;
         }
         return false;
     }
}