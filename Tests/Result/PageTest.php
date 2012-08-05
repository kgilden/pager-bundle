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

use KG\Bundle\PagerBundle\Result\Page;

/**
 * @author Kristen Gilden <gilden@planet.ee>
 */
class PageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider negativeIntegerProvider
     * @expectedException LogicException
     */
    public function testInvalidElementCountThrowsException($elementCount)
    {
        $page = new Page();
        $page->setElementCount($elementCount);
    }

    public function negativeIntegerProvider()
    {
        return array(array(-1), array('-2'));
    }

    /**
     * @dataProvider nonPositiveIntegerProvider
     * @expectedException LogicException
     */
    public function testInvalidElementsPerPageThrowsException($elementsPerPage)
    {
        $page = new Page();
        $page->setElementsPerPage($elementsPerPage);
    }

    public function nonPositiveIntegerProvider()
    {
        return array(array(0), array(-1), array('-2'));
    }

    /**
     * @dataProvider pageCountProvider
     */
    public function testPageCount($expectedPageCount, $elementCount, $elementsPerPage)
    {
        $page = new Page();
        $page->setElementCount($elementCount);
        $page->setElementsPerPage($elementsPerPage);

        $this->assertEquals($expectedPageCount, $page->getPageCount());
    }

    public function pageCountProvider()
    {
        return array(
            array(1, 0, 10),
            array(1, 10, 10),
            array(2, 11, 10),
        );
    }

    /**
     * @expectedException OutOfRangeException
     */
    public function testCurrentPageGreaterThanPageCountThrowsException()
    {
        $page = new Page();
        $page->setElementCount(11);
        $page->setElementsPerPage(2);

        // 11 elements divided to 2 elements per page makes for 6 pages
        $page->setCurrentPage(7);
    }

    /**
     * @expectedException OutOfRangeException
     */
    public function testNegativeCurrentPageThrowsException()
    {
        $page = new Page();
        $page->setElementCount(11);
        $page->setElementsPerPage(2);

        $page->setCurrentPage(0);
    }

    public function testIsFirstAndNotIsLast()
    {
        $page = new Page();
        $page->setElementCount(3);
        $page->setElementsPerPage(1);

        $page->setCurrentPage(1);

        $this->assertTrue($page->isFirst() && !$page->isLast());
    }

    public function testIsNotFirstAndIsLast()
    {
        $page = new Page();
        $page->setElementCount(3);
        $page->setElementsPerPage(1);

        $page->setCurrentPage(3);

        $this->assertTrue(!$page->isFirst() && $page->isLast());
    }

    public function testIsNotFirstNorLast()
    {
        $page = new Page();
        $page->setElementCount(3);
        $page->setElementsPerPage(1);

        $page->setCurrentPage(2);

        $this->assertTrue(!$page->isFirst() && !$page->isLast());
    }
}