<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden gilden@planet.ee
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Result\Provider;

use Doctrine\ORM\Query;

/**
 * Doctrine DQL provider for paging DQL queries. Uses the cookbook example
 * found at http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/cookbook/dql-custom-walkers.html#extending-dql-in-doctrine-2-custom-ast-walkers
 *
 * Note that this only works if your entity has only one identifier field
 * (composite keys won’t work).
 *
 * @author Kristen Gilden <gilden@planet.ee>
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
     * @param Query $query
     */
    public function __construct(Query $query)
    {
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