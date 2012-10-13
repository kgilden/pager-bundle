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

use KG\Bundle\PagerBundle\Result\Provider\ArrayProvider;

/**
 * Pages arrays
 *
 * @author Kristen Gilden <gilden@planet.ee>
 */
class ArrayPager extends Pager
{
    /**
     * {@inheritDoc}
     */
    public function supports($target)
    {
        return is_array($target);
    }

    /**
     * {@inheritDoc}
     */
    protected function getProvider($target, array $options)
    {
        return new ArrayProvider($target, $options);
    }
}