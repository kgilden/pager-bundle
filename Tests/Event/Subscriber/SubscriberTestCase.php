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
        return $this
            ->getMockBuilder('KG\\Bundle\\PagerBundle\\Event\\PagerEvent')
            ->disableOriginalConstructor()
            ->getMock()
        ;
    }
}