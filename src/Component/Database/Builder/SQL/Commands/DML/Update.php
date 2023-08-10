<?php
namespace Laventure\Component\Database\Builder\SQL\Commands\DML;

use Laventure\Component\Database\Builder\SQL\Commands\SQLBuilderHasConditions;


/**
 * @inheritdoc
*/
class Update extends SQLBuilderHasConditions
{


    /**
     * @var array
    */
    protected array $data = [];





    /**
     * @param array $attributes
     *
     * @param array $wheres
     *
     * @return $this
    */
    public function update(array $attributes, array $wheres): static
    {
         $this->data = $this->resolveBindingParameters($attributes);
         $this->setParameters($attributes);
         $this->criteria($wheres);

         return $this;
    }







    /**
     * @inheritDoc
    */
    public function getSQL(): string
    {
        $sql[] = sprintf("UPDATE %s %s", $this->getTable(), $this->setted());
        $sql[] = $this->whereSQL();

        return join(' ', array_filter($sql)).';';
    }







    /**
     * @return string
    */
    private function setted(): string
    {
        return sprintf('SET %s', join(', ', $this->data));
    }





    /**
     * @return false|int
    */
    public function execute(): false|int
    {
        return $this->statement()->execute();
    }
}