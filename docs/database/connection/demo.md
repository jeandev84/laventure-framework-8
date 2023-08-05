### Connection and Query execution


```php 

require_once __DIR__.'/vendor/autoload.php';


$config  = require_once __DIR__.'/config/database.php';

$manager = new \Laventure\Component\Database\Manager\DatabaseManager();

$manager->open($config['connection'], $config['connections']);

$connection = $manager->connection();

$statement = $connection->statement('SELECT * FROM users');

$records = $statement->fetch()->map(\App\Entity\User::class)->one();

dd($statement->getLogger()->getQueryResult()->getMapped());

```