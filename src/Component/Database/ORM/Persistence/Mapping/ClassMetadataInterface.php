<?php
namespace Laventure\Component\Database\ORM\Persistence\Mapping;

use Laventure\Component\Database\ORM\Persistence\PersistenceCollection;
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







    /**
     * Determine if the given field has association fields
     *
     * @param string $field
     *
     * @return bool
    */
    public function hasAssociation(string $field): bool;








    /**
     * Determine if field has value object or other value
     *
     * @param string $field
     *
     * @return bool
    */
    public function isSingleValueAssociation(string $field): bool;







    /**
     * Determine if field is collection
     *
     * @param string $field
     *
     * @return bool
    */
    public function isCollectionValueAssociation(string $field): bool;







    /**
     * Returns mapped object
     *
     * @return object
    */
    public function getObject(): object;







    /**
     * Get columns value
     *
     * @return array
    */
    public function getIdentifierValues(): array;







    /**
     * @return array
    */
    public function getMethods(): array;






    /**
     * @param string $name
     *
     * @return bool
    */
    public function hasMethod(string $name): bool;

}