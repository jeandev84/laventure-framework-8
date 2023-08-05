<?php
namespace Laventure\Component\Database\Schema\Blueprint;


use Laventure\Component\Database\Connection\Configuration\ConfigurationInterface;
use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Connection\Query\QueryInterface;
use Laventure\Component\Database\Schema\Blueprint\Column\AddColumn;
use Laventure\Component\Database\Schema\Blueprint\Column\Column;
use Laventure\Component\Database\Schema\Blueprint\Column\DropColumn;
use Laventure\Component\Database\Schema\Blueprint\Column\ModifyColumn;
use Laventure\Component\Database\Schema\Blueprint\Column\RenameColumn;


/**
 * @inheritdoc
*/
abstract class Blueprint implements BlueprintInterface
{


    /**
     * @var ConnectionInterface
    */
    protected ConnectionInterface $connection;




    /**
     * @var string
    */
    protected string $table;




    /**
     * @var Column[]
    */
    protected array $newColumns = [];






    /**
     * @var Column[]
    */
    protected array $updatedColumns = [];





    /**
     * @var array
    */
    protected array $constraints = [];





    /**
     * @var array
    */
    protected array $indexes = [];






    /**
     * @param ConnectionInterface $connection
     *
     * @param string $table
    */
    public function __construct(ConnectionInterface $connection, string $table)
    {
        $this->connection = $connection;
        $this->table      = $table;
    }







    /**
     * @param string $sql
     *
     * @return QueryInterface
    */
    protected function statement(string $sql): QueryInterface
    {
         return $this->connection->statement($sql);
    }





    /**
     * @param string $sql
     *
     * @return bool|int
    */
    public function exec(string $sql): bool|int
    {
        return $this->connection->exec($sql);
    }







    /**
     * @return ConfigurationInterface
    */
    protected function config(): ConfigurationInterface
    {
         return $this->connection->config();
    }







    /**
     * @inheritDoc
    */
    public function getTable(): string
    {
        return sprintf('%s%s', $this->config()->prefix(), $this->table);
    }





    /**
     * @return array
    */
    public function getTables(): array
    {
        return $this->connection->getTables();
    }






    /**
     * @return bool
    */
    public function hasTable(): bool
    {
        return in_array($this->getTable(), $this->getTables());
    }








    /**
     * @param string $name
     *
     * @param string $type
     *
     * @param string $constraints
     *
     * @return Column
     */
    public function addColumn(string $name, string $type, string $constraints = ''): Column
    {
        $column = new Column($name, $type, $constraints);

        if ($this->hasTable()) {
            $column = new AddColumn($name, $type, $constraints);
        }

        if ($this->hasColumn($name)) {
            return $this->updatedColumns[$name] = new ModifyColumn($name, $type, $constraints);
        }

        return $this->newColumns[$name] = $column;
    }







    /**
     * @param string $name
     *
     * @return $this
    */
    public function dropColumn(string $name): static
    {
        $this->updatedColumns[$name] = new DropColumn($name);

        return $this;
    }






    /**
     * @param string $name
     *
     * @param string $to
     *
     * @return $this
    */
    public function renameColumn(string $name, string $to): static
    {
        $this->updatedColumns[$name] = new RenameColumn($name, $to);

        return $this;
    }





    /**
     * @inheritdoc
    */
    public function getColumns(): array
    {
         return [];
    }





    /**
     * @return Column[]
    */
    public function getNewColumns(): array
    {
         return $this->newColumns;
    }







    /**
     * @inheritdoc
    */
    public function hasColumn(string $name): bool
    {
        if (! $this->hasTable()) {
             return false;
        }

        return in_array($name, $this->getColumns());
    }







    /**
     * @return string
    */
    public function printCreatedColumns(): string
    {
        return join(',', [
            join(', ', array_values($this->newColumns)),
            join(', ', array_values($this->constraints)),
            join(', ', array_values($this->indexes))
        ]);
    }






    /**
     * @return string
    */
    public function printUpdatedColumns(): string
    {
         if (! $this->hasTable()) {
             return '';
         }

         return join(', ', array_values($this->updatedColumns));
    }








    /**
     * @inheritDoc
    */
    public function dropTable(): bool|int
    {
        return $this->exec(sprintf('DROP TABLE %s;', $this->getTable()));
    }






    /**
     * @inheritDoc
    */
    public function dropTableIfExists(): bool|int
    {
        return $this->exec(sprintf('DROP TABLE IF EXISTS %s;', $this->getTable()));
    }





    /**
     * @inheritDoc
    */
    public function truncateTable(): bool|int
    {
        return $this->exec(sprintf('TRUNCATE TABLE %s;', $this->getTable()));
    }





    /**
     * @inheritDoc
    */
    public function truncateTableCascade(): bool|int
    {
        return $this->exec(sprintf('TRUNCATE TABLE CASCADE %s;', $this->getTable()));
    }







    /**
     * @param string $name
     *
     * @param int $length
     *
     * @return Column
     */
    public function string(string $name, int $length = 255): Column
    {
        return $this->addColumn($name, "VARCHAR($length)");
    }






    /**
     * Adds remember_token as VARCHAR(100) NULL
     *
     * @return Column
    */
    public function rememberToken(): Column
    {
        return $this->string('remember_token', 100)->nullable();
    }






    /**
     * Add column type boolean
     *
     * @param string $name
     *
     * @return Column
    */
    public function boolean(string $name): Column
    {
        return $this->addColumn($name, 'BOOLEAN');
    }








    /**
     * Add column text
     *
     * @param string $name
     *
     * @return Column
    */
    public function text(string $name): Column
    {
        return $this->addColumn($name, 'TEXT');
    }






    /**
     * Add column named id
     *
     * @return Column
    */
    public function id(): Column
    {
        return $this->increments('id');
    }







    /**
     * @return void
    */
    public function timestamps(): void
    {
        $this->datetime('created_at');
        $this->datetime('updated_at');
    }







    /**
     * Add Nullable timestamps
    */
    public function nullableTimestamps(): void
    {
        $this->datetime('created_at')->nullable();
        $this->datetime('updated_at')->nullable();
    }








    /**
     * @return Column
    */
    public function softDeletes(): Column
    {
        return $this->boolean('deleted_at');
    }







    /**
     * Designate that the column allows NULL values
     *
     * @return void
    */
    public function nullable(): void
    {
         foreach ($this->newColumns as $name => $column) {
             $this->newColumns[$name] = $column->nullable();
         }
    }




    /**
     * Add increment column
     *
     * @param string $name
     *
     * @return Column
     */
    abstract public function increments(string $name): Column;





    /**
     * @param string $name
     *
     * @param int $length
     *
     * @return Column
     */
    abstract public function integer(string $name, int $length = 11): Column;






    /**
     * Add small integer
     *
     * @param string $name
     *
     * @return Column
     */
    abstract public function smallInteger(string $name): Column;





    /**
     * @param string $name
     *
     * @return Column
    */
    abstract public function bigInteger(string $name): Column;







    /**
     * @param string $name
     *
     * @return Column
    */
    abstract public function bigIncrements(string $name): Column;






    /**
     * Add datetime column
     *
     * @param string $name
     *
     * @return Column
    */
    abstract public function datetime(string $name): Column;







    /**
     * Add binary column
     *
     * @param string $name
     * @return Column
    */
    abstract public function binary(string $name): Column;









    /**
     * Add date column
     *
     * @param string $name
     *
     * @return Column
    */
    abstract public function date(string $name): Column;









    /**
     * Add decimal column
     *
     * @param string $name
     *
     * @param int $precision
     *
     * @param int $scale
     *
     * @return Column
    */
    abstract public function decimal(string $name, int $precision, int $scale): Column;








    /**
     * Add double column
     *
     * @param string $name
     *
     * @param int $precision
     *
     * @param int $scale
     *
     * @return Column
     */
    abstract public function double(string $name, int $precision, int $scale): Column;









    /**
     * Add eum column
     *
     * @param string $name
     *
     * @param array $values
     *
     * @return Column
     */
    abstract public function enum(string $name, array $values): Column;









    /**
     * Add float column
     *
     * @param string $name
     *
     * @return Column
     */
    abstract public function float(string $name): Column;









    /**
     * Add json column
     *
     * @param string $name
     *
     * @return Column
     */
    abstract public function json(string $name): Column;






    /**
     * Add long text
     *
     * @param string $name
     * @return Column
     */
    abstract public function longText(string $name): Column;






    /**
     * Add medium integer
     *
     * @param string $name
     * @return Column
     */
    abstract public function mediumInteger(string $name): Column;








    /**
     * Add medium text
     *
     * @param string $name
     *
     * @return Column
     */
    abstract public function mediumText(string $name): Column;









    /**
     * Add morphs column
     *
     * @param string $name
     *
     * @return Column
     */
    abstract public function morphs(string $name): Column;








    /**
     * Add tiny column
     *
     * @param string $name
     *
     * @return Column
     */
    abstract public function tinyInteger(string $name): Column;






    /**
     * @param string $name
     *
     * @param $value
     *
     * @return Column
    */
    abstract public function char(string $name, $value): Column;







    /**
     * Add time column
     *
     * @param string $name
     *
     * @return Column
     */
    abstract public function time(string $name): Column;






    /**
     * Set column default value
     *
     * @param $value
    */
    abstract public function default($value);











    /**
     * Add TIMESTAMP column
     *
     * @param string $name
     *
     * @return Column
     */
    abstract public function timestamp(string $name): Column;







    /**
     * Set INTEGER to UNSIGNED
     *
     * @return void
     */
    abstract public function unsigned(): void;
}