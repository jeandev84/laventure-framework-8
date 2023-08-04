<?php

use App\Controller\Admin\UserController;
use Laventure\Component\Routing\Router;

require_once __DIR__.'/vendor/autoload.php';

/*
$func = function () {
    return "Hello.";
};


dd(serialize($func));
*/

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


class PersistenceCollection extends SplObjectStorage
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


class DataMapperResolver
{


    /**
     * @param object $object
     *
     * @return array
     */
    public function mapColumns(object $object): array
    {
        $reflection = new ReflectionObject($object);

        $parameters = [];

        foreach ($reflection->getProperties() as $property) {
            [$name, $value] = $this->resolve($property->getName(), $property->getValue($object));
            $parameters[$name] = $value;
        }

        return $parameters;
    }




    /**
     * @param string $column
     *
     * @param $value
     *
     * @return array
     */
    public function resolve(string $column, $value): array
    {
        $resolved = [];

        if ($value instanceof DateTimeInterface) {
            $resolved[$column] = $value->format('Y-m-d H:i:s');
        } elseif ($value instanceof Collection) {
            foreach ($value->getItems() as $object) {
                $resolved[$column][] = $this->mapColumns($object);
            }
        }elseif (is_object($value)) {
            $resolved[$column] = $this->mapColumns($value);
        }

        return $resolved;
    }
}