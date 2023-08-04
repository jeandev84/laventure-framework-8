### Autoload from json

```php 

require_once __DIR__ . '/src/Psr4/Autoloader.php';

Autoloader::load(__DIR__);


$dotenv = new \Laventure\Component\Dotenv\Dotenv(__DIR__);
$dotenv->load();

$controller = new \App\Controller\HelloController();

print_r($controller);
```