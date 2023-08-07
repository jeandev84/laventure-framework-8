<?php
namespace Laventure\Component\Database\ORM\Persistence;


trait EntityPropertyResolver
{



    /**
     * Example:
     * Transform authorId to author_id
     *
     * @param string $source
     * @return string
    */
    protected function camelCaseToUnderscore(string $source): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $source));
    }






    /**
     * @param string $source
     * @return string
    */
    protected function underscoreToCamelCase(string $source): string
    {
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }
}