<?php
namespace Laventure\Component\Database\ORM\Persistence\Mapping;

use ReflectionClass;

/**
 * @ClassMetadataInterface
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\ORM\Persistence\Mapping
*/
interface ClassMetadataInterface
{


     /**
      * Returns mapped class name
      *
      * @return string
     */
     public function getClassname(): string;




     /**
      * Returns table name
      *
      * @return string
     */
     public function getTableName(): string;





    /**
     * Returns class identifier
     *
     * @return string
    */
    public function getIdentifier(): string;





    /**
     * Returns reflection class
     *
     * @return ReflectionClass
    */
    public function getReflection(): ReflectionClass;





    /**
     * Determine if the given field name is class identifier
     *
     * @param string $field
     *
     * @return bool
    */
    public function isIdentifier(string $field): bool;






    /**
     * Returns class field name
     *
     * @return array
    */
    public function getFieldNames(): array;





    /**
     * Determine if the given field name in class metadata
     *
     * @param string $field
     *
     * @return bool
    */
    public function hasField(string $field): bool;

}