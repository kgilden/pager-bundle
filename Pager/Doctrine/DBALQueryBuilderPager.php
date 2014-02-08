<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden kristen.gilden@gmail.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Pager\Doctrine;

use KG\Bundle\PagerBundle\Pager\Pager;
use KG\Bundle\PagerBundle\Result\Provider\DBALQueryBuilderProvider;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * @author Kristen Gilden <gilden@planet.ee>
 */
class DBALQueryBuilderPager extends Pager
{
    /**
     * {@inheritDoc}
     */
    public function supports($target)
    {
        return $target instanceof QueryBuilder;
    }

    /**
     * {@inheritDoc}
     */
    protected function getProvider($target, array $options)
    {
        return new DBALQueryBuilderProvider($target);
    }
}
