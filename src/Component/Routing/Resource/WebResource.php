<?php
namespace Laventure\Component\Routing\Resource;

use Laventure\Component\Routing\Resource\Contract\Resource;
use Laventure\Component\Routing\Resource\Types\ResourceType;
use Laventure\Component\Routing\Router;


/**
 * @inheritdoc
*/
class WebResource extends Resource
{

    /**
     * @inheritDoc
    */
    public function map(Router $router): static
    {
        $router->get($this->path(), $this->action('index'), $this->name('index'));
        $router->get($this->path('/{id}'), $this->action('show'), $this->name('show'));
        $router->get($this->path(), $this->action('create'), $this->name('create'));
        $router->post($this->path(), $this->action('store'), $this->name('store'));
        $router->map('PUT|PATCH', $this->path('/{id}'), $this->action('update'), $this->name('update'));
        $router->delete($this->path('/{id}'), $this->action('destroy'), $this->name('destroy'));

        return $this;
    }






    /**
     * @inheritDoc
    */
    public function getTypeName(): string
    {
        return ResourceType::WEB;
    }
}