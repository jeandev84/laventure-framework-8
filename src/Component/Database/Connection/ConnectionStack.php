<?php
namespace Laventure\Component\Database\Connection;

use Laventure\Component\Database\Connection\Extensions\PDO\Drivers\MysqlConnection;
use Laventure\Component\Database\Connection\Extensions\PDO\Drivers\OracleConnection;
use Laventure\Component\Database\Connection\Extensions\PDO\Drivers\PgsqlConnection;
use Laventure\Component\Database\Connection\Extensions\PDO\Drivers\SqliteConnection;


/**
 * @ConnectionInterface
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\Connection
*/
class ConnectionStack
{

     /**
      * Returns defaults connections
      *
      * @return ConnectionInterface[]
     */
     public static function defaults(): array
     {
          return [
              new MysqlConnection(),
              new PgsqlConnection(),
              new SqliteConnection(),
              new OracleConnection()
          ];
     }
}