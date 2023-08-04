### Asset mapper


```php 
use Laventure\Component\Templating\Renderer\Renderer;
use Laventure\Component\Templating\Template\Cache\TemplateCache;
use Laventure\Component\Templating\Template\Layout\Layout;
use Laventure\Component\Templating\Template\Template;

require_once __DIR__ . '/vendor/autoload.php';


$asset = new \Laventure\Component\Templating\Asset\Asset('http://localhost:8000');


$asset->css([
   'assets/css/app.css'
]);

$asset->js([
    'assets/js/app.js'
]);

dd($asset->renderScripts());
dd($asset->renderStyles());
```