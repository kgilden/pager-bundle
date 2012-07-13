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

use KG\Bundle\PagerBundle\Result\PageResult;

/**
 * @author Kristen Gilden <gilden@planet.ee>
 */
class PageResultTest extends \PHPUnit_Framework_TestCase
{
    public function testGetPageNumber()
    {
        $result = new PageResult(array(), 10, 15);

        $this->assertEquals(10, $result->getPageNumber());
    }

    public function testGetPageCount()
    {
        $result = new PageResult(array(), 10, 15);

        $this->assertEquals(15, $result->getPageCount());
    }

    public function testIsFirst()
    {
        $result = new PageResult(array(), 1, 5);

        $this->assertTrue($result->isFirstPage());
    }

    public function testIsNotFirst()
    {
        $result = new PageResult(array(), 3, 5);

        $this->assertFalse($result->isFirstPage());
    }

    public function testIsLast()
    {
        $result = new PageResult(array(), 5, 5);

        $this->assertTrue($result->isLastPage());
    }

    public function testIsNotLast()
    {
        $result = new PageResult(array(), 1, 2);

        $this->assertFalse($result->isLastPage());
    }

    /**
     * @expectedException \LogicException
     */
    public function testGreaterCurrentPageThrowsException()
    {
        new PageResult(array(), 10, 5);
    }

    /**
     * @expectedException \LogicException
     */
    public function testNotPositiveCurrentPageThrowsException()
    {
        new PageResult(array(), -1, 5);
    }

    /**
     * @expectedException \LogicException
     */
    public function testNotPositivePageCountThrowsException()
    {
        new PageResult(array(), 2, 0);
    }
}