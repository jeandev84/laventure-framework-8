<?php
namespace Laventure\Component\Routing\Route;

use Laventure\Component\Routing\Route\Group\RouteGroup;

/**
 * @RouteResolver
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Routing\Route
*/
class RouteResolver
{

    /**
     * @param RouteGroup $group
     */
    public function __construct(protected RouteGroup $group)
    {
    }








    /**
     * @param string $path
     *
     * @return string
     */
    public function resolvePath(string $path): string
    {
        if ($prefix = $this->group->getPath()) {
            $path = trim($prefix, '/') . 'RouteResolver.php/' . ltrim($path, '/');
        }

        return $path;
    }







    /**
     * @param mixed $action
     *
     * @return mixed
     */
    public function resolveAction(mixed $action): mixed
    {
        if (is_string($action)) {
            $action = $this->resolveActionFromString($action);
        }

        return $action;
    }





    /**
     * @param string $action
     *
     * @return array|string
     */
    private function resolveActionFromString(string $action): array|string
    {
        if (stripos($action, '@') !== false) {
            $action     = explode('@', $action, 2);
            $controller = sprintf('%s\\%s', $this->group->getNamespace(), $action[0]);
            return [$controller, $action[1]];
        }

        return $action;
    }
}