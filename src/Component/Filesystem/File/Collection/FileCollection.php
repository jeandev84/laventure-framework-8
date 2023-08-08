<?php
namespace Laventure\Component\Filesystem\File\Collection;


use CallbackFilterIterator;
use Closure;
use Laventure\Component\Filesystem\File\File;

/**
 * @FileCollection
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Filesystem\File\Collection
*/
class FileCollection
{

      /**
       * @var File[]
      */
      protected array $files = [];



      /**
       * @var array
      */
      protected array $removed = [];





      /**
       * @param File[] $files
      */
      public function __construct(array $files)
      {
           $this->collect($files);
      }





      /**
       * @param File $file
       *
       * @return $this
      */
      public function add(File $file): static
      {
          $this->files[] = $file;

          return $this;
      }




      /**
       * @return int
      */
      public function count(): int
      {
           return count($this->files);
      }






      /**
       * @param File[] $files
       *
       * @return $this
      */
      public function collect(array $files): static
      {
          foreach ($files as $file) {
              $this->add($file);
          }

          return $this;
      }






      /**
       * @return File[]
      */
      public function getFiles(): array
      {
          return $this->files;
      }





      /**
       * @return bool
      */
      public function remove(): bool
      {
           foreach ($this->files as $file) {
               $this->removed[$file->getPathname()] = $file->remove();
           }

           return count($this->removed);
      }






      /**
       * @return array
      */
      public function removedFiles(): array
      {
           return array_keys($this->removed);
      }
}