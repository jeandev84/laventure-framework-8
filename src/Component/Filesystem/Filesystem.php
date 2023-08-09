<?php
namespace Laventure\Component\Filesystem;


use FilesystemIterator;
use Laventure\Component\Filesystem\File\Base64File;
use Laventure\Component\Filesystem\File\File;
use Laventure\Component\Filesystem\File\FileInfo;
use Laventure\Component\Filesystem\File\Iterator\FileIterator;
use Laventure\Component\Filesystem\File\Iterator\GlobalIterator;
use Laventure\Component\Filesystem\File\Locator\FileLocator;
use Laventure\Component\Filesystem\File\Reader\DirectoryReader;
use Laventure\Component\Filesystem\File\Stream;



/**
 * @Filesystem
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Filesystem
*/
class Filesystem
{

      /**
       * @var FileLocator
      */
      protected FileLocator $locator;




      /**
       * @param string $root
      */
      public function __construct(string $root = '')
      {
           $this->locator = new FileLocator($root);
      }






      /**
       * @param string $root
       *
       * @return $this
      */
      public function resourcePath(string $root): static
      {
          $this->locator->basePath($root);

          return $this;
      }






      /**
       * @param $path
       *
       * @return string
      */
      public function locate($path): string
      {
          return $this->locator->locate($path);
      }





      /**
       * @param $path
       *
       * @return mixed
      */
      public function load($path): mixed
      {
          return $this->file($path)->load();
      }





     /**
      * @param string $path
      *
      * @return FileInfo
     */
     public function info(string $path): FileInfo
     {
        return new FileInfo($this->locate($path));
     }





      /**
       * @param string $path
       *
       * @return File
      */
      public function file(string $path): File
      {
          return new File($this->locate($path));
      }








      /**
       * @param string $path
       *
       * @param string $accessMode
       *
       * @return Stream
      */
      public function stream(string $path, string $accessMode = 'r'): Stream
      {
           return new Stream($path, $accessMode);
      }






      /**
       * @param $path
       *
       * @return bool
      */
      public function exists($path): bool
      {
          return $this->file($path)->exists();
      }







      /**
       * @param string $from
       *
       * @param string $destination
       *
       * @param null $context
       *
       * @return bool
      */
      public function copy(string $from, string $destination, $context = null): bool
      {
          return $this->file($from)->copyTo($this->locate($destination), $context);
      }








      /**
       * @param string $path
       *
       * @return bool
      */
      public function remove(string $path): bool
      {
          return $this->file($path)->remove();
      }






      /**
       * @param $path
       *
       * @param string $content
       *
       * @param bool $append
       *
       * @return false|int
      */
      public function write($path, string $content, bool $append = false): false|int
      {
           return $this->file($path)->write($content, $append);
      }







      /**
       * @param $path
       *
       * @return string
      */
      public function read($path): string
      {
          return $this->file($path)->read();
      }








      /**
       * @param string $path
       *
       * @return bool
      */
      public function mkdir(string $path): bool
      {
           if(! $this->info($path)->isDir()) {
                return mkdir($this->locate($path), 0777, true);
           }

           return true;
      }








      /**
       * @param string $pattern
       *
       * @return GlobalIterator
      */
      public function glob(string $pattern): GlobalIterator
      {
          return new GlobalIterator($this->locate($pattern));
      }






      /**
       * @param string $directory
       *
       * @param string $extension
       *
       * @return FileIterator
      */
      public function find(string $directory, string $extension): FileIterator
      {
            return new FileIterator($this->locate($directory), $extension);
      }






     /**
      * @param string $directory
      *
      * @return FilesystemIterator
     */
     public function iterate(string $directory): FilesystemIterator
     {
          return new FilesystemIterator($this->locate($directory));
     }





     /**
      * @param string $directory
      *
      * @return DirectoryReader
     */
     public function readDir(string $directory): DirectoryReader
     {
          return new DirectoryReader($this->locate($directory));
     }







    /**
       * @param string $path
       *
       * @return array|false
      */
      public function scan(string $path): bool|array
      {
           if (! $this->info($path)->isDir()) {
                return false;
           }

           return scandir($this->locate($path));
      }






      /**
       * @param string $path
       *
       * @return bool
      */
      public function make(string $path): bool
      {
           return $this->file($path)->make();
      }







      /**
       * @param string $from
       *
       * @param string $to
       *
       * @return bool
      */
      public function upload(string $from, string $to): bool
      {
           return $this->file($from)->moveTo($this->locate($to));
      }







      /**
       * @param string $target
       *
       * @param Base64File $file
       *
       * @return false|int
      */
      public function uploadFromBase64(string $target, Base64File $file): bool|int
      {
           return $this->write($target, $file->data());
      }
}