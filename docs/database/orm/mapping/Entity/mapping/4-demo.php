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

            $column = $property->getName();
            $value  = $property->getValue($object);

            if ($value instanceof DateTimeInterface) {
                $parameters[$column] = $value->format('Y-m-d H:i:s');
            } elseif ($value instanceof Collection) {
                foreach ($value->getItems() as $item) {
                    $parameters[$column][] = $this->mapColumns($item);
                }
            } elseif (is_object($value)) {
                $parameters[$column] = $this->mapColumns($value);
            } else {
                $parameters[$column] = $value;
            }

        }

        return $parameters;
    }
}


$user = new \App\Entity\User();
$user->setEmail('jeanyao@ymail.com')
    ->setPassword(password_hash('123', PASSWORD_DEFAULT))
    ->setUsername('jean-claude')
    ->setActive(true)
    ->setCreatedAt(new DateTime());

$mapper = new DataMapper();

dd($mapper->map($user));