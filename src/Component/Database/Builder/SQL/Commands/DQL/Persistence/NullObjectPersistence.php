<?php
namespace Laventure\Component\Database\Builder\SQL\Commands\DQL\Persistence;



/**
 * @inheritdoc
*/
class NullObjectPersistence implements ObjectPersistenceInterface
{

    /**
     * @inheritDoc
    */
    public function persistence(array $objects): static
    {
         return $this;
    }
}