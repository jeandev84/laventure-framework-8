### Engine Rendering


```php 


use App\Cache\TemplateCache;
use Laventure\Component\Templating\Renderer\Renderer;
use Laventure\Component\Templating\Template\Engine\TemplateEngine;

require_once __DIR__.'/vendor/autoload.php';



$cache    = new TemplateCache(__DIR__.'/storage/cache/views');
$engine   = new TemplateEngine(__DIR__.'/templates', $cache, true);
$renderer = new Renderer($engine);

$content = $renderer->render('index.html', [
    'title' => 'Вход',
    'users' => [
        new \App\Entity\User('demo1@test.com', md5(123)),
        new \App\Entity\User('demo2@test.com', md5(123)),
        new \App\Entity\User('demo3@test.com', md5(123)),
    ]
]);


echo $content;
```
