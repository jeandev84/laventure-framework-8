<?php
namespace Laventure\Component\Templating\Template\Extension;

/**
 * @ExtensionInterface
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Templating\Template\AbstractExtension
*/
abstract class AbstractExtension implements ExtensionInterface
{
    /**
     * @inheritdoc
    */
    public function getFunctions(): array
    {
         return [];
    }




    /**
     * @inheritdoc
    */
    public function getFilters(): array
    {
        return [];
    }
}