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

use KG\Bundle\PagerBundle\Pager\Pager;

/**
 * @author Kristen Gilden <kristen.gilden@gmail.com>
 */
class PagerTest extends \PHPUnit_Framework_TestCase
{
    const CLASS_PAGE     = 'KG\\Bundle\\PagerBundle\\Result\\PageInterface';
    const CLASS_PAGER    = 'KG\\Bundle\\PagerBundle\\Pager\\Pager';
    const CLASS_PROVIDER = 'KG\\Bundle\\PagerBundle\\Result\\Provider\\ProviderInterface';

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|Pager
     */
    protected $pager;

    protected function setUp()
    {
        $this->pager = $this->getMockForAbstractClass(self::CLASS_PAGER);
    }

    protected function tearDown()
    {
        unset($this->pager);
    }

    /**
     * @expectedException KG\Bundle\PagerBundle\Exception\TargetNotSupportedException
     */
    public function testPaginateThrowsTargetNotSupportedException()
    {
        $this->pager
            ->expects($this->once())
            ->method('supports')
            ->will($this->returnValue(false))
        ;

        $this->pager->paginate('foo');
    }

    public function testPaginateReturnsPage()
    {
        $this->pager
            ->expects($this->once())
            ->method('supports')
            ->will($this->returnValue(true))
        ;

        $this->pager
            ->expects($this->once())
            ->method('getProvider')
            ->will($this->returnValue($this->getMock(self::CLASS_PROVIDER)))
        ;

        $page = $this->pager->paginate('foo');

        $this->assertInstanceOf(self::CLASS_PAGE, $page);
    }
}