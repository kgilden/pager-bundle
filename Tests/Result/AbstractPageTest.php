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
    /**
     * @expectedException KG\Bundle\PagerBundle\Exception\IllegalMethodException
     */
    public function testAssignmentThrowsException()
    {
        $page = $this->getAbstractPage();
        $page[0] = 'foo';
    }

    /**
     * @expectedException KG\Bundle\PagerBundle\Exception\IllegalMethodException
     */
    public function testUnsettingThrowsException()
    {
        $page = $this->getAbstractPage(array('foo'));
        unset($page[0]);
    }

    public function testOffsetGetReturnsNull()
    {
        $page = $this->getAbstractPage(array());
        $this->assertNull($page[0]);
    }

    public function testAll()
    {
        $expected = array('foo');
        $page     = $this->getAbstractPage($expected);

        $this->assertEquals($expected, $page->all());
    }

    public function testOffsetIsset()
    {
        $page = $this->getAbstractPage(array('foo'));
        $this->assertTrue(isset($page[0]));
    }

    public function testOffsetNotSet()
    {
        $page = $this->getAbstractPage(array('foo'));
        $this->assertFalse(isset($page[1]));
    }

    public function testCount()
    {
        $page = $this->getAbstractPage(array('foo', 'bar'));
        $this->assertEquals(2, $page->count());
    }

    public function testOlderCbsInvokedBeforeNewer()
    {
        $invoked = false;
        $test    = $this;

        $funA = function (array $elements) use (&$invoked) {
            $invoked = true;

            return $elements;
        };

        $funB = function (array $elements) use (&$invoked, $test) {
            $test->assertTrue($invoked);

            return $elements;
        };

        $page = $this->getAbstractPage(array('foo', 'bar'));
        $page->addPageCb($funA);
        $page->addPageCb($funB);

        $page[0];
    }

    public function testElementCbAppliedPerElement()
    {
        $runCount = 0;

        $page = $this->getAbstractPage(array('foo', 'bar'));
        $page->addElementCb(function ($elements) use (&$runCount) {
            $runCount++;

            return $elements;
        });

        $page[0];

        $this->assertEquals(2, $runCount);
    }

    public function testPageCbAppliedOnce()
    {
        $runCount = 0;

        $page = $this->getAbstractPage(array('foo', 'bar'));
        $page->addPageCb(function (array $elements) use (&$runCount) {
            $runCount++;

            return $elements;
        });

        $page[0];
        $page[1];

        $this->assertEquals(1, $runCount);
    }

    /**
     * @expectedException \UnexpectedValueException
     */
    public function testInvalidCbNotReturnsArrayThrowsException()
    {
        $fun = function (array $elements) {
            return null;
        };

        $page = $this->getAbstractPage(array('foo'));
        $page->addPageCb($fun);

        $page[0];
    }

    /**
     * @expectedException KG\Bundle\PagerBundle\Exception\ElementsAccessedException
     */
    public function testAddElementCbAfterAccessThrowsException()
    {
        $page = $this->getAbstractPage(array('foo', 'bar'));
        $page[0];

        $page->addElementCb(function ($element) {
            return $element;
        });
    }

    /**
     * @expectedException KG\Bundle\PagerBundle\Exception\ElementsAccessedException
     */
    public function testAddPageCbAfterAccesThrowsException()
    {
        $page = $this->getAbstractPage(array('foo', 'bar'));
        $page[0];

        $page->addPageCb(function (array $elements) {
            return $elements;
        });
    }

    /**
     * Although AbstractPage uses the protected setter in the constructor,
     * overriding classes might use it multiple times. That's why the test is
     * deviating from unit testing best practises and uses reflection.
     */
    public function testSetNewElementsReappliesCallbacks()
    {
        $page = $this->getAbstractPage();
        $page->addElementCb(function($element) {
            return 'baz';
        });

        $setter = new \ReflectionMethod($page, 'set');
        $setter->setAccessible(true);

        $setter->invoke($page, array('foo'));
        $page[0]; // Access an element to trigger initial callback execution.

        $setter->invoke($page, array('bar'));
        $this->assertEquals('baz', $page[0]);
    }

    /**
     * @return AbstractPage|\PHPUnit_Framework_MockObject_MockObject
     */
    public function getAbstractPage(array $elements = null)
    {
        return $this
            ->getMockBuilder('KG\\Bundle\\PagerBundle\\Result\\AbstractPage')
            ->setConstructorArgs(array($elements))
            ->getMockForAbstractClass();
    }
}