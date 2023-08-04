### Routing (Routes)


- Example
```php 
require_once __DIR__.'/vendor/autoload.php';

$router = new Router('http://localhost');
$router->middlewareStack([
    'auth'    => \App\Middleware\AuthenticatedMiddleware::class,
    'guest'   => \App\Middleware\GuestMiddleware::class,
    'session' => \App\Middleware\SessionMiddleware::class
]);

$router->namespace('App\\Controller');


$router->map('GET', '/', function () {
    return 'Welcome';
})->only('guest');


$router->get('/books/{id}/{slug}', [
    \App\Controller\BookController::class,
    'show'
], 'books.show')
->where('id', '\d+')
->slug('slug');



if(! $route = $router->match('GET', 'http://localhost/books/1/this-is-a-new-book')) {
     dd('Route note found');
}

dump($route);
dump($router->generate('books.show', ['id' => 1, 'slug' => 'this-is-a-new-book']));



$prefixes =  [
    'path'   => 'admin',
    'module' => 'Admin',
    'name'   => 'admin.'
];


$router->group($prefixes, function (Router $router) {
   $router->get('/', [UserController::class, 'index'], 'users.list');
   $router->get('/{id}', [UserController::class, 'show'], 'users.show')
          ->number('id');

   $router->resource('books', \App\Controller\Admin\BookController::class);
});


$router->get('/', function () {
    return 'Welcome!';
});


$prefixes =  [
    'path'   => 'api/v1/',
    'name'   => 'api.v1.'
];

$router->group($prefixes, function (Router $router) {
    $router->apiResource('cart', \App\Controller\Api\v1\CartController::class);
});


if (! $route = $router->match('GET', '/api/v1/cart')) {
    dd('Route /api/v1/cart not found');
}

$dispatcher = new \Laventure\Component\Routing\Route\Dispatcher\RouteDispatcher();
echo $dispatcher->dispatchRoute($route);

$router->get('/hello/{id?}', \App\Controller\HelloController::class, 'hello')
       ->where('id', '\d+')
       ->middleware(['guest', \App\Middleware\AuthenticatedMiddleware::class]);

try {

    if (! $route = $router->match('GET', '/hello')) {
        throw new NotFoundRouteException('/hello');
    }

} catch (Exception $e) {

    dd($e->getMessage());
}


echo "\n";
echo $router->generate('hello', ['id' => 3]) . "\n";

```