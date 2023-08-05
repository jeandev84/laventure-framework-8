<?php
namespace Laventure\Component\Database\Connection\Query;

class NullQueryResult implements QueryResultInterface
{

    /**
     * @inheritDoc
    */
    public function map(string $classname): static
    {
         return $this;
    }




    /**
     * @inheritDoc
    */
    public function all(): array
    {
        return [];
    }





    /**
     * @inheritDoc
    */
    public function one(): mixed
    {
        return null;
    }






    /**
     * @inheritDoc
     */
    public function assoc(): array
    {
        return [];
    }





    /**
     * @inheritDoc
    */
    public function column(int $column = 0): mixed
    {
        return null;
    }





    /**
     * @inheritDoc
    */
    public function columns(): array
    {
         return [];
    }






    /**
     * @inheritDoc
    */
    public function numRows(): int
    {
        return 0;
    }






    /**
     * @inheritDoc
    */
    public function getMapped(): array
    {
         return [];
    }
}