<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden gilden@planet.ee
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Event;

use KG\Bundle\PagerBundle\Result\Provider\ProviderInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Kristen Gilden <gilden@planet.ee>
 */
class PagerEvent extends Event
{
    /**
     * @var ProviderInterface
     */
    protected $provider;

    /**
     * @var mixed
     */
    protected $target;

    /**
     * @param mixed $target
     */
    public function __construct($target)
    {
        $this->target = $target;
    }

    /**
     * @return mixed
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Sets the provider that is capable of paginating the target. Propagation
     * is stopped, because the provider has been found.
     *
     * @param ProviderInterface $provider
     */
    public function setProvider(ProviderInterface $provider)
    {
        $this->provider = $provider;

        $this->stopPropagation();
    }

    /**
     * @return ProviderInterface
     */
    public function getProvider()
    {
        return $this->provider;
    }
}