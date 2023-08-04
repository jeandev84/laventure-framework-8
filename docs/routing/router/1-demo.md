### Routing (Routes)


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

$router->map('GET', '/', function () {
    return 'Welcome';
});


$router->get('/', [\App\Controller\HomeController::class, 'index'], 'home');
$router->get( '/contact', [\App\Controller\HomeController::class, 'contact'], 'contact');
$router->post( '/send', 'HomeController@send', 'send');
$router->get( '/foo/{id?}', function ($id = null) {
    return "Foo";
}, 'foo');

$router->get('/api/v1/users', [\App\Controller\Api\UserController::class, 'index'], 'api.users.list');
$router->get('/api/v1/user/{id}', [\App\Controller\Api\UserController::class, 'show'], 'api.user.show');
$router->get('/api/v1/product/{slug}', [\App\Controller\Api\ProductController::class, 'show'], 'api.product.show')
       ->slug('slug');


try {

    if(! $route = $router->match($_SERVER['REQUEST_METHOD'], $path = $_SERVER['REQUEST_URI'])) {
         throw new Exception("Route $path not found.");
    }

} catch (Exception $e) {

    dd($e->getMessage());
}


# echo $router->generate('api.product.show', ['slug' => 'computer-from-russia']);
dump($route);

$attributes = [
   'path' => 'api/',
   'module' => 'Api\\',
   'name' => 'api.',
   'middlewares' => ['session']
];

$router->group($attributes, function (\Laventure\Component\Routing\Router $router) {
    $router->resource('books', \App\Controller\Api\BookController::class);
});


$router->get('/', [\App\Controller\HomeController::class, 'index'], 'home');
$router->get( '/contact', [\App\Controller\HomeController::class, 'contact'], 'contact');
$router->post( '/send', 'HomeController@send', 'send');
$router->get( '/foo/{id?}', function ($id = null) {
    return "Foo";
}, 'foo');

$router->get('/api/v1/users', [\App\Controller\Api\UserController::class, 'index'], 'api.users.list');
$router->get('/api/v1/user/{id}', [\App\Controller\Api\UserController::class, 'show'], 'api.user.show');
$router->get('/api/v1/product/{slug}', [\App\Controller\Api\ProductController::class, 'show'], 'api.product.show')
       ->slug('slug')->middleware(['auth', \App\Middleware\GuestMiddleware::class]);


echo $router->generate('api.product.show', ['slug' => 'some-product-from-russia']), "\n";
dd($router->getRoutes());
```