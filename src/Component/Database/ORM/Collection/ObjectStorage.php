<?php
namespace Laventure\Component\Database\ORM\Collection;


/**
 * @inheritdoc
*/
class ObjectStorage extends \SplObjectStorage
{

    /**
     * @return int
    */
    public function clear(): int
    {
        return $this->removeAll($this);
    }
}