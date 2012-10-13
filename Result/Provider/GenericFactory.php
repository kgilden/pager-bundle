<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden gilden@planet.ee
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Result\Provider;

/**
 * This is a generic result provider factory for the basic providers. Based
 * on the FQCN the factory determines whether it supports a given target
 * and returns a new provider on demand.
 *
 * @author Kristen Gilden <gilden@planet.ee>
 */
class GenericFactory implements FactoryInterface
{
    /**
     * @var string
     */
    protected $provider;

    /**
     * @var string
     */
    protected $target;

    /**
     *
     * @param string $provider  FQCN of the provider. Type checking is done
     *                          during the container building phase instead.
     *                          If you're using this separately, make sure to
     *                          pass a class name implementing ProviderInterface.
     * @param string $target    FQCN of the target that is supported by the
     *                          $provider class.
     */
    public function __construct($provider, $target)
    {
        $this->provider = $provider;
        $this->target   = $target;
    }

    /**
     * {@inheritDoc}
     */
    public function supports($target, array $options = array())
    {
        return $target instanceof $this->target;
    }

    /**
     * {@inheritDoc}
     */
    public function get($target, array $options = array())
    {
        $provider = $this->provider;

        return new $provider($target, $options);
    }
}