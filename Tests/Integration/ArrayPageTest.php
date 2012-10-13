<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden gilden@planet.ee
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Tests\Integration;

use KG\Bundle\PagerBundle\Pager\Pager;
use KG\Bundle\PagerBundle\Result\Provider\ArrayFactory;

/**
 * @author Kristen Gilden <gilden@planet.ee>
 */
class ArrayPageTest extends \PHPUnit_Framework_TestCase
{
    public function testArrayPage()
    {
        $target = array(
            'foo', 'bar', 'baz', 'foobar', 'foobaz', 'barfoo', 'barbaz', 'bazfoo', 'bazbar'
        );

        $pager = $this->makePager();
        $page  = $pager->paginate($target);
        $page->setElementsPerPage(3);
        $page->setCurrentPage(1);

        $this->assertEquals(array_slice($target, 0, 3), $page->all());
    }

    protected function makePager()
    {
        $factory = new ArrayFactory();

        return new Pager(array($factory));
    }
}
