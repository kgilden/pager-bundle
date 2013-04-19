<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden gilden@planet.ee
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Tests\Result;

use KG\Bundle\PagerBundle\Result\LazyPage;
use Traversable;

/**
 * @author Kristen Gilden <gilden@planet.ee>
 */
class LazyPageTest extends \PHPUnit_Framework_TestCase
{
    public function testCount()
    {
        $provider = $this->getMockProvider();
        $page     = new LazyPage($provider);

        $provider
            ->expects($this->once())
            ->method('getElements')
            ->with(10, 5)
            ->will($this->returnValue(array_fill(0, 5, 'foo')))
        ;

        $provider
            ->expects($this->once())
            ->method('getElementCount')
            ->will($this->returnValue(30))
        ;

        $page->setElementsPerPage(5);
        $page->setCurrentPage(3);

        $this->assertEquals(5, $page->count());

        return $page;
    }

    /**
     * @depends testCount
     */
    public function testGetIterator(LazyPage $page)
    {
        $provider = $this->getMockProvider();
        $provider
            ->expects($this->never())
            ->method('getElementCount')
        ;

        $page->setProvider($provider);

        if (!$page->getIterator() instanceof Traversable) {
            $this->fail('LazyPage::getIterator() must be instance of Traversable');
        }
    }

    public function testCurrentPageChangeLoadsNewElements()
    {
        $provider = $this->getMockProvider();
        $page     = new LazyPage($provider);

        $provider
            ->expects($this->at(1))
            ->method('getElements')
            ->will($this->returnValue(array('foo')))
        ;

        $provider
            ->expects($this->at(2))
            ->method('getElements')
            ->will($this->returnValue(array('bar')))
        ;

        $provider
            ->expects($this->once())
            ->method('getElementCount')
            ->will($this->returnValue(30))
        ;

        $page->setElementsPerPage(1);
        $page->setCurrentPage(3);

        $this->assertEquals('foo', $page[0]);

        $page->setCurrentPage(4);

        $this->assertEquals('bar', $page[0], 'LazyPager should get a new page');
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    public function getMockProvider()
    {
        return $this->getMock('KG\\Bundle\\PagerBundle\\Result\\Provider\\ProviderInterface');
    }
}
