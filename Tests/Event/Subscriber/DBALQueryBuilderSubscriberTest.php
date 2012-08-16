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

use KG\Bundle\PagerBundle\Event\Subscriber\DBALQueryBuilderSubscriber;

/**
 * @author Kristen Gilden <gilden@planet.ee>
 */
class DBALQueryBuilderSubscriberTest extends SubscriberTestCase
{
    protected function setUp()
    {
        $this->subscriber = new DBALQueryBuilderSubscriber();
    }

    public function testOnQBPaginateReturnsProviderInterface()
    {
        $event = $this->getMockPagerEvent();
        $event
            ->expects($this->once())
            ->method('getTarget')
            ->will($this->returnValue($this->getMockQueryBuilder()))
        ;

        $event
            ->expects($this->once())
            ->method('setProvider')
            ->with($this->getProviderInterfaceConstraint())
        ;

        $this->subscriber->onQBPaginate($event);
    }

    public function testOnQBPaginateReturnsVoid()
    {
        $event = $this->getMockPagerEvent();

        $event
            ->expects($this->never())
            ->method('setProvider')
        ;

        $this->subscriber->onQBPaginate($event);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockQueryBuilder()
    {
        return $this
            ->getMockBuilder('Doctrine\\DBAL\\Query\\QueryBuilder')
            ->disableOriginalConstructor()
            ->getMock()
        ;
    }
}