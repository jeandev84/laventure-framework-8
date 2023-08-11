<?php
namespace Laventure\Component\Database\Builder\SQL;

class JoinType
{
    const JOIN  = 'JOIN';
    const LEFT  = 'LEFT JOIN';
    const RIGHT = 'RIGHT JOIN';
    const FULL  = 'FULL JOIN';
    const INNER = 'INNER JOIN';
}