<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden kristen.gilden@gmail.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Pager;

use FOS\ElasticaBundle\Paginator\PaginatorAdapterInterface;
use KG\Bundle\PagerBundle\Result\Provider\FOSElasticaProvider;

class FOSElasticaPager extends Pager
{
    /**
     * {@inheritDoc}
     */
    public function supports($target, array $options = array())
    {
        return $target instanceof PaginatorAdapterInterface;
    }

    /**
     * {@inheritDoc}
     */
    protected function getProvider($target, array $options)
    {
        return new FOSElasticaProvider($target);
    }
}
