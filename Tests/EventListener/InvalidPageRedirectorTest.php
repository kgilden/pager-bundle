<?php

namespace KG\Bundle\PagerBundle\Tests\EventListener;

use KG\Bundle\PagerBundle\EventListener\InvalidPageRedirector;
use KG\Pager\Exception\InvalidPageException;
use Symfony\Component\HttpFoundation\Request;

class InvalidPageRedirectorTest extends \PHPUnit_Framework_TestCase
{
    public function testNotRedirectsIfInvalidException()
    {
        $event = $this->getMockEvent();
        $event->method('getException')->willReturn(new \Exception());
        $event->expects($this->never())->method('setResponse');

        $redirector = new InvalidPageRedirector();
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

        if (is_null($expectedPage)) {
            $event
                ->expects($this->never())
                ->method('setResponse')
            ;
        } else {
            $testCase = $this;

            $event
                ->expects($this->once())
                ->method('setResponse')
                ->will($this->returnCallback(function ($response) use ($testCase, $expectedPage) {
                    $testCase->assertEquals('http://example.com/?a=2&page='.$expectedPage, $response->getTargetUrl());
                }))
            ;
        }

        $redirector = new InvalidPageRedirector();
        $redirector->onKernelException($event);
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
