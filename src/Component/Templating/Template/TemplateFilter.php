<?php
namespace Laventure\Component\Templating\Template;

class TemplateFilter
{

      /**
       * @var string
      */
      protected string $name;



      /**
       * @var callable
      */
      protected $callback;




      /**
       * @param string $name
       *
       * @param callable $callback
      */
      public function __construct(string $name, callable $callback)
      {
      }




      /**
       * @return mixed
      */
      public function runFilter()
      {
           return null;
      }
}