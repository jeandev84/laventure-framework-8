### Routing (Routes)


- Example
```php 
require_once __DIR__.'/vendor/autoload.php';

$route = new \Laventure\Component\Routing\Route\Route('http://localhost:8000', ['GET'], '/welcome', function () {
     return 'Welcome';
}, 'welcome');
```