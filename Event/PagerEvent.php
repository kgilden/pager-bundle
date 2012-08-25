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
     * @var array
     */
    protected $options;

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
     * @param array $options
     */
    public function __construct($target, array $options = array())
    {
        $this->target  = $target;
        $this->options = $options;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
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