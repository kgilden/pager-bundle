<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden kristen.gilden@gmail.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Result\Provider;

use Doctrine\ORM\QueryBuilder;

/**
 * @author Kristen Gilden <kristen.gilden@gmail.com>
 */
class ORMQueryBuilderProvider extends DQLProvider
{
    /**
     * @param QueryBuilder $qb
     */
    public function __construct(QueryBuilder $qb)
    {
        parent::__construct($qb->getQuery());
    }
}
