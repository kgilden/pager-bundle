<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden kristen.gilden@gmail.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Result\Provider;

use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Doctrine DQL provider for paging DQL queries. Takes advantage of the
 * Doctrine Paginator (http://docs.doctrine-project.org/en/latest/tutorials/pagination.html).
 *
 * @author Kristen Gilden <kristen.gilden@gmail.com>
 */
class DQLProvider implements ProviderInterface
{
    /**
     * @var integeger
     */
    protected $elementCount;

    /**
     * @var Paginator
     */
    protected $paginator;

    /**
     * @var Query
     */
    protected $query;

    /**
     * @param Query $query A doctrine ORM query
     *
     * @throws UnexpectedTypeException if the passsed query type is incorrect
     */
    public function __construct(Query $query)
    {
        $this->paginator = new Paginator($query);
        $this->query = $query;
    }

    /**
     * {@inheritDoc}
     */
    public function getElementCount()
    {
        if (!isset($this->elementCount)) {
            $this->elementCount = $this->paginator->count();
        }

        return $this->elementCount;
    }

    /**
     * {@inheritDoc}
     */
    public function getElements($offset, $count)
    {
        $this->query
            ->setFirstResult($offset)
            ->setMaxResults($count)
        ;

        return iterator_to_array($this->paginator->getIterator());
    }
}
