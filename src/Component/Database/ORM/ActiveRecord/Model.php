<?php
namespace Laventure\Component\Database\ORM\ActiveRecord;


/**
 * @inheritdoc
*/
class Model extends ActiveRecord
{

    /**
     * Store attributes we can save
     *
     * @var array
    */
    protected array $map = [];





    /**
     * @var array|string[]
    */
    protected array $guarded = ['id'];





    /**
     * @inheritDoc
    */
    protected function mapAttributes(): array
    {
        $attributes = [];

        $columns = $this->getColumnsFromTable();

        foreach ($columns as $column) {
            if (! empty($this->fillable)) {
                if (\in_array($column, $this->fillable)) {
                    $attributes[$column] = $this->{$column};
                }
            } else {
                $attributes[$column] = $this->{$column};
            }
        }

        if (! empty($this->guarded)) {
            foreach ($this->guarded as $guarded) {
                if (isset($attributes[$guarded])) {
                    unset($attributes[$guarded]);
                }
            }
        }

        return $attributes;
    }
}