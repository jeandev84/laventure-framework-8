<?php

use App\Controller\Admin\UserController;
use Laventure\Component\Routing\Router;

require_once __DIR__.'/vendor/autoload.php';

/*
$func = function () {
    return "Hello.";
};


dumo(serialize($func));

$user = new \App\Entity\User();
$user->setEmail('jeanyao@ymail.com')
     ->setPassword(password_hash('123', PASSWORD_DEFAULT))
     ->setUsername('jean-claude')
     ->setActive(true)
     ->setCreatedAt(new DateTime());

#echo serialize($user);
$reflection = new ReflectionObject($user);

$parameters = [];

foreach ($reflection->getProperties() as $property) {
    $value = $property->getValue($user);
    # $property->setValue($property->getName(), $property->getDefaultValue());
    $parameters[$property->getName()] = $property->getValue($user);
}

dd($parameters);
*/

class Collection extends SplObjectStorage
{
    protected array $items = [];

    public function add(object $item): static
    {
        $this->items[] = $item;

        return $this;
    }


    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }
}



class DataMapper
{


    /**
     * @var string
    */
    protected string $identity = 'id';



    /**
     * @var array
     */
    protected array $mapping = [
        'attributes' => [],
        'hasMany'    => [],
        'belongTo'   => []
    ];







    /**
     * @param object $object
     *
     *
     * @return $this
     */
    public function map(object $object): static
    {
        $reflection = new ReflectionObject($object);

        foreach ($reflection->getProperties() as $property) {

            $column = $property->getName();
            $value  = $property->getValue($object);

            if ($column === $this->identity) {
                $this->mapping[$this->identity] = $value;
            } elseif ($value instanceof DateTimeInterface) {
                $this->mapping['attributes'][$column] = $value->format('Y-m-d H:i:s');
            } elseif ($value instanceof Collection) {
                foreach ($value->getItems() as $item) {
                    $this->mapping['hasMany'][$column] = $this->map($item);
                }
            } elseif (is_object($value)) {
                $this->mapping['belongTo'][$column] = $this->map($value);
            } else {
                $this->mapping['attributes'][$column] = $value;
            }
        }

        return $this;
    }




    /**
     * @return mixed
     */
    public function getIdentityValue(): mixed
    {
        return $this->mapping[$this->identity] ?? null;
    }




    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->mapping['attributes'];
    }





    /**
     * @return array
     */
    public function getHasMany(): array
    {
        return $this->mapping['hasMany'];
    }




    /**
     * @return array
     */
    public function getBelongsTo(): array
    {
        return $this->mapping['belongTo'];
    }







    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->mapping;
    }
}


$user = new \App\Entity\User();
$user->setEmail('jeanyao@ymail.com')
    ->setPassword(password_hash('123', PASSWORD_DEFAULT))
    ->setUsername('jean-claude')
    ->setActive(true)
    ->setCreatedAt(new DateTime());

$mapper = new DataMapper();

dump($mapper->map($user)->toArray());
dump($mapper->map($user)->getAttributes());