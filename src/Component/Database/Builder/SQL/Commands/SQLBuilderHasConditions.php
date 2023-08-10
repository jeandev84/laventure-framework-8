<?php
namespace Laventure\Component\Database\Builder\SQL\Commands;


use Laventure\Component\Database\Builder\SQL\Commands\Expr\Expr;

/**
 * @inheritdoc
*/
abstract class SQLBuilderHasConditions extends SQlBuilder implements HasCriteriaInterface
{


     /**
      * @var array
     */
     protected array $wheres = [];




     /**
      * @var array
     */
     protected array $parameters = [];





     /**
      * @inheritDoc
     */
     public function criteria(array $wheres): static
     {
         foreach ($wheres as $column => $value) {
             if ($this->hasPdoConnection()) {
                 if (is_array($value)) {
                      $this->where($this->expr()->in($column, "(:$column)"));
                 } else {
                     $this->where("$column = :$column");
                 }
             } else {
                 $this->where("$column = '$value'");
             }
         }

         return $this->setParameters($wheres);
     }







    /**
     * @param string $condition
     *
     * @return $this
    */
    public function where(string $condition): static
    {
        return $this->andWhere($condition);
    }







    /**
     * @param string $condition
     *
     * @return $this
    */
    public function andWhere(string $condition): static
    {
        $this->wheres['AND'][] = $condition;

        return $this;
    }





    /**
     * @param string $condition
     *
     * @return $this
    */
    public function orWhere(string $condition): static
    {
        $this->wheres['OR'][] = $condition;

        return $this;
    }








    /**
     * @return Expr
    */
    public function expr(): Expr
    {
        return new Expr();
    }








    /**
     * Add where
     *
     * @param array $wheres
     *
     * @return $this
    */
    public function wheres(array $wheres): static
    {
         foreach ($wheres as $where) {
             $this->where($where);
         }

         return $this;
    }






    /**
     * @param string $name
     *
     * @param $value
     *
     * @return $this
     */
    public function setParameter(string $name, $value): static
    {
        $this->parameters[$name] = $value;

        return $this;
    }





    /**
     * @param array $parameters
     *
     * @return static
    */
    public function setParameters(array $parameters): static
    {
        $this->parameters = array_merge($this->parameters, $parameters);

        return $this;
    }





    /**
     * Returns parameters
     *
     * @return array
    */
    public function getParameters(): array
    {
        return $this->parameters;
    }






    /**
     * @return string
    */
    protected function whereSQL(): string
    {
        if (! $this->wheres) {
            return '';
        }

        $wheres = [];

        $key = key($this->wheres);

        foreach ($this->wheres as $operator => $conditions) {

            if ($key !== $operator) {
                $wheres[] = $operator;;
            }

            $wheres[] = implode(" $operator ", $conditions);
        }

        return sprintf('WHERE %s', join(' ', $wheres));
    }
}