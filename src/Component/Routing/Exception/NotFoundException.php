<?php
namespace Laventure\Component\Routing\Exception;

/**
 * @NotFoundRouteException
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Routing\Exception
*/
class NotFoundException extends \Exception
{
     public function __construct(string $message = "")
     {
         parent::__construct($message, 404);
     }
}