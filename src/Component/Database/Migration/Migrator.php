<?php
namespace Laventure\Component\Database\Migration;


use Laventure\Component\Database\Builder\Builder;
use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Migration\Contract\MigratorInterface;
use Laventure\Component\Database\Schema\Blueprint\Blueprint;
use Laventure\Component\Database\Schema\Schema;

/**
 * @Migrator
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\Migration
*/
class Migrator implements MigratorInterface
{

    /**
     * @var string
    */
    protected string $table;



    /**
     * @var Migration[]
    */
    protected array $migrations = [];



    /**
     * @var ConnectionInterface
    */
    protected ConnectionInterface $connection;




    /**
     * @var Schema
    */
    protected Schema $schema;




    /**
     * @var Builder
    */
    protected Builder $builder;




    /**
     * @var string[]
    */
    protected array $log = [];






    /**
     * @param ConnectionInterface $connection
     *
     * @param string $table
    */
    public function __construct(ConnectionInterface $connection, string $table = 'migrations')
    {
         $this->connection   = $connection;
         $this->table        = $table;
         $this->schema       = new Schema($connection);
         $this->builder      = new Builder($connection, $table);
    }






    /**
     * Set migration version table
     *
     * @param string $table
     *
     * @return $this
    */
    public function table(string $table): static
    {
        $this->table = $table;

        return $this;
    }





    /**
     * @param Migration $migration
     *
     * @return $this
    */
    public function addMigration(Migration $migration): static
    {
         $this->migrations[$migration->getName()] = $migration;

         return $this;
    }






    /**
     * @param Migration[] $migrations
     *
     * @return $this
    */
    public function addMigrations(array $migrations): static
    {
        foreach ($migrations as $migration) {
             $this->addMigration($migration);
        }

        return $this;
    }





    /**
     * @inheritDoc
    */
    public function install(): bool
    {
        return $this->schema->create($this->getTable(), function (Blueprint $table) {
            $table->id();
            $table->string('version');
            $table->datetime('executed_at');
        });
    }






    /**
     * @inheritDoc
    */
    public function migrate(): bool
    {
         $this->install();

         if ($migrations = $this->getMigrationsToApply()) {

             foreach ($migrations as $migration) {
                 $version = $migration->getName();
                 $this->log("started migration $version ...");
                 $migration->up();
                 $this->builder->insert([
                     'version'     => $version,
                     'executed_at' => date('Y-m-d H:i:s')
                 ]);
                 $this->log("applied migration $version.");
             }
         }

         return true;
    }







    /**
     * @inheritDoc
    */
    public function rollback(): bool
    {
         foreach ($this->getMigrations() as $migration) {
             $migration->down();
         }

         return $this->schema->truncate($this->getTable());
    }






    /**
     * @inheritDoc
    */
    public function reset(): bool
    {
         $this->rollback();

         return $this->schema->drop($this->getTable());
    }






    /**
     * @inheritDoc
    */
    public function refresh(): bool
    {
         $this->reset();

         return $this->migrate();
    }







    /**
     * @inheritDoc
     *
     * @return Migration[]
    */
    public function getMigrations(): array
    {
        return $this->migrations;
    }






    /**
     * @inheritDoc
     *
     * @return Migration[]
    */
    public function getMigrationsToApply(): array
    {
         return array_filter($this->getMigrations(), function (Migration $migration) {
              return ! in_array($migration->getName(), $this->getAppliedMigrations());
         });
    }






    /**
     * @inheritDoc
    */
    public function getAppliedMigrations(): array
    {
         return $this->builder
                     ->select('version')
                     ->from($this->getTable())
                     ->fetch()
                     ->columns();
    }






    /**
     * @inheritDoc
    */
    public function getTable(): string
    {
        return $this->table;
    }






    /**
     * Log process migration
     *
     * @param string $message
     *
     * @return void
    */
    public function log(string $message): void
    {
        $this->log[] = "[". date('Y-m-d H:i:s') . "] $message";
    }







    /**
     * Log migrator process
     *
     * @return string
    */
    public function logAppliedMigrations(): string
    {
         return join(PHP_EOL, $this->log);
    }
}