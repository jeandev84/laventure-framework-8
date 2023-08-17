<?php
namespace Laventure\Component\Database\ORM\ActiveRecord;


/**
 * @inheritdoc
*/
class Model extends ActiveRecord
{

    /**
     * attributes to save
     *
     * @var array
    */
    protected array $saved = [];





    /**
     * attributes to keep
     *
     * @var array|string[]
    */
    protected array $guarded = ['id'];






    /**
     * @inheritDoc
    */
    protected function mapAttributesToSave(): array
    {
        $attributes = [];

        $columns = $this->getColumnsFromTable();

        foreach ($columns as $column) {
            if (! empty($this->saved)) {
                if (\in_array($column, $this->saved)) {
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