<?php
namespace Laventure\Component\Database\Builder\SQL\Commands;

interface ExecutableSQlCommand
{
       /**
        * @return mixed
       */
       public function execute(): mixed;
}