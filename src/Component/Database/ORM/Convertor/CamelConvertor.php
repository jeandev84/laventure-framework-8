<?php
namespace Laventure\Component\Database\ORM\Convertor;

trait CamelConvertor
{

    /**
     * Example:
     * Transform authorId to author_id
     *
     * @param string $source
     * @return string
    */
    public function camelCaseToUnderscore(string $source): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $source));
    }






    /**
     * @param string $source
     * @return string
    */
    public function underscoreToCamelCase(string $source): string
    {
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }
}