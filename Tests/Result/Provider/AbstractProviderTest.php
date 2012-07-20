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

/**
 * @author Kristen Gilden <gilden@planet.ee>
 */
class AbstractProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException LogicException
     */
    public function testNonPositiveCurrentPageThrowsException()
    {
        $this->getMockProvider()->setCurrentPage(-1);
    }

    /**
     * @expectedException LogicException
     */
    public function testNonPositiveRecrodsPerPageThrowsException()
    {
        $this->getMockProvider()->setRecordsPerPage(-1);
    }

    /**
     * @expectedException KG\Bundle\PagerBundle\Exception\QueryNotSupportedException
     */
    public function testNotSupportedQueryThrowsException()
    {
        $provider = $this->getMockProvider();
        $provider
            ->expects($this->once())
            ->method('supports')
            ->will($this->returnValue(false))
        ;

        $provider->getPageResult(null);
    }

    /**
     * @dataProvider pageResultCalculationsProvider
     */
    public function testGetPageResultCalculations($currentPage, $recordsPerPage, $offset, $resultCount, $pageCount)
    {
        $provider = $this->getMockProvider();
        $provider->setCurrentPage($currentPage);
        $provider->setRecordsPerPage($recordsPerPage);
        $provider
            ->expects($this->once())
            ->method('supports')
            ->will($this->returnValue(true))
        ;

        $provider
            ->expects($this->once())
            ->method('getTotalRecords')
            ->will($this->returnValue($resultCount))
        ;

        $provider
            ->expects($this->once())
            ->method('getRecords')
            ->with(null, $offset, $recordsPerPage)
            ->will($this->returnValue(array()))
        ;

        $provider->getPageResult(null);
    }

    public function pageResultCalculationsProvider()
    {
        return array(
            array( 1, 10,  0, 95, 10),
            array( 1,  1,  0,  0,  0),
            array( 3,  5, 10, 13,  3),
        );
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockProvider()
    {
        return $this
            ->getMockBuilder('KG\\Bundle\\PagerBundle\\Result\\Provider\\AbstractProvider')
            ->getMockForAbstractClass()
        ;
    }
}
