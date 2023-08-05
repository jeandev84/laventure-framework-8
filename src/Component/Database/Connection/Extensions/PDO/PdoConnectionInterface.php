<?php
namespace Laventure\Component\Database\Connection\Extensions\PDO;

use PDO;

/**
 * @PdoConnectionInterface
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\Connection\Extensions\PDO
*/
interface PdoConnectionInterface
{

     /**
      * @return PDO
     */
     public function getPdo(): PDO;
}