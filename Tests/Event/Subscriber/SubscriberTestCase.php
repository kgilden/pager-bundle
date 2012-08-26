<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden gilden@planet.ee
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Tests\Event\Subscriber;

/**
 * @author Kristen Gilden <gilden@planet.ee>
 */
abstract class SubscriberTestCase extends \PHPUnit_Framework_TestCase
{
    protected $subscriber;

    /**
     * Constructs the mock PageEvent for the paging test.
     *
     * @param mixed $getTargetValue The value to be returned by PagerEvent::getTarget
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockPagerEventForPaginate($getTargetValue)
    {
        $event = $this->getMockPagerEvent();
        $event
            ->expects($this->once())
            ->method('getTarget')
            ->will($this->returnValue($getTargetValue))
        ;

        $event
            ->expects($this->once())
            ->method('setProvider')
            ->with($this->getProviderInterfaceConstraint())
        ;

        return $event;
    }

    /**
     * Constructs the mock PagerEvent for testing paging returning void.
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockPagerEventForPaginateReturnsVoid()
    {
        $event = $this->getMockPagerEvent();

        $event
            ->expects($this->never())
            ->method('setProvider')
        ;

        return $event;
    }

    /**
     * @return \PHPUnit_Framework_Constraint_IsInstanceOf
     */
    protected function getProviderInterfaceConstraint()
    {
        $class = 'KG\\Bundle\\PagerBundle\\Result\\Provider\\ProviderInterface';

        return new \PHPUnit_Framework_Constraint_IsInstanceOf($class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockPagerEvent()
    {
        $event = $this
            ->getMockBuilder('KG\\Bundle\\PagerBundle\\Event\\PagerEvent')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $event
            ->expects($this->any())
            ->method('getOptions')
            ->will($this->returnValue(array()))
        ;

        return $event;
    }
}