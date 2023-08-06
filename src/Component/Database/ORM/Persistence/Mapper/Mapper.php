<?php
namespace Laventure\Component\Database\ORM\Persistence\Mapper;


/**
 * @inheritdoc
*/
abstract class Mapper implements DataMapperInterface
{

    /**
     * @param object $object
     *
     * @return mixed
    */
    abstract protected function mapRows(object $object);
}