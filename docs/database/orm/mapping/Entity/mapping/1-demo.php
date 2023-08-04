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