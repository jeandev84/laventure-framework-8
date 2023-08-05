<?php
namespace Laventure\Component\Database\Builder\SQL\Commands;


/**
 * @IsSettable
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\Builder\SQL\Commands
*/
trait IsSettable
{

     /**
      * @var array
     */
     protected array $data = [];




     /**
      * @param string $column
      *
      * @param $value
      *
      * @return $this
     */
     public function set(string $column, $value): static
     {
          $this->data[] = "$column = $value";

          return $this;
     }



     

     /**
      * @param array $data
      *
      * @return $this
     */
     private function data(array $data): static
     {
         $this->data = $data;

         return $this;
     }




     /**
      * @return string
     */
     private function setSQL(): string
     {
         return sprintf('SET %s', join(', ', $this->data));
     }
}