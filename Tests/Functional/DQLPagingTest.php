<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden kristen.gilden@gmail.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Tests\Functional;

use KG\Bundle\PagerBundle\Pager\GenericPager;
use KG\Bundle\PagerBundle\Test\DoctrineTestCase;
use KG\Bundle\PagerBundle\Test\Entity\Entity;
use KG\Bundle\PagerBUndle\Test\Entity\Related;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @author Kristen Gilden <gilden@planet.ee>
 */
class DQLPagingTest extends DoctrineTestCase
{
    protected function setUp()
    {
        parent::setUp();

        $em = $this->getEntityManager();

        for ($i = 0; $i < 20; $i++) {
            $entity = new Entity();

            for ($j = 0; $j < 3; $j++) {
                $related = new Related();
                $related->setEntity($entity);
            }

            $em->persist($entity);
        }

        $em->flush();
    }

    public function testSimplePaging()
    {
        $query = $this
            ->getEntityManager()
            ->createQuery('SELECT e FROM KG\Bundle\PagerBundle\Test\Entity\Entity e')
        ;

        $pager = $this->createDQLPager();

        $entities = $pager->paginate($query);
        $entities->setElementsPerPage(5);
        $entities->setCurrentPage(1);

        $this->assertCount(5, $entities);
    }

    public function testPagingWithJoin()
    {
        $query = $this
            ->getEntityManager()
            ->createQuery('SELECT e, r FROM KG\Bundle\PagerBundle\Test\Entity\Entity e LEFT JOIN e.related r');

        $pager = $this->createDQLPager();

        $entities = $pager->paginate($query);
        $entities->setElementsPerPage(5);
        $entities->setCurrentPage(1);

        $this->assertCount(5, $entities);
    }

    /**
     * @return \KG\Bundle\PagerBundle\Pager\PagerInterface
     */
    private function createDQLPager()
    {
        return new GenericPager(
            'KG\Bundle\PagerBundle\Result\Provider\DQLProvider',
            'Doctrine\ORM\Query'
        );
    }
}