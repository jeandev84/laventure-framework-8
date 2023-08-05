<?php
namespace Laventure\Component\Database\Builder\SQL\Commands;

interface ExecutableSQlCommand
{

      /**
       * Execute query
       * 
       * @return mixed
      */
      public function execute(): mixed;
}