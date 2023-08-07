<?php
namespace Laventure\Component\Database\ORM\Persistence\Manager;

/**
 * @Event
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\ORM\Persistence\Manager
*/
class Event
{
     const postLoad          = 'postLoad';
     const prePersist        = 'prePersist';
     const postPersist       = 'postPersist';
     const preUpdate         = 'preUpdate';
     const postUpdate        = 'postUpdate';
     const preRemove         = 'preRemove';
     const postRemove        = 'postRemove';
     const preFlush          = 'preFlush';
     const onFlush           = 'onFlush';
     const postFlush         = 'postFlush';
     const onClear           = 'onClear';
}