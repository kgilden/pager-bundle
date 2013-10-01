<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden kristen.gilden@gmail.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Tests\Result\Provider;

use KG\Bundle\PagerBundle\Result\Provider\DBALQueryBuilderProvider;
use KG\Bundle\PagerBundle\Tests\Stub\Query;

/**
 * @author Kristen Gilden <kristen.gilden@gmail.com>
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
     * @expectedException Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    public function testGetElementsEntityManagerTypeException()
    {
        $provider = new DBALQueryBuilderProvider($this->getMockQueryBuilder(), array(
            'entity_manager'     => new \stdClass(),
            'result_set_mapping' => $this->getMockResultSetMapping(),
        ));
        $provider->getElements(0, 10);
    }

    /**
     * @expectedException Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    public function testGetElementsRSMTypeException()
    {
        $provider = new DBALQueryBuilderProvider($this->getMockQueryBuilder(), array(
            'entity_manager'     => $this->getMockEntityManager(),
            'result_set_mapping' => new \stdClass(),
        ));
        $provider->getElements(0, 10);
    }

    public function testNativeQueryGetElements()
    {
        $qb = $this->getMockQueryBuilder();
        $qb
            ->expects($this->any())
            ->method('getParameters')
            ->will($this->returnValue(array()))
        ;

        $em = $this->getMockEntityManager();

        // @todo Use mock AbstractQuery
        $em
            ->expects($this->once())
            ->method('createNativeQuery')
            ->will($this->returnValue(new Query($em)))
        ;

        $provider = new DBALQueryBuilderProvider($qb, array(
            'entity_manager'     => $em,
            'result_set_mapping' => $this->getMockResultSetMapping(),
        ));
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

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockEntityManager()
    {
        return $this
            ->getMockBuilder('Doctrine\\ORM\\EntityManager')
            ->disableOriginalConstructor()
            ->getMock()
        ;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockAbstractQuery()
    {
        return $this
            ->getMockBuilder('Doctrine\\ORM\\AbstractQuery')
            ->disableOriginalConstructor()
            ->setMethods(array('execute'))
            ->getMockForAbstractClass();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockResultSetMapping()
    {
        return $this->getMock('Doctrine\\ORM\\Query\\ResultSetMapping');
    }
}