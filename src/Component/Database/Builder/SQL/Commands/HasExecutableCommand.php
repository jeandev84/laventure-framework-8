<?php
namespace Laventure\Component\Database\Builder\SQL\Commands;

interface HasExecutableCommand
{
       /**
        * @return mixed
       */
       public function execute(): mixed;
}