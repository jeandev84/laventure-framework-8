### EntityManager


```php 
use Laventure\Component\Database\ORM\Persistence\Definition;
use Laventure\Component\Database\ORM\Persistence\EntityManager;
use Laventure\Component\Database\ORM\Persistence\Manager\EventManager;
use Laventure\Component\Database\ORM\Persistence\Mapping\ClassMetadataFactory;
use Laventure\Component\Database\ORM\Persistence\Repository\RepositoryFactory;


require_once __DIR__.'/vendor/autoload.php';


$config  = require_once __DIR__.'/config/database.php';

/*
$manager = new \Laventure\Component\Database\Manager\DatabaseManager();

$manager->open($config['connection'], $config['connections']);

$connection = $manager->connection();
*/

# Database
$manager = new \Laventure\Component\Database\Manager($config);
# $capsule = \Laventure\Component\Database\Manager::capsule();
$connection = $manager->connection();


$eventManager      = new EventManager();
$repositoryFactory = new RepositoryFactory();
$metadataFactory   = new ClassMetadataFactory();
$definition        = new Definition($metadataFactory, $repositoryFactory);
$em                = new EntityManager($connection, $definition, $eventManager);


$manager->setEntityManager($em);


# EventDispatcher

/*
$provider = new \Laventure\Component\Event\Listener\ListenerProvider();

$provider->addListener(\App\Event\PreCreateUser::class, new \App\Listeners\UserListener());

$dispatcher = new \Laventure\Component\Event\Dispatcher\EventDispatcher($provider);

$event = $dispatcher->dispatch(new \App\Event\PreCreateUser($user));
*/

$product = new \App\Entity\Product();
$product->setTitle('PC Lenovo idepad A50')
    ->setDescription('goods pc for business, for resolving engineering sciences.')
    ->setPrice(3500)
    ->setCreatedAt(new DateTime());


$user = new \App\Entity\User();
$user->setUsername('jeanyao@ymail.com')
    ->setPassword(password_hash('123', PASSWORD_DEFAULT))
    ->setActive(true)
    ->setCreatedAt(new DateTime())
    ->setUpdatedAt(new DateTime());

/*
$user = $em->find(\App\Entity\User::class, 3);
$user->setUsername('dddd');

$em->persist($user);
$em->flush();
*/



dd($manager->getEntityManager());
```