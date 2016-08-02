<?php

namespace KG\Bundle\PlanBundle\Tests\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Repository\RepositoryFactory;
use KG\Bundle\PagerBundle\Doctrine\PagerAwareInterface;
use KG\Bundle\PagerBundle\Doctrine\PagerAwareRepositoryFactory;
use KG\Pager\PagerInterface;

class PagerAwareRepositoryFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testPagerSetToPagerAwareRepositories()
    {
        $pager = $this->createMock(PagerInterface::class);

        $em = $this->createMock(EntityManagerInterface::class);

        $repository = $this->createMock(PagerAwareInterface::class);
        $repository
            ->expects($this->once())
            ->method('setPager')
            ->with($this->identicalTo($pager))
        ;

        $parent = $this->createMock(RepositoryFactory::class);
        $parent
            ->expects($this->once())
            ->method('getRepository')
            ->with($this->identicalTo($em), 'foo')
            ->willReturn($repository)
        ;

        $factory = new PagerAwareRepositoryFactory($pager, $parent);
        $factory->getRepository($em, 'foo');
    }

    public function testPagerNotSetToNativeRepositories()
    {
        $pager = $this->createMock(PagerInterface::class);

        $em = $this->createMock(EntityManagerInterface::class);

        $repository = $this->createMock(EntityRepository::class);

        $parent = $this
            ->getMockBuilder(RepositoryFactory::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $parent
            ->expects($this->once())
            ->method('getRepository')
            ->with($this->identicalTo($em), 'foo')
            ->willReturn($repository)
        ;

        $factory = new PagerAwareRepositoryFactory($pager, $parent);
        $factory->getRepository($em, 'foo');
    }
}
