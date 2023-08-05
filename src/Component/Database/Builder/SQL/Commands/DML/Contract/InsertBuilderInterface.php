<?php
namespace Laventure\Component\Database\Builder\SQL\Commands\DML\Contract;

use Laventure\Component\Database\Builder\SQL\Commands\ExecutableSQlCommand;

/**
 * @InsertBuilderInterface
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\Builder\SQL\Commands\DML\Contract
*/
interface InsertBuilderInterface extends ExecutableSQlCommand
{


     /**
      * Insertion attributes
      *
      * @param array $attributes
      *
      * @return $this
     */
     public function insert(array $attributes): static;





     /**
      * Returns insertion columns
      *
      * @return array
     */
     public function getColumns(): array;


     


     /**
      * Returns insertion values
      *
      * @return array
     */
     public function getValues(): array;
}