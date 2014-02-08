<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden kristen.gilden@gmail.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Tests\Pager;

use KG\Bundle\PagerBundle\Pager\Doctrine\ORMPager;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * @author Kristen Gilden <gilden@planet.ee>
 */
class ORMPagerTest extends \PHPUnit_Framework_TestCase
{
    public function testPaginateReturnsPage()
    {
        $pager = new ORMPager();
        $query = new Query($this->getMockEntityManager());

        $this->assertInstanceOf('KG\Bundle\PagerBundle\Result\PageInterface', $pager->paginate($query));
    }

    /**
     * @dataProvider supportedTargetProvider
     */
    public function testSupports($target)
    {
        $pager = new ORMPager();

        $this->assertTrue($pager->supports($target));
    }

    public function supportedTargetProvider()
    {
        return array(
            array(new Query($this->getMockEntityManager())),
            array(new QueryBuilder($this->getMockEntityManager())),
        );
    }

    /**
     * @dataProvider notSupportedTargetProvider
     */
    public function testNotSupports($target)
    {
        $pager = new ORMPager();

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
     * @return \Doctrine\ORM\EntityManager|PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockEntityManager()
    {
        return $this
            ->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock()
        ;
    }
}
