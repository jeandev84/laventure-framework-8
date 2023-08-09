<?php
namespace Laventure\Component\Database\Builder\SQL\Commands\DML;

use Laventure\Component\Database\Builder\SQL\Commands\SQlBuilder;


/**
 * @inheritdoc
*/
class Insert extends SQlBuilder
{


    /**
     * @var int
    */
    protected int $index = 0;




    /**
     * @var array
    */
    protected array $columns = [];



    /**
     * @var array
    */
    protected array $values = [];





    /**
     * @param array $attributes
     *
     * @return $this
    */
    public function insert(array $attributes): static
    {
         if (! empty($attributes[0])) {
             foreach ($attributes as $attribute) {
                  $this->add($attribute);
             }
         } else {
             $this->add($attributes);
         }

         return $this;
    }


    /**
     * @return array
    */
    public function getColumns(): array
    {
         return $this->columns;
    }


    /**
     * @return array
    */
    public function getValues(): array
    {
        return $this->values;
    }




    /**
     * @inheritDoc
    */
    public function getSQL(): string
    {
        $columns = join(', ', $this->getColumns());
        $values  = join(', ', $this->getValues());

        return sprintf("INSERT INTO {$this->getTable()} (%s) VALUES %s;", $columns, $values);
    }




    /**
     * @return false|int
    */
    public function execute(): false|int
    {
        return $this->statement()->execute();
    }






    /**
     * @param array $attributes
     *
     * @return void
    */
    public function add(array $attributes): void
    {
        $attributes      = $this->resolveBindingParameters($attributes);
        $this->columns   = array_keys($attributes);
        $this->values[]  = '('. join(', ', array_values($attributes)) . ')';

        $this->index++;
    }





    /**
     * @inheritdoc
    */
    protected function resolveBindingParameters(array $attributes): array
    {
        $resolved = [];

        foreach ($attributes as $column => $value) {
            if ($this->hasPdoConnection()) {
                $resolved[$column] = ":{$column}_{$this->index}";
                $this->setParameter("{$column}_{$this->index}", $value);
            } else {
                $resolved[$column] = "'$value'";
            }
        }

        return $resolved;
    }

}