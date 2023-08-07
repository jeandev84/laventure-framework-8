### EventDispatcher 


```php 
# EventDispatcher

$user = new \App\Entity\User();
$user->setUsername('jeanyao@ymail.com')
    ->setPassword(password_hash('123', PASSWORD_DEFAULT))
    ->setActive(true)
    ->setCreatedAt(new DateTime())
    ->setUpdatedAt(new DateTime());


$provider = new \Laventure\Component\Event\Listeners\ListenerProvider();

$provider->addListener(\App\Events\PreCreateUser::class, new \App\Listeners\UserListener());

$dispatcher = new \Laventure\Component\Event\Dispatcher\EventDispatcher($provider);

$event = $dispatcher->dispatch(new \App\Events\PreCreateUser($user));


dd($event);
```