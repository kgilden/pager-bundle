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

use KG\Bundle\PagerBundle\Result\Helper\ElementCallback;

/**
 * @author Kristen Gilden <kristen.gilden@gmail.com>
 */
class ElementCallbackTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider callableProvider
     */
    public function testConstructorSucceedsIfArgumentCallable($callable)
    {
        new ElementCallback($callable);
    }

    public function callableProvider()
    {
        return array(
            array(array($this, 'myCallback')),
            array(function($element) { return $element; }),
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider notCallableProvider
     */
    public function testConstructorFailsIfArgumentNotCallable($notCallable)
    {
        new ElementCallback($notCallable);
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

    public function testCallbackAppliedOncePerSet()
    {
        $count    = 0;
        $callback = new ElementCallback(function ($elements) use (&$count) {
            $count++;

            return $elements;
        });

        $callback->apply(array('foo', 'bar', 'baz'));

        $this->assertEquals(3, $count);
    }

    public function myCallback($element)
    {
        return $element;
    }
}
