### Manager 

```php 
use Laventure\Component\Database\ORM\Persistence\Definition;
use Laventure\Component\Database\ORM\Persistence\EntityManager;
use Laventure\Component\Database\ORM\Persistence\Manager\EventManager;
use Laventure\Component\Database\ORM\Persistence\Mapping\ClassMetadataFactory;
use Laventure\Component\Database\ORM\Persistence\Repository\RepositoryFactory;


require_once __DIR__.'/vendor/autoload.php';


# Filesystem
$filesystem = new \Laventure\Component\Filesystem\Filesystem(__DIR__);
$config     = $filesystem->load('config/database.php');



# Database
$database = new \Laventure\Component\Database\Manager\DatabaseManager();
$database->open($config['connection'], $config['connections']);
$conn = $database->connection();


$manager = new \Laventure\Component\Database\Manager($config);
$connection = $manager->connection();


$eventManager      = new EventManager();
$repositoryFactory = new RepositoryFactory();
$metadataFactory   = new ClassMetadataFactory();
$definition        = new Definition($metadataFactory, $repositoryFactory);
$em                = new EntityManager($connection, $definition, $eventManager);


$manager->setEntityManager($em);

# EventDispatcher
$provider = new \Laventure\Component\Event\Listener\ListenerProvider();

$provider->addListener(\App\Event\PreCreateUser::class, new \App\Listeners\UserListener());

$dispatcher = new \Laventure\Component\Event\Dispatcher\EventDispatcher($provider);

$event = $dispatcher->dispatch(new \App\Events\PreCreateUser($user));


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

$user = $em->find(\App\Entity\User::class, 3);
$user->setUsername('dddd');

$em->persist($user);
$em->flush();



dump($manager->getEntityManager());


## Capsule for quick records
$manager = \Laventure\Component\Database\Manager::capture();

$files = $filesystem->iterate('src');

foreach ($files as $file) {
    echo $file, "\n";
}

$filesystem->write('storage/test.php', 'bla bla ...');
echo $filesystem->read('storage/test.php');
```