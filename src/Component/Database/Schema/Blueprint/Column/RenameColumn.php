<?php
namespace Laventure\Component\Database\Schema\Blueprint\Column;


/**
 * @inheritdoc
*/
class RenameColumn extends Column
{

     /**
      * @param string $name
      *
      * @param string $to
     */
     public function __construct(string $name, string $to)
     {
         parent::__construct("RENAME COLUMN $name TO $to", '');
     }




     /**
      * @inheritdoc
     */
     public function getType(): string
     {
         return '';
     }





     /**
      * @inheritdoc
     */
     public function getConstraints(): string
     {
         return '';
     }
}