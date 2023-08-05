<?php
namespace Laventure\Component\Database\Connection\Extensions\PDO\Drivers;

use Laventure\Component\Database\Connection\Configuration\ConfigurationInterface;
use Laventure\Component\Database\Connection\Extensions\PDO\DriverConnection;

/**
 * @OracleConnection
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\Connection\Extensions\PDO\Column
*/
class OracleConnection extends DriverConnection
{

    /**
     * @inheritDoc
    */
    public function getName(): string
    {
         return 'oci';
    }




    /**
     * @inheritDoc
    */
    public function createDatabase(): bool
    {
        // TODO: Implement createDatabase() method.
    }




    /**
     * @inheritDoc
    */
    public function dropDatabase(): bool
    {
        // TODO: Implement dropDatabase() method.
    }


    /**
     * @inheritDoc
    */
    protected function resolveConfiguration(ConfigurationInterface $config): ConfigurationInterface
    {
        $config['dsn'] = $this->buildPdoDsn($this->getName(), [
            'host'       => $config->host(),
            'port'       => $config->port(),
            'charset'    => $config->charset()
        ]);

        $config['options'] = [];

        return $config;
    }



    /**
     * @inheritDoc
    */
    public function getDatabases(): array
    {
        return [];
    }




    /**
     * @inheritDoc
    */
    public function getTables(): array
    {
        return [];
    }
}