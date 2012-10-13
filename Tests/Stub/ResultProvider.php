<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden gilden@planet.ee
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Tests\Stub;

use KG\Bundle\PagerBundle\Result\Provider\ProviderInterface;

/**
 * A stub result provider for testing.
 *
 * @author Kristen Gilden <gilden@planet.ee>
 */
class ResultProvider implements ProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function getElementCount()
    {
        return 0;
    }

    /**
     * {@inheritDoc}
     */
    public function getElements($offset, $count)
    {
        return array();
    }
}