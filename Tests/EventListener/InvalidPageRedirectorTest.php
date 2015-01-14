<?php

namespace KG\Bundle\PagerBundle\Tests\EventListener;

use KG\Bundle\PagerBundle\EventListener\InvalidPageRedirector;
use KG\Bundle\PagerBundle\Exception\InvalidPageException;
use Symfony\Component\HttpFoundation\Request;

class InvalidPageRedirectorTest extends \PHPUnit_Framework_TestCase
{
    public function testNotRedirectsIfInvalidException()
    {
        $event = $this->getMockEvent();
        $event->method('getException')->willReturn(new \Exception());

        $redirector = new InvalidPageRedirector();

        $this->assertNull($redirector->onKernelException($event));
    }

    /**
     * @dataProvider getTestData
     */
    public function testRedirection($currentPage, $pageCount, $expectedPage)
    {
        $request = Request::create('http://example.com/?a=2&page=' . $currentPage);

        $event = $this->getMockEvent();
        $event->method('getRequest')->willReturn($request);
        $event->method('getException')->willReturn(new InvalidPageException($currentPage, $pageCount));

        $redirector = new InvalidPageRedirector();

        $response = $redirector->onKernelException($event);

        if (is_null($expectedPage)) {
            $this->assertNull($response);
        } else {
            $this->assertEquals('http://example.com/?a=2&page='.$expectedPage, $response->getTargetUrl());
        }
    }

    public function getTestData()
    {
        return array(
            array(3, 2, 2), // redirect to last page, if current page higher
            array(0, 2, 1), // redirect to first page, if current page is not positive
            array(2, 0, null), // don't redirect, if no pages exist
            array(2, 4, null), // don't redirect, if the current page is inside the page range
        );
    }

    private function getMockEvent()
    {
        return $this
            ->getMockBuilder('Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent')
            ->disableOriginalConstructor()
            ->getMock()
        ;
    }
}
