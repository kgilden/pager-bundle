<?php

namespace KG\Bundle\PagerBundle\EventListener;

use KG\Bundle\PagerBundle\Exception\InvalidPageException;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Redirects to the nearest existing page, if the current page is out of range.
 */
final class InvalidPageRedirector
{
    /**
     * @var string
     */
    private $pageKey;

    /**
     * @param string $pageKey The query string key to set the new page number
     */
    public function __construct($pageKey = 'page')
    {
        $this->pageKey = $pageKey;
    }

    /**
     * @param GetResponseForExceptionEvent $event
     *
     * @return RedirectResponse|null
     *
     * @throws \LogicException If the current page is inside the page range
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if (!$exception instanceof InvalidPageException) {
            return;
        }

        $currentPage = $exception->getCurrentPage();
        $pageCount = $exception->getPageCount();

        if ($pageCount < 1) {
            return; // No pages...so let the exception fall through.
        }

        $queryBag = clone $event->getRequest()->query;

        if ($currentPage > $pageCount) {
            $queryBag->set($this->pageKey, $pageCount);
        } elseif ($currentPage < 1) {
            $queryBag->set($this->pageKey, 1);
        } else {
            return; // Super weird, because current page is within the bounds, fall through.
        }

        if (null !== $qs = http_build_query($queryBag->all(), '', '&')) {
            $qs = '?'.$qs;
        }

        // Create identical uri except for the page key in the query string which
        // was changed by this listener.
        //
        // @see Symfony\Component\HttpFoundation\Request::getUri()
        $request = $event->getRequest();
        $uri = $request->getSchemeAndHttpHost().$request->getBaseUrl().$request->getPathInfo().$qs;

        return new RedirectResponse($uri);
    }
}
