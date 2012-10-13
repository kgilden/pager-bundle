<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden gilden@planet.ee
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Tests\Pager;

use KG\Bundle\PagerBundle\Pager\Pager;

/**
 * @author Kristen Gilden <gilden@planet.ee>
 */
class PagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Pager
     */
    protected $pager;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $factory;

    protected function setUp()
    {
        $this->factory = $this->getMock('KG\\Bundle\\PagerBundle\\Result\\Provider\\FactoryInterface');
        $this->pager   = new Pager(array($this->factory));
    }

    protected function tearDown()
    {
        unset($this->pager);
        unset($this->factory);
    }

    /**
     * @expectedException KG\Bundle\PagerBundle\Exception\ProviderNotFoundException
     */
    public function testPaginateFactoryMissingThrowsException()
    {
        $this->pager->paginate('foo');
    }

    public function testPaginateReturnsPage()
    {
        $this->factory
            ->expects($this->once())
            ->method('supports')
            ->will($this->returnValue(true))
        ;

        $provider = $this->getMock('KG\\Bundle\\PagerBundle\\Result\\Provider\\ProviderInterface');

        $this->factory
            ->expects($this->once())
            ->method('get')
            ->will($this->returnValue($provider))
        ;

        $page = $this->pager->paginate('foo');

        $this->assertInstanceOf('KG\Bundle\PagerBundle\Result\PageInterface', $page);
    }
}