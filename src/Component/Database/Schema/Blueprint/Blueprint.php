<?php
namespace Laventure\Component\Database\Schema\Blueprint;


use Laventure\Component\Database\Connection\Configuration\ConfigurationInterface;
use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Connection\Query\QueryInterface;
use Laventure\Component\Database\Schema\Blueprint\Column\Column;
use Laventure\Component\Database\Schema\Blueprint\Constraints\Contract\ConstraintInterface;
use Laventure\Component\Database\Schema\Blueprint\Constraints\ForeignKey;
use Laventure\Component\Database\Schema\Blueprint\Constraints\Index;
use Laventure\Component\Database\Schema\Blueprint\Constraints\PrimaryKey;
use Laventure\Component\Database\Schema\Blueprint\Constraints\Unique;


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
    public array $dropColumns = [];






    /**
     * @var Column[]
    */
    public array $renameColumns = [];






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
             $column = new Column("ADD COLUMN $name", $type, $constraints);
        }

        return $this->newColumns[$name] = $column;
    }







    /**
     * @param string|array $columns
     *
     * @return $this
    */
    public function dropColumn(string|array $columns): static
    {
        $this->dropColumns[] = "DROP COLUMN ". join(", ", (array)$columns);

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
        $this->renameColumns[$name] = "RENAME COLUMN $name TO $to";

        return $this;
    }






    /**
     * @param ConstraintInterface $constraint
     *
     * @return $this
    */
    public function addConstraint(ConstraintInterface $constraint): static
    {
        $this->constraints[] = $constraint;

        return $this;
    }









    /**
     * Add primary keys
     *
     * @param string|array $columns
     *
     * @return $this
     */
    public function primary(string|array $columns): static
    {
        return $this->addConstraint(new PrimaryKey($columns));
    }






    /**
     * Add unique columns
     *
     * @param string|array $columns
     *
     * @return $this
     */
    public function unique(string|array $columns): static
    {
        return $this->addConstraint(new Unique($columns));
    }






    /**
     * @param string $name
     *
     * @return ForeignKey
     */
    public function foreign(string $name): ForeignKey
    {
        return $this->constraints[] = new ForeignKey($name, $this->foreignKeyName($name));
    }






    /**
     * @return ForeignKey
     */
    public function foreignId(): ForeignKey
    {
        return $this->foreign('id');
    }






    /**
     * Add indexes columns
     *
     * @param string|array $columns
     *
     * @return $this
    */
    public function index(string|array $columns): static
    {
        return $this->addConstraint(new Index($columns));
    }









    /**
     * @return string
    */
    public function printCreateColumns(): string
    {
        return join([
            join(', ', array_values($this->newColumns)),
            join(', ', array_values($this->constraints)),
            join(', ', array_values($this->indexes))
        ]);
    }






    /**
     * @return string
    */
    public function printUpdateColumns(): string
    {
        if (! $this->hasTable()) {
            return '';
        }

        return join(', ', [
            array_values($this->newColumns),
            array_values($this->dropColumns),
            array_values($this->renameColumns)
        ]);
    }




    /**
     * @param string $sql
     *
     * @return QueryInterface
    */
    public function statement(string $sql): QueryInterface
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
     * @return void
    */
    public function createIndex(string $name)
    {

    }





    /**
     * @inheritdoc
    */
    public function getColumns(): array
    {
         return [];
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
     * @return bool
    */
    public function updateTable(): bool
    {
        if (! $columns = $this->printUpdateColumns()) {
            return false;
        }

        return $this->exec(sprintf('ALTER TABLE %s %s;', $this->getTable(), $columns));
    }








    /**
     * @inheritDoc
    */
    public function dropTable(): bool
    {
         $this->exec(sprintf('DROP TABLE %s;', $this->getTable()));

         return ! $this->hasTable();
    }






    /**
     * @inheritDoc
    */
    public function dropTableIfExists(): bool
    {
        $this->exec(sprintf('DROP TABLE IF EXISTS %s;', $this->getTable()));

        return ! $this->hasTable();
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
         foreach ($this->created as $name => $column) {
             if (! $column->isPrimary()) {
                 $this->created[$name] = $column->nullable();
             }
         }
    }






    /**
     * @param string $name
     *
     * @return string
    */
    protected function foreignKeyName(string $name): string
    {
        return sprintf('fk_%s_%s', $this->getTable(), $name);
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