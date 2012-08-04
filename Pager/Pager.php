<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden gilden@planet.ee
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Pager;

use KG\Bundle\PagerBundle\Event\PagerEvent;
use KG\Bundle\PagerBundle\Exception\ProviderNotFoundException;
use KG\Bundle\PagerBundle\PagerEvents;
use KG\Bundle\PagerBundle\Result\LazyPage;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Uses event dispatching to create a paged result
 *
 * @author Kristen Gilden <gilden@planet.ee>
 */
class Pager implements PagerInterface
{
    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * {@inheritDoc}
     */
    public function paginate($target)
    {
        $event = new PagerEvent($target);

        $this->dispatcher->dispatch(PagerEvents::PAGINATE, $event);

        if (true !== $event->isPropagationStopped()) {
            throw new ProviderNotFoundException($target);
        }

        $page = new LazyPage($event->getProvider());

        return $page;
    }
}