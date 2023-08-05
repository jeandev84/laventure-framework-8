<?php
namespace Laventure\Component\Database\Connection\Extensions\PDO\Drivers;

use Laventure\Component\Database\Connection\Configuration\ConfigurationInterface;
use Laventure\Component\Database\Connection\Extensions\PDO\DriverConnection;

/**
 * @SqliteConnection
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\Connection\Extensions\PDO\Column
*/
class SqliteConnection extends DriverConnection
{

    /**
     * @inheritDoc
    */
    public function getName(): string
    {
         return 'sqlite';
    }




    /**
     * @inheritDoc
    */
    public function createDatabase(): bool
    {
         return true;
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
            'database' => $config->database()
        ]);

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