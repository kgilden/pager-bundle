<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden kristen.gilden@gmail.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Tests\Pager\Doctrine;

use Doctrine\DBAL\Query\QueryBuilder;
use KG\Bundle\PagerBundle\Pager\Doctrine\DBALQueryBuilderPager;

/**
 * @author Kristen Gilden <gilden@planet.ee>
 */
class DBALQueryBuilderPagerTest extends \PHPUnit_Framework_TestCase
{
    public function testPaginateReturnsPage()
    {
        $pager = new DBALQueryBuilderPager();
        $qb = $this->getMockQueryBuilder();

        $this->assertInstanceOf('KG\Bundle\PagerBundle\Result\PageInterface', $pager->paginate($qb));
    }

    /**
     * @dataProvider supportedTargetProvider
     */
    public function testSupports($target)
    {
        $pager = new DBALQueryBuilderPager();

        $this->assertTrue($pager->supports($target));
    }

    public function supportedTargetProvider()
    {
        return array(
            array($this->getMockQueryBuilder()),
        );
    }

    /**
     * @dataProvider notSupportedTargetProvider
     */
    public function testNotSupports($target)
    {
        $pager = new DBALQueryBuilderPager();

        $this->assertFalse($pager->supports($target));
    }

    public function notSupportedTargetProvider()
    {
        return array(
            array(new \stdClass()),
            array(true),
            array(0),
            array(null),
            array('foo'),
            array(''),
        );
    }

    /**
     * @return \Doctrine\DBAL\Query\QueryBuilder|PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockQueryBuilder()
    {
        return $this
            ->getMockBuilder('Doctrine\DBAL\Query\QueryBuilder')
            ->disableOriginalConstructor()
            ->getMock()
        ;
    }
}
