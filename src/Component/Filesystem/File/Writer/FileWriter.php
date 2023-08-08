<?php
namespace Laventure\Component\Filesystem\File\Writer;

use Laventure\Component\Filesystem\File\Locator\FileLocator;
use Laventure\Component\Filesystem\File\Writer\Contract\FileWriterInterface;

/**
 * @inheritdoc
*/
class FileWriter implements FileWriterInterface
{

    /**
     * @inheritDoc
    */
    public function write(string $path, string $content, int $flags = 0, $context = null): false|int
    {
        return file_put_contents($path, $content, $flags, $context);
    }
}