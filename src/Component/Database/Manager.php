<?php
namespace Laventure\Component\Database;

use Laventure\Component\Database\Connection\Configuration\Configuration;
use Laventure\Component\Database\Manager\DatabaseManager;

/**
 * @inheritdoc
*/
class Manager extends DatabaseManager
{

       /**
        * @var static
       */
       protected static $instance;




       /**
        * @var array
       */
       protected static $credentials;





       /**
        * @param array $credentials
        *
        * @return void
       */
       public function addConnections(array $credentials): void
       {
            $config = new Configuration($credentials);

            if (! $config->has('connection')) {
                trigger_error("undefined param [connection]");
            }

            if (! $config->has('connections')) {
                 trigger_error("undefined param [connections]");
            }

            $this->open($config['connection'], $config['connections']);
            self::$credentials = $credentials;
       }






       /**
        * @return static
       */
       public static function capsule(): static
       {
            if (! self::$credentials) {
                 trigger_error("no connections added.");
            }

            if (! self::$instance) {
                $instance = new static();
                $instance->open(self::$credentials['connection'], self::$credentials['connections']);
                self::$instance = $instance;
            }

            return self::$instance;
       }

}