<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden gilden@planet.ee
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Tests\Result\Provider;

use KG\Bundle\PagerBundle\Result\Provider\DBALQueryBuilderProvider;

/**
 * @author Kristen Gilden <gilden@planet.ee>
 */
class DBALQueryBuilderProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * If the query builder does not return an instance of Statement,
     * the method should throw an exception.
     *
     * @expectedException KG\Bundle\PagerBundle\Exception\UnexpectedTypeException
     */
    public function testElementCountThrowsException()
    {
        $provider = new DBALQueryBuilderProvider($this->getMockQueryBuilder());
        $provider->getElementCount();
    }

    public function testElementCount()
    {
        $elementCount = 10;

        $stmt = $this->getMockStatement();
        $stmt
            ->expects($this->once())
            ->method('fetchColumn')
            ->will($this->returnValue($elementCount))
        ;

        $qb = $this->getMockQueryBuilder();
        $qb
            ->expects($this->once())
            ->method('execute')
            ->will($this->returnValue($stmt))
        ;

        $provider = new DBALQueryBuilderProvider($qb);
        $this->assertEquals($elementCount, $provider->getElementCount());
    }

    /**
     * If the query builder does not return an instance of Statement,
     * the method should throw an exception.
     *
     * @expectedException KG\Bundle\PagerBundle\Exception\UnexpectedTypeException
     */
    public function testGetElementsThrowsException()
    {
        $provider = new DBALQueryBuilderProvider($this->getMockQueryBuilder());
        $provider->getElements(0, 10);
    }

    public function testGetElements()
    {
        $stmt = $this->getMockStatement();
        $stmt
            ->expects($this->once())
            ->method('fetchAll')
        ;

        $qb = $this->getMockQueryBuilder();
        $qb
            ->expects($this->once())
            ->method('execute')
            ->will($this->returnValue($stmt))
        ;

        $provider = new DBALQueryBuilderProvider($qb);
        $provider->getElements(0, 10);
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

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockStatement()
    {
        return $this
            ->getMockBuilder('Doctrine\\DBAL\\Statement')
            ->disableOriginalConstructor()
            ->getMock()
        ;
    }
}