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

abstract class Collection extends SplObjectStorage
{
    protected array $items = [];

    public function add(object $item): static
    {
        $this->items[] = $item;

        $this->attach($item);

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



class ArrayCollection extends Collection
{

}



class ColumnMapper
{





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
       * @return array
     */
     public function map(object $object): array
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
                 $this->mapping['hasMany'][] = $value->getItems();
             } elseif (is_object($value)) {
                 $this->mapping['belongTo'][] = $value;
             } else {
                 $this->mapping['attributes'][$column] = $value;
             }
         }

         return $this->mapping;
     }

}


$product = new \App\Entity\Product();
$product->setTitle('PC Lenovo idepad A50')
    ->setDescription('goods pc for business, for resolving engineering sciences.')
    ->setPrice(3500)
    ->setCreatedAt(new DateTime());


$user = new \App\Entity\User();
$user->setEmail('jeanyao@ymail.com')
     ->setPassword(password_hash('123', PASSWORD_DEFAULT))
     ->setUsername('jean-claude')
     ->setActive(true)
     ->setCreatedAt(new DateTime());

$user->addProduct($product);


$mapper = new DataMapper();

/*
dump($mapper->map($user)->toArray());
dump($mapper->map($user)->getAttributes());
dump($mapper->map($user)->getIdentityValue());
*/

dump($mapper->map($user));