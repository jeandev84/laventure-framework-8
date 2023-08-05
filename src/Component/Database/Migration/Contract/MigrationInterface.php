<?php
namespace Laventure\Component\Database\Migration\Contract;


/**
 * @MigrationInterface
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\Migration\Contract
*/
interface MigrationInterface
{


    /**
     * Create or modify schema table
     *
     * @return void
    */
    public function up(): void;







    /**
     * Drop schema table or others modification
     *
     * @return void
    */
    public function down(): void;
}