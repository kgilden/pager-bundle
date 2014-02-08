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
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query;
use KG\Bundle\PagerBundle\Result\Provider\DQLProvider;

/**
 * @author Kristen Gilden <gilden@planet.ee>
 */
class ORMPager extends Pager
{
    /**
     * {@inheritDoc}
     */
    public function paginate($target, array $options = array())
    {
        if ($target instanceof QueryBuilder) {
            $target = $target->getQuery();
        }

        return parent::paginate($target, $options);
    }

    /**
     * {@inheritDoc}
     */
    public function supports($target)
    {
        return ($target instanceof Query) || ($target instanceof QueryBuilder);
    }

    /**
     * @param Query $target
     * @param array $options
     *
     * @return DQLProvider
     */
    protected function getProvider($target, array $options)
    {
        return new DQLProvider($target);
    }
}
