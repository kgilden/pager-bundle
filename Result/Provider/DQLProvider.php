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
use Doctrine\ORM\QueryBuilder;
use KG\Bundle\PagerBundle\Exception\UnexpectedTypeException;

/**
 * Doctrine DQL provider for paging DQL queries. Uses the cookbook example
 * found at http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/cookbook/dql-custom-walkers.html#extending-dql-in-doctrine-2-custom-ast-walkers
 *
 * Note that this only works if your entity has only one identifier field
 * (composite keys won’t work).
 *
 * You should be very careful with trying to page queries with a GROUP BY
 * clause: as the counting query replaces select expressions which could
 * potentially cause the query to return several rows instead of a single one.
 * Consider manually setting the count query to be 100% sure instead.
 *
 * @author Kristen Gilden <kristen.gilden@gmail.com>
 */
class DQLProvider implements ProviderInterface
{
    /**
     * @var Query
     */
    protected $query;

    /**
     * @var integeger
     */
    protected $elementCount;

    /**
     * @param Query|QueryBuilder $query A doctrine ORM query or query builder
     *
     * @throws UnexpectedTypeException if the passsed query type is incorrect
     */
    public function __construct($query)
    {
        if ($query instanceof QueryBuilder) {
            $query = $query->getQuery();
        }

        if (!$query instanceof Query) {
            throw new UnexpectedTypeException($query, 'Doctrine\ORM\Query');
        }

        $this->query = $query;
    }

    /**
     * {@inheritDoc}
     */
    public function getElementCount()
    {
        if (!isset($this->elementCount)) {
            $countQuery = clone $this->query;
            $countQuery->setParameters($this->query->getParameters());
            $countQuery->setHint(Query::HINT_CUSTOM_TREE_WALKERS, array(
                'KG\\Bundle\\PagerBundle\\Doctrine\\CountSQLWalker'
            ));

            // Resets any limit constraints set on the initial query.
            $countQuery
                ->setFirstResult(null)
                ->setMaxResults(null)
            ;

            $this->elementCount = $countQuery->getSingleScalarResult();
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

         return $this->query->getResult();
    }
}
