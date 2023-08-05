<?php
namespace Laventure\Component\Database\Connection\Extensions\PDO\Drivers;


use Laventure\Component\Database\Connection\Configuration\ConfigurationInterface;
use Laventure\Component\Database\Connection\Extensions\PDO\DriverConnection;

/**
 * @PgsqlConnection
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\Connection\Extensions\PDO\Column
*/
class PgsqlConnection extends DriverConnection
{

    /**
     * @inheritDoc
    */
    public function getName(): string
    {
        return 'pgsql';
    }




    /**
     * @inheritDoc
    */
    public function createDatabase(): bool
    {

    }




    /**
     * @inheritDoc
    */
    public function dropDatabase(): bool
    {

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