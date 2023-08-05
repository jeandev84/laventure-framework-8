<?php
namespace Laventure\Component\Database\Schema\Blueprint;

use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Schema\Blueprint\Drivers\MysqlBlueprint;


/**
 * @BlueprintFactory
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\Schema\Blueprint
*/
class BlueprintFactory
{
    public static function make(ConnectionInterface $connection, string $table): Blueprint
    {
        return new MysqlBlueprint($connection, $table);
    }
}