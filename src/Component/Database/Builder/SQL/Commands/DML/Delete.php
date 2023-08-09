<?php
namespace Laventure\Component\Database\Builder\SQL\Commands\DML;

use Laventure\Component\Database\Builder\SQL\Commands\SQLBuilderHasConditions;


/**
 * @inheritdoc
*/
class Delete extends SQLBuilderHasConditions
{

    /**
     * @inheritDoc
    */
    public function getSQL(): string
    {
        $sql[] = sprintf('DELETE FROM %s', $this->getTable());
        $sql[] = $this->whereSQL();

        return join(' ', array_filter($sql)) . ";";
    }



    /**
     * @return bool
    */
    public function execute(): bool
    {
        return $this->statement()->execute();
    }
}