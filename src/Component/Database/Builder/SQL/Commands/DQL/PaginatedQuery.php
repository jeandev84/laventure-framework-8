<?php
namespace Laventure\Component\Database\Builder\SQL\Commands\DQL;


use Laventure\Component\Database\Builder\SQL\Commands\DQL\Contract\PaginatedQueryInterface;


/**
 * @inheritdoc
*/
class PaginatedQuery implements PaginatedQueryInterface
{


        /**
         * @param Select $select
        */
       public function __construct(protected Select $select)
       {
       }





       /**
        * @inheritdoc
       */
       public function getTotalRecords(): array
       {
            return $this->select->getQuery()->getResult();
       }






       /**
        * @inheritdoc
       */
       public function paginate(int $page, int $limit = 5): array
       {
             $offset = $limit * abs($page - 1);

             return $this->select->offset($offset)
                                 ->limit($limit)
                                 ->fetch()
                                 ->all();
       }
}