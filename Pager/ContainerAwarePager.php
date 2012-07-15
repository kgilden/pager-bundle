<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden gilden@planet.ee
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Pager;

use KG\Bundle\PagerBundle\Pager\PagerInterface;
use KG\Bundle\PagerBundle\Result\Provider\ProviderInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * @author Kristen Gilden <gilden@planet.ee>
 */
class ContainerAwarePager extends ContainerAware implements PagerInterface
{
    /**
     * @var array
     */
    protected $engines;

    /**
     * @param array $engines    An array of paging engine service names and
     *                          related types.
     */
    public function __construct(array $engines = array())
    {
        $this->engines = $engines;
    }

    /**
     * {@inheritDoc}
     */
    public function paginate($query)
    {
        $provider = $this->getProviderForQuery($query);

        return $provider->getPageResult($query);
    }

    /**
     * {@inheritDoc}
     */
    public function supports($query)
    {
        $type = $this->getType($query);

        return isset($this->engines[$type]);
    }

    /**
     * @return ProviderInterface
     */
    protected function getProviderForQuery($query)
    {
        $type = $this->getType($query);

        return $this->container->get($this->engines[$type]);
    }

    /**
     * Gets the query type.
     *
     * @param string $query
     *
     * @return string
     */
    protected function getType($query)
    {
        if (is_object($query)) {
            return get_class($query);
        }

        if (is_string($query)) {
            return 'sql';
        }

        if (is_array($query)) {
            return 'array';
        }
    }
}
