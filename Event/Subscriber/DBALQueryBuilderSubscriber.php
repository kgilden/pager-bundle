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

use Doctrine\DBAL\Query\QueryBuilder;
use KG\Bundle\PagerBundle\Event\PagerEvent;
use KG\Bundle\PagerBundle\PagerEvents;
use KG\Bundle\PagerBundle\Result\Provider\DBALQueryBuilderProvider;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @author Kristen Gilden <gilden@planet.ee>
 */
class DBALQueryBuilderSubscriber implements EventSubscriberInterface
{
    /**
     * {@inheritDoc}
     */
    static public function getSubscribedEvents()
    {
        return array(
            PagerEvents::PAGINATE => array('onQBPaginate', 0),
        );
    }

    /**
     * @param PagerEvent $event
     */
    public function onQBPaginate(PagerEvent $event)
    {
        $target = $event->getTarget();

        if (!$target instanceof QueryBuilder) {
            return;
        }

        $event->setProvider(new DBALQueryBuilderProvider($target));
    }
}