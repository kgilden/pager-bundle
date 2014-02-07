<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden kristen.gilden@gmail.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Tests\Result\Helper;

use KG\Bundle\PagerBundle\Result\Helper\PageCallback;

/**
 * @author Kristen Gilden <kristen.gilden@gmail.com>
 */
class PageCallbackTest extends \PHPUnit_Framework_TestCase
{
   /**
     * @dataProvider callableProvider
     */
    public function testConstructorSucceedsIfArgumentCallable($callable)
    {
        new PageCallback($callable);
    }

    public function callableProvider()
    {
        return array(
            array(array($this, 'myCallback')),
            array(function ($elements) { return $elements; }),
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider notCallableProvider
     */
    public function testConstructorFailsIfArgumentNotCallable($notCallable)
    {
        new PageCallback($notCallable);
    }

    public function notCallableProvider()
    {
        return array(
            array(42),
            array(null),
            array(new \stdClass()),
            array(false),
        );
    }

    public function testCallbackAppliedOncePerElement()
    {
        $count    = 0;
        $callback = new PageCallback(function ($element) use (&$count) {
            $count++;

            return $element;
        });

        $callback->apply(array('foo', 'bar', 'baz'));

        $this->assertEquals(1, $count);
    }

    /**
     * @expectedException KG\Bundle\PagerBundle\Exception\UnexpectedTypeException
     * @dataProvider incorrectResultProvider
     * @param mixed $retval
     */
    public function testApplyFailsIfCallbackNotReturnsArray($retval)
    {
        $callback = new PageCallback(function (array $elements) use ($retval) {
            return $retval;
        });

        $callback->apply(array('foo', 'bar'));
    }

    public function incorrectResultProvider()
    {
        return array(
            array(null),
            array(false),
            array(42),
            array('42'),
        );
    }

    public function myCallback(array $elements)
    {
        return $elements;
    }
}
