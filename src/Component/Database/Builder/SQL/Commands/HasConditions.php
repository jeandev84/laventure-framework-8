<?php
namespace Laventure\Component\Database\Builder\SQL\Commands;



use Laventure\Component\Database\Builder\SQL\Commands\Expr\Expr;

/**
 * @HasConditions
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\Builder\SQL\Commands
*/
trait HasConditions
{

     /**
      * @var array
     */
     protected array $wheres = [];





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







     /**
      * Add where
      *
      * @param array $conditions
      *
      * @return $this
     */
     public function addConditions(array $conditions): static
     {
          foreach ($conditions as $condition) {
              $this->where($condition);
          }

          return $this;
     }
}