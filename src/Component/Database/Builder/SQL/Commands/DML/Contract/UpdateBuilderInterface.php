<?php
namespace Laventure\Component\Database\Builder\SQL\Commands\DML\Contract;

use Laventure\Component\Database\Builder\SQL\Commands\ExecutableSQlCommand;

/**
 * @UpdateBuilderInterface
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\Builder\SQL\Commands\DQL\Contract
*/
interface UpdateBuilderInterface extends ExecutableSQlCommand
{


     /**
      * @param array $attributes
      *
      * @return $this
     */
     public function update(array $attributes): static;
}