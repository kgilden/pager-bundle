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

use FOS\ElasticaBundle\Paginator\PaginatorAdapterInterface;

class FOSElasticaProvider implements ProviderInterface
{
    /**
     * @var PaginatorAdapterInterface
     */
    private $adapter;

    /**
     * @param PaginatorAdapterInterface $adapter
     */
    public function __construct(PaginatorAdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * {@inheritDoc}
     */
    public function getElementCount()
    {
        return $this->adapter->getTotalHits();
    }

    /**
     * {@inheritDoc}
     */
    public function getElements($offset, $count)
    {
        return $this->adapter->getResults($offset, $count);
    }
}
