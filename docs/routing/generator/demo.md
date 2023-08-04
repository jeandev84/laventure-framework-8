### Routing (URL Generator)


- Example
```php 
require_once __DIR__.'/vendor/autoload.php';


$router = new \Laventure\Component\Routing\Router('http://localhost:8000');
$router->namespace('App\\Controller');
$router->middlewares([
    'auth'    => \App\Middleware\AuthenticatedMiddleware::class,
    'guest'   => \App\Middleware\GuestMiddleware::class,
    'session' => \App\Middleware\SessionMiddleware::class
]);


$router->get('/api/v1/users', [\App\Controller\Api\UserController::class, 'index'], 'api.users.list');
$router->get('/api/v1/user/{id}', [\App\Controller\Api\UserController::class, 'show'], 'api.user.show');
$router->get('/api/v1/product/{slug}', [\App\Controller\Api\ProductController::class, 'show'], 'api.product.show')
       ->slug('slug')->middleware(['auth', \App\Middleware\GuestMiddleware::class]);



# URL generator

$url = new \Laventure\Component\Routing\Generator\UrlGenerator($router, ['page' => 1, 'sort' => 'books.id', 'direction' => 'desc']);


# http://localhost:8000/api/v1/product/computer-from-russia?page=1&sort=books.id&direction=desc
echo $url->generate('api.product.show', ['slug' => 'computer-from-russia']), "\n";

# /api/v1/product/computer-from-russia?page=1&sort=books.id&direction=desc
echo $url->generateUri('api.product.show', ['slug' => 'computer-from-russia']), "\n";


# http://localhost:8000/api/v1/product/computer-from-russia?page=1&sort=books.id&direction=desc&deleted=1
echo $url->generate('api.product.show', ['slug' => 'computer-from-russia'], ['deleted' => 1]), "\n";


# http://localhost:8000/api/v1/product/computer-from-russia?page=1&sort=books.id&direction=desc&deleted=1#visible
echo $url->generate('api.product.show', ['slug' => 'computer-from-russia'], ['deleted' => 1], 'visible'), "\n";


```