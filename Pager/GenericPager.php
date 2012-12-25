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

/**
 * This is a generic pager. Based on the FQCN the pager determines whether
 * it supports a given target and paginates it. This of course affects
 * performance, but I haven't done any benchmarks. You'll probably be fine.
 *
 * @author Kristen Gilden <gilden@planet.ee>
 */
class GenericPager extends Pager
{
    /**
     * @var string
     */
    protected $providerFQCN;

    /**
     * @var string
     */
    protected $targetFQCN;

    /**
     * @param string $providerFQCN  FQCN of the provider. Type checking is done
     *                              in the compliation phase. If you're using
     *                              this separately, make sure to pass a class
     *                              name implementing ProviderInterface.
     * @param string $targetFQCN    FQCN of the target that is supported by the
     *                              $provider class.
     */
    public function __construct($providerFQCN, $targetFQCN)
    {
        $this->providerFQCN = $providerFQCN;
        $this->targetFQCN   = $targetFQCN;
    }

    /**
     * {@inheritDoc}
     */
    public function supports($target)
    {
        return $target instanceof $this->targetFQCN;
    }

    /**
     * {@inheritDoc}
     */
    protected function getProvider($target, array $options)
    {
        $providerFQCN = $this->providerFQCN;

        return new $providerFQCN($target, $options);
    }
}