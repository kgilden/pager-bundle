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
 * @author Kristen Gilden <gilden@planet.ee>
 */
class ArrayFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function supports($target, array $options = array())
    {
       return is_array($target);
    }

    /**
     * {@inheritDoc}
     */
    public function get($target, array $options = array())
    {
       return new ArrayProvider($target, $options);
    }
}