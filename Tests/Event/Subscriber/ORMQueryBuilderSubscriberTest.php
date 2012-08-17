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

use KG\Bundle\PagerBundle\Event\Subscriber\ORMQueryBuilderSubscriber;

/**
 * @author Kristen Gilden <gilden@planet.ee>
 */
class ORMQueryBuilderSubscriberTest extends SubscriberTestCase
{
    protected function setUp()
    {
        $this->subscriber = new ORMQueryBuilderSubscriber();
    }

    public function testOnQbPaginateReturnsProviderInterface()
    {
        $this->markTestSkipped('Cannot mock Doctrine\\ORM\\Query');

        $builder = $this->getMockQueryBuilder();

        // @todo Figure out a clean solution to mock Query
        //
        // $builder
        //     ->expects($this->once())
        //     ->method('getQuery')
        //     ->will($this->returnValue())
        // ;

        $event = $this->getMockPagerEventForPaginate($builder);

        $this->subscriber->onQBPaginate($event);
    }

    public function testOnQBPaginateReturnsVoid()
    {
        $event = $this->getMockPagerEventForPaginateReturnsVoid();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockQueryBuilder()
    {
        return $this
            ->getMockBuilder('Doctrine\\ORM\\QueryBuilder')
            ->disableOriginalConstructor()
            ->getMock()
        ;
    }
}