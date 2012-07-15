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

use KG\Bundle\PagerBundle\Pager\ContainerAwarePager;

class ContainerAwarePagerTest extends \PHPUnit_Framework_TestCase
{
    public function testSupportsReturnsTrue()
    {
        $pager = new ContainerAwarePager(array('stdClass' => 'bar'));
        //$pager->setContainer($container);

        $this->assertTrue($pager->supports(new \stdClass()));
    }

    public function testSupportsReturnsFalse()
    {
        $pager = new ContainerAwarePager();

        $this->assertFalse($pager->supports(new \stdClass()));
    }

    public function testPaginateCallsprovider()
    {
        $provider = $this->getMockProvider();
        $provider
            ->expects($this->once())
            ->method('getPageResult')
        ;

        $container = $this->getMockContainer();
        $container
            ->expects($this->once())
            ->method('get')
            ->with('bar')
            ->will($this->returnValue($provider))
        ;

        $pager = new ContainerAwarePager(array('stdClass' => 'bar'));
        $pager->setContainer($container);
        $pager->paginate(new \stdClass());
    }

    public function testStringCallsSqlprovider()
    {
        $provider = $this->getMockProvider();
        $provider
            ->expects($this->once())
            ->method('getPageResult')
        ;

        $container = $this->getMockContainer();
        $container
            ->expects($this->once())
            ->method('get')
            ->with('bar')
            ->will($this->returnValue($provider));
        ;

        $pager = new ContainerAwarePager(array('sql' => 'bar'));
        $pager->setContainer($container);
        $pager->paginate('SELECT random FROM queries');
    }

    public function testArrayCallsArrayprovider()
    {
        $provider = $this->getMockProvider();
        $provider
            ->expects($this->once())
            ->method('getPageResult')
        ;

        $container = $this->getMockContainer();
        $container
            ->expects($this->once())
            ->method('get')
            ->with('bar')
            ->will($this->returnValue($provider))
        ;

        $pager = new ContainerAwarePager(array('array' => 'bar'));
        $pager->setContainer($container);
        $pager->paginate(array());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockContainer()
    {
        return $this->getMock('Symfony\\Component\\DependencyInjection\\ContainerInterface');
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockProvider()
    {
        return $this->getMock('KG\\Bundle\\PagerBundle\\Result\\Provider\\ProviderInterface');
    }
}
