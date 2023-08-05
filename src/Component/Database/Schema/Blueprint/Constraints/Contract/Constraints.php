<?php
namespace Laventure\Component\Database\Schema\Blueprint\Constraints\Contract;


/**
 * @inheritdoc
*/
abstract class Constraints implements ConstraintInterface
{

    /**
     * @param string|array $columns
    */
    public function __construct(protected string|array $columns)
    {
    }


    /**
     * @return array
    */
    public function getColumns(): array
    {
        return (array)$this->columns;
    }
}