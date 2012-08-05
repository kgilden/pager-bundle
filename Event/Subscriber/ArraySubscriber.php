<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden gilden@planet.ee
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Event\Subscriber;

use KG\Bundle\PagerBundle\PagerEvents;
use KG\Bundle\PagerBundle\Event\PagerEvent;
use KG\Bundle\PagerBundle\Result\Provider\ArrayProvider;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Subscriber for paging arrays
 *
 * @author Kristen Gilden <gilden@planet.ee>
 */
class ArraySubscriber implements EventSubscriberInterface
{
    /**
     * {@inheritDoc}
     */
    static public function getSubscribedEvents()
    {
        return array(
            PagerEvents::PAGINATE => array('onArrayPaginate', 0),
        );
    }

    /**
     * @param PagerEvent $event
     */
    public function onArrayPaginate(PagerEvent $event)
    {
        if (!is_array($event->getTarget())) {
            return;
        }

        $event->setProvider(new ArrayProvider($event->getTarget()));
    }
}