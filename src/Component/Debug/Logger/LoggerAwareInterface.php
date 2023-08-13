<?php
namespace Laventure\Component\Debug\Logger;


/**
 * @LoggerAwareInterface
 *
 * @see https://www.php-fig.org/psr/psr-3/
 *
 * Describes a logger-aware instance.
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Debug\Logger
*/
interface LoggerAwareInterface
{
    /**
     * Sets a logger instance on the object.
     *
     * @param LoggerInterface $logger
     *
     * @return void
    */
    public function setLogger(LoggerInterface $logger): void;
}