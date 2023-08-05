<?php
namespace Laventure\Component\Database\Schema\Blueprint\Constraints;

use Laventure\Component\Database\Schema\Blueprint\Constraints\Contract\Constraints;

/**
 * @inheritdoc
*/
class Unique extends Constraints
{


    /**
     * @inheritDoc
    */
    public function __toString(): string
    {
        return "UNIQUE(". join(',', $this->getColumns()) . ")";
    }
}