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

use KG\Bundle\PagerBundle\Exception\ProviderNotFoundException;
use KG\Bundle\PagerBundle\Result\LazyPage;

/**
 * Uses event dispatching to create a paged result
 *
 * @author Kristen Gilden <gilden@planet.ee>
 */
class Pager implements PagerInterface
{
    /**
     * @var array
     */
    protected $factories;

    /**
     * @param array $factories
     */
    public function __construct(array $factories)
    {
        $this->factories = $factories;
    }

    /**
     * {@inheritDoc}
     */
    public function paginate($target, array $options = array())
    {
        if (!$factory = $this->findFactory($target)) {
            throw new ProviderNotFoundException($target);
        }

        return new LazyPage($factory->get($target, $options));
    }

    /**
     * Finds a factory capable of creating result providers for the
     * specific query target.
     *
     * @param mixed $target
     *
     * @return KG\Bundle\PagerBundle\Result\
     */
    protected function findFactory($target)
    {
        foreach ($this->factories as $factory) {
            if ($factory->supports($target)) {
                return $factory;
            }
        }

        return null;
    }
}