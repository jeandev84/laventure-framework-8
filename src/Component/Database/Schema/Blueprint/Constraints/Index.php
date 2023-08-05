<?php
namespace Laventure\Component\Database\Schema\Blueprint\Constraints;

use Laventure\Component\Database\Schema\Blueprint\Constraints\Contract\Constraints;

/**
 * @inheritdoc
*/
class Index extends Constraints
{

    /**
     * @inheritDoc
    */
    public function __toString(): string
    {
        return "INDEX(". join(',', $this->getColumns()) . ")";
    }
}