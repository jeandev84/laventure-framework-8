<?php
namespace Laventure\Component\Database\Schema\Blueprint\Drivers;

use Laventure\Component\Database\Schema\Blueprint\Blueprint;
use Laventure\Component\Database\Schema\Blueprint\Column\Column;


/**
 * @inheritdoc
*/
class MysqlBlueprint extends Blueprint
{

    /**
     * @inheritDoc
    */
    public function increments(string $name): Column
    {
        return $this->bigIncrements($name)->primary();
    }



    /**
     * @inheritDoc
    */
    public function integer(string $name, int $length = 11): Column
    {
        return $this->addColumn($name, "INT($length)");
    }






    /**
     * @inheritDoc
    */
    public function smallInteger(string $name): Column
    {
        return $this->addColumn($name, 'SMALLINT');
    }




    /**
     * @inheritDoc
    */
    public function bigInteger(string $name): Column
    {
        return $this->addColumn($name, 'BIGINT');
    }





    /**
     * @inheritDoc
    */
    public function bigIncrements(string $name): Column
    {
        return $this->addColumn($name, 'BIGINT AUTO_INCREMENT');
    }





    /**
     * @inheritDoc
    */
    public function datetime(string $name): Column
    {
        return $this->addColumn($name, 'DATETIME');
    }






    /**
     * @inheritDoc
    */
    public function binary(string $name): Column
    {
         /*
           bin BINARY(16), varbin VARBINARY(100)
         */

         return $this->addColumn($name, 'BINARY');
    }






    /**
     * @inheritDoc
    */
    public function date(string $name): Column
    {
        return $this->addColumn($name, 'DATE');
    }






    /**
     * @inheritDoc
    */
    public function decimal(string $name, int $precision, int $scale): Column
    {

    }





    /**
     * @inheritDoc
    */
    public function double(string $name, int $precision, int $scale): Column
    {

    }








    /**
     * @inheritDoc
    */
    public function enum(string $name, array $values): Column
    {

    }







    /**
     * @inheritDoc
    */
    public function float(string $name): Column
    {

    }






    /**
     * @inheritDoc
    */
    public function json(string $name): Column
    {

    }





    /**
     * @inheritDoc
    */
    public function longText(string $name): Column
    {

    }





    /**
     * @inheritDoc
    */
    public function mediumInteger(string $name): Column
    {

    }





    /**
     * @inheritDoc
    */
    public function mediumText(string $name): Column
    {

    }






    /**
     * @inheritDoc
    */
    public function morphs(string $name): Column
    {

    }




    /**
     * @inheritDoc
    */
    public function tinyInteger(string $name): Column
    {

    }






    /**
     * @inheritDoc
    */
    public function char(string $name, $value): Column
    {

    }






    /**
     * @inheritDoc
    */
    public function time(string $name): Column
    {

    }





    /**
     * @inheritDoc
    */
    public function default($value)
    {

    }




    /**
     * @inheritDoc
    */
    public function timestamp(string $name): Column
    {
        // TODO: Implement timestamp() method.
    }






    /**
     * @inheritDoc
    */
    public function unsigned(): void
    {

    }





    /**
     * @inheritDoc
    */
    public function getTables(): array
    {
        return $this->statement("SHOW FULL TABLES FROM {$this->connection->getDatabase()};")
                    ->fetch()
                    ->columns();
    }





    /**
     * @inheritDoc
    */
    public function createTable(): bool
    {

    }




    /**
     * @inheritDoc
    */
    public function updateTable(): mixed
    {
        // TODO: Implement updateTable() method.
    }




    /**
     * @inheritDoc
    */
    public function describeTable(): mixed
    {

    }




    /**
     * @inheritDoc
    */
    public function getColumns(): array
    {
        $statement = $this->statement("SHOW FULL COLUMNS FROM {$this->getTable()}");

        $columns = $statement->fetch()->assoc();

        return array_filter($columns, function ($column) {
            return $column['Field'] ?? '';
        });
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
        return parent::addColumn("`$name`", $type, $constraints);
    }
}