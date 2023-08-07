<?php
namespace Laventure\Component\Database\ORM\Persistence;

use DateTimeInterface;
use Laventure\Component\Database\ORM\Collection\Collection;
use Laventure\Component\Database\ORM\Persistence\Mapper\DataMapperInterface;


/**
 * @inheritdoc
*/
class DataMapper implements DataMapperInterface
{

    use EntityPropertyResolver;

    /**
     * @var EntityManager
    */
    protected EntityManager $em;




    /**
     * @var PersistenceCollection
    */
    protected PersistenceCollection $collection;




    /**
     * @var string
    */
    protected string $primary = 'id';



    /**
     * @var array
    */
    protected array $identifiers = [];





    /**
     * @var array
    */
    protected array $properties = [];




    /**
     * @var array
    */
    protected array $attributes = [];




    /**
     * @var object[]
    */
    protected array $belongs  = [];






    /**
     * @param EntityManager $em
    */
    public function __construct(EntityManager $em)
    {
         $this->em = $em;
         $this->collection = new PersistenceCollection();
    }







    /**
     * @inheritDoc
    */
    public function find($id): ?object
    {

    }





    /**
     * @inheritDoc
    */
    public function save(object $object): int
    {

    }




    /**
     * @inheritDoc
    */
    public function delete(object $object): int
    {

    }






    /**
     * @inheritDoc
    */
    public function mapRows(object $object): static
    {
        $reflection = new \ReflectionObject($object);
        $metadata   = $this->em->getClassMetadata(get_class($object));

        foreach ($reflection->getProperties() as $property) {

            $propertyName = $property->getName();
            $column       = $this->camelCaseToUnderscore($propertyName);
            $value        = $property->getValue($object);

            if ($metadata->isIdentifier($column)) {
                 $this->primary = $column;
                 $this->identifiers[$column] = $value;
            } elseif ($value instanceof DateTimeInterface) {
                $this->attributes[$column] = $value->format('Y-m-d H:i:s');
            } elseif ($value instanceof Collection) {
                $this->collection->addCollection($column, $value);
            } elseif (is_object($value)) {
                $this->belongs[$column] = $value;
            } else {
                $this->attributes[$column] = $value;
            }
            $this->properties[$propertyName] = $value;
        }

        return $this;
    }





    /**
     * @return string
    */
    public function getPrimary(): string
    {
        return $this->primary;
    }





    /**
     * @return mixed
    */
    public function getPrimaryValue(): mixed
    {
        return $this->identifiers[$this->primary] ?? null;
    }





    /**
     * @return array
    */
    public function getAttributes(): array
    {
         return $this->attributes;
    }





    /**
     * @return array
    */
    public function getBelongs(): array
    {
        return $this->belongs;
    }





    /**
     * @return PersistenceCollection
    */
    public function getCollection(): PersistenceCollection
    {
        return $this->collection;
    }



    /**
     * @return array
    */
    public function getIdentifiers(): array
    {
        return $this->identifiers;
    }




    /**
     * @return array
    */
    public function getProperties(): array
    {
        return $this->properties;
    }
}