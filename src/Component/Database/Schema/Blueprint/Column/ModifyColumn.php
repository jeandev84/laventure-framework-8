<?php
namespace Laventure\Component\Database\Schema\Blueprint\Column;


/**
 * @inheritdoc
*/
class ModifyColumn extends Column
{

    /**
     * @param string $name
     *
     * @param string $type
     *
     * @param string $constraints
    */
    public function __construct(string $name, string $type, string $constraints = '')
    {
        parent::__construct("MODIFY COLUMN $name", $type, $constraints);
    }
}