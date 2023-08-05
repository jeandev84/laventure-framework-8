<?php
namespace Laventure\Component\Database\Schema\Blueprint\Constraints;

use Laventure\Component\Database\Schema\Blueprint\Constraints\Contract\Constraints;


/**
 * @inheritdoc
*/
class PrimaryKey extends Constraints
{

    /**
     * @inheritDoc
    */
    public function __toString(): string
    {
        return "PRIMARY KEY (". join(',', $this->getColumns()) . ")";
    }
}