<?php
namespace Laventure\Component\Database\Builder\SQL\Commands\DQL\Contract;

/**
 * @PaginatedQueryInterface
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\Builder\SQL\Commands\DQL\Contract
*/
interface PaginatedQueryInterface
{

    /**
     * @param int $page current page
     *
     * @param int $limit limit result
     *
     * @return array
    */
    public function paginate(int $page, int $limit): array;





    /**
     * @return array
    */
    public function getTotalRecords(): array;
}