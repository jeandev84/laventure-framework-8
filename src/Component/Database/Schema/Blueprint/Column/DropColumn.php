<?php
namespace Laventure\Component\Database\Schema\Blueprint\Column;

/**
 * @inheritdoc
*/
class DropColumn extends Column
{

    /**
     * @param string $name
    */
    public function __construct(string $name)
    {
        parent::__construct("DROP COLUMN $name", '', '');
    }




    /**
     * @return string
    */
    public function getConstraints(): string
    {
        return '';
    }
}