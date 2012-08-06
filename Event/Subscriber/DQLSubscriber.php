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

use Doctrine\ORM\Query;
use KG\Bundle\PagerBundle\PagerEvents;
use KG\Bundle\PagerBundle\Event\PagerEvent;
use KG\Bundle\PagerBundle\Result\Provider\DQLProvider;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Subscriber for paging DQL queries.
 *
 * You should be very careful with trying to page queries with a GROUP BY
 * clause: as the counting query replaces select expressions which could
 * potentially cause the query to return several rows instead of a single one.
 * Consider manually setting the count query to be 100% sure instead.
 *
 * @author Kristen Gilden <gilden@planet.ee>
 */
class DQLSubscriber implements EventSubscriberInterface
{
    /**
     * {@inheritDoc}
     */
    static public function getSubscribedEvents()
    {
        return array(
            PagerEvents::PAGINATE => array('onDQLPaginate', 0),
        );
    }

    /**
     * @param PagerEvent $event
     */
    public function onDQLPaginate(PagerEvent $event)
    {
        if (!$event->getTarget() instanceof Query) {
            return;
        }

        $event->setProvider(new DQLProvider($event->getTarget()));
    }
}