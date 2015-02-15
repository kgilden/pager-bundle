<?php

namespace KG\Bundle\PagerBundle\Tests\Provider;

use KG\Bundle\PagerBundle\Result\Provider\FOSElasticaProvider;

class FOSElasticaProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testElementCountDelegatedToAdapter()
    {
        $adapter = $this->getMockAdapter();
        $adapter
            ->expects($this->once())
            ->method('getTotalHits')
            ->willReturn(42)
        ;

        $provider = new FOSElasticaProvider($adapter);

        $this->assertEquals(42, $provider->getElementCount());
    }

    public function getGetElementsDelegatedToAdapter()
    {
        $results = $this->getMockPartialResults();
        $results
            ->expects($this->once())
            ->method('toArray')
            ->willReturn($expected = array('foo', 'bar'))
        ;

        $adapter = $this->getMockAdapter();
        $adapter
            ->expects($this->once())
            ->method('getElements')
            ->with($this->equalTo(2), $this->equalTo(4))
            ->willReturn($results)
        ;

        $provider = new FOSElasticaProvider($adapter);

        $this->assertEquals($expected, $provider->getElements(2, 4));
    }

    private function getMockAdapter()
    {
        return $this->getMock('FOS\ElasticaBundle\Paginator\PaginatorAdapterInterface');
    }

    private function getMockPartialResults()
    {
        return $this->getMock('FOS\ElasticaBundle\Paginator\PartialResultsInterface');
    }
}
