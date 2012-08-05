<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden gilden@planet.ee
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Tests\Result\Provider;

use KG\Bundle\PagerBundle\Result\Provider\ArrayProvider;

/**
 * @author Kristen Gilden <gilden@planet.ee>
 */
class ArrayProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testGetElementCount()
    {
        $provider = new ArrayProvider(array(1, 2, 3, 4, 5, 6));

        $this->assertEquals(6, $provider->getElementCount());
    }

    public function testGetElements()
    {
        $provider = new ArrayProvider(array(1, 2, 3, 4, 5, 6));

        $this->assertEquals(array(3, 4), $provider->getElements(2, 2));
    }
}