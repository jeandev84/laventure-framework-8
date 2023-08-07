### EntityManager 

```php 
use Laventure\Component\Database\ORM\Persistence\Definition;
use Laventure\Component\Database\ORM\Persistence\EntityManager;
use Laventure\Component\Database\ORM\Persistence\Manager\Event\EventManager;
use Laventure\Component\Database\ORM\Persistence\Mapping\ClassMetadataFactory;
use Laventure\Component\Database\ORM\Persistence\Repository\RepositoryFactory;


require_once __DIR__.'/vendor/autoload.php';


$config  = require_once __DIR__.'/config/database.php';

$manager = new \Laventure\Component\Database\Manager\DatabaseManager();

$manager->open($config['connection'], $config['connections']);

$connection = $manager->connection();


/*
$class    = \App\Entity\User::class;
$metadata = new \Laventure\Component\Database\ORM\Persistence\Mapping\ClassMetadata($class);
dd($metadata->getFieldNames());
*/

$eventManager      = new EventManager();
$repositoryFactory = new RepositoryFactory();
$metadataFactory   = new ClassMetadataFactory();
$definition        = new Definition($metadataFactory, $repositoryFactory);
$em                = new EntityManager($connection, $definition, $eventManager);


/*
$em->close();

dump($em->isOpen());

$em->open(true);

dd($em->isOpen());


$repository = $em->getRepository(\App\Entity\User::class);

# $user = $repository->find(3);

$users = $repository->findOneBy(['id' => 3]);

dump($em->getUnitOfWork()->getPersists());



$mapper = new \Laventure\Component\Database\ORM\Persistence\DataMapper($em);


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



$em->persist($user);
$em->flush();


dump($em->getUnitOfWork()->getPersists());



$manager->close();
```