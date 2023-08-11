<?php
namespace Laventure\Component\Database\Migration;

use Laventure\Component\Database\Migration\Contract\MigrationInterface;
use ReflectionClass;


/**
 * @Migration
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\Migration
*/
abstract class Migration implements MigrationInterface
{



    /**
     * Returns migration name, this may be the version migration
     *
     * @return string
    */
    public function getName(): string
    {
         return $this->reflection()->getShortName();
    }






    /**
     * Returns the migration path
     *
     * @return string
    */
    public function getPath(): string
    {
         return $this->reflection()->getFileName();
    }




    /**
     * @return string
    */
    public function getFullName(): string
    {
        return $this->reflection()->getName();
    }





    /**
     * @return ReflectionClass
    */
    private function reflection(): ReflectionClass
    {
        return new ReflectionClass(get_called_class());
    }
}