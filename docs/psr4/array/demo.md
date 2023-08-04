### Autoload from array 

```php 
require_once __DIR__ . '/src/Psr4/Autoloader.php';

$autoloader = new Autoloader(__DIR__);

$autoloader->addNamespaces([
  'Laventure\\' => 'src/',
  'App\\' => 'app/'
]);


$autoloader->register();


$dotenv = new \Laventure\Component\Dotenv\Dotenv(__DIR__);
$dotenv->load();

$controller = new \App\Controller\HelloController();

print_r($controller);
```