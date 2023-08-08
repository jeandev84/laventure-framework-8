<?php
namespace Laventure\Component\Filesystem\File\Loader;

use Laventure\Component\Filesystem\File\Loader\Contract\FileLoaderInterface;


/**
 * @inheritdoc
*/
class FileLoader implements FileLoaderInterface
{

    /**
     * @inheritDoc
    */
    public function load(string $path): mixed
    {
        return require_once $path;
    }
}