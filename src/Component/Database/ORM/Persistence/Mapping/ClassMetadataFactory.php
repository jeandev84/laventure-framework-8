<?php
namespace Laventure\Component\Database\ORM\Persistence\Mapping;

/**
 * @ClassMetadataFactory
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\ORM\Persistence\Mapping
*/
class ClassMetadataFactory implements ClassMetadataFactoryInterface
{

    /**
     * @inheritDoc
    */
    public function createClassMetadata(string|object $classname): ClassMetadata
    {
         return new ClassMetadata($classname);
    }
}