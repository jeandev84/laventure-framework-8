<?php
namespace Laventure\Component\Database\Builder\SQL\Commands\DML;

use Laventure\Component\Database\Builder\SQL\Commands\HasExecutableCommand;
use Laventure\Component\Database\Builder\SQL\Commands\SQLBuilderHasConditions;


/**
 * @inheritdoc
*/
class Update extends SQLBuilderHasConditions implements HasExecutableCommand
{


    /**
     * @var array
    */
    protected array $data = [];





    /**
     * @param array $attributes
     *
     * @return $this
    */
    public function update(array $attributes): static
    {
         $this->data = $this->resolveAttributes($attributes);
         $this->setParameters($attributes);

         return $this;
    }






    /**
     * @param array $attributes
     *
     * @return array
    */
    private function resolveAttributes(array $attributes): array
    {
        $resolved = [];

        foreach ($attributes as $column => $value) {
            if ($this->hasPdoConnection()) {
                $resolved[] = "$column = :$column";
            } else {
                $resolved[] = "$column = '$value'";
            }
        }

        return $resolved;
    }







    /**
     * @inheritDoc
    */
    public function getSQL(): string
    {
        $sql[] = sprintf("UPDATE %s %s", $this->getTable(), $this->set());
        $sql[] = $this->whereSQL();

        return join(' ', array_filter($sql)).';';
    }







    /**
     * @return string
    */
    private function set(): string
    {
        return sprintf('SET %s', join(', ', $this->data));
    }





    /**
     * @return false|int
    */
    public function execute(): false|int
    {
        return $this->statement()
                    ->setParameters($this->parameters)
                    ->execute();
    }
}