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
 * Result provider factories build result providers for specific queries.
 *
 * @author Kristen Gilden <gilden@planet.ee>
 */
interface FactoryInterface
{
    /**
     * @param mixed $target
     * @param array $options
     *
     * @return boolean whether the target is supported by the result provider
     */
    function supports($target, array $options = array());

    /**
     * Constructs a result provider for the specified target.
     *
     * @param mixed $target
     * @param array $options
     *
     * @return ProviderInterface
     */
    function get($target, array $options = array());
}