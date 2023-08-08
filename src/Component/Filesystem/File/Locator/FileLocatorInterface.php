<?php
namespace Laventure\Component\Filesystem\File\Locator;


/**
 * @FileLocator
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Filesystem\File\Locator
 */
interface FileLocatorInterface
{

    /**
     * Localize full path
     *
     * @param string $path
     *
     * @return string
    */
    public function locate(string $path): string;
}