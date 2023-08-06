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
    abstract protected function mapRows(object $object): mixed;





    /**
     * @param array $data
     *
     * @return object
    */
    abstract protected function fromState(array $data): object;
}