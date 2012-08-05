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

use KG\Bundle\PagerBundle\Result\AbstractPage;

class AbstractPageTest extends \PHPUnit_Framework_TestCase
{
    public function testAssignment()
    {
        $page = $this->getAbstractPage();
        $page[0] = 'foo';

        $this->assertEquals('foo', $page[0]);

        return $page;
    }

    /**
     * @depends testAssignment
     */
    public function testAll(AbstractPage $page)
    {
        $this->assertEquals(array('foo'), $page->all());
    }

    public function testEmptyOffsetAppendsElement()
    {
        $page = $this->getAbstractPage();
        $page[]  = 'bar';

        $this->assertEquals('bar', $page[0]);
    }

    /**
     * @depends testAssignment
     */
    public function testOffsetIsset(AbstractPage $page)
    {
        $this->assertTrue(isset($page[0]));
    }

    /**
     * @depends testAssignment
     */
    public function testOffsetNotSet(AbstractPage $page)
    {
        $this->assertFalse(isset($page[1]));
    }

    /**
     * @depends testAssignment
     */
    public function testCount(AbstractPage $page)
    {
        $page[1] = 'bar';

        $this->assertEquals(2, $page->count());
    }

    /**
     * @depends testAssignment
     */
    public function testOffsetUnset(AbstractPage $page)
    {
        unset($page[1]);

        $this->assertFalse(isset($page[1]));
    }

    /**
     * @depends testEmptyOffsetAppendsElement
     */
    public function testIterator()
    {
        $expected = array('foo', 'bar');

        $page   = $this->getAbstractPage();
        $page[] = 'foo';
        $page[] = 'bar';

        foreach ($page as $key => $val) {
            $this->assertEquals($expected[$key], $val);
        }
    }

    public function getAbstractPage()
    {
        return $this
            ->getMockBuilder('KG\\Bundle\\PagerBundle\\Result\\AbstractPage')
            ->getMockForAbstractClass();
    }
}