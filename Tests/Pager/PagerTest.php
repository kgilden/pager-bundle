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

use KG\Bundle\PagerBundle\Event\PagerEvent;
use KG\Bundle\PagerBundle\PagerEvents;
use KG\Bundle\PagerBundle\Pager\Pager;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @author Kristen Gilden <gilden@planet.ee>
 */
class PagerTest extends \PHPUnit_Framework_TestCase implements EventSubscriberInterface
{
    /**
     * @var Pager
     */
    protected $pager;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $dispatcher;

    protected function setUp()
    {
        $this->dispatcher = $this->getMock('Symfony\\Component\\EventDispatcher\\EventDispatcherInterface');
        $this->pager      = new Pager($this->dispatcher);
    }

    protected function tearDown()
    {
        unset($this->pager);
        unset($this->dispatcher);
    }

    public function testPaginateDispatchesPagerEvent()
    {
        $constraint = new \PHPUnit_Framework_Constraint_IsInstanceOf(
            'KG\\Bundle\\PagerBundle\\Event\\PagerEvent'
        );

        $this
            ->dispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->with(PagerEvents::PAGINATE, $constraint)
        ;

        try {
            $this->pager->paginate('foo');
        } catch (\Exception $e) {

        }
    }

    /**
     * @expectedException KG\Bundle\PagerBundle\Exception\ProviderNotFoundException
     */
    public function testPaginatePropagationNotStoppedThrowsException()
    {
        $this->pager->paginate('foo');
    }

    public function testPaginateReturnsPageInterface()
    {
        // Unfortunately the real EventDispatcher must be used in order
        // to actually stop the propagation in the event.
        $dispatcher = new EventDispatcher();
        $dispatcher->addSubscriber($this);

        $pager = new Pager($dispatcher);
        $page  = $pager->paginate('foo');

        $this->assertInstanceOf('KG\Bundle\PagerBundle\Result\PageInterface', $page);
    }

    public static function getSubscribedEvents()
    {
        return array(
            PagerEvents::PAGINATE => array('onPaginate', 0),
        );
    }

    public function onPaginate(PagerEvent $event)
    {
        $event->setProvider($this->getMock('KG\\Bundle\\PagerBundle\\Result\\Provider\\ProviderInterface'));
    }
}