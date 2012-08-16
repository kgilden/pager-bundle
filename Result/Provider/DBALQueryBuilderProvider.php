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

use KG\Bundle\PagerBundle\Exception\UnexpectedTypeException;
use Doctrine\DBAL\Driver\Statement;
use Doctrine\DBAL\Query\QueryBuilder;
use PDO;

/**
 * @author Kristen Gilden <gilden@planet.ee>
 */
class DBALQueryBuilderProvider implements ProviderInterface
{
    /**
     * @var QueryBuilder
     */
    protected $qb;

    /**
     * @var integer
     */
    protected $elementCount;

    /**
     * @param QueryBuilder $qb
     */
    public function __construct(QueryBuilder $qb)
    {
        $this->qb = $qb;
    }

    /**
     * {@inheritDoc}
     */
    public function getElementCount()
    {
        if (!isset($this->elementCount)) {
            // The count query is constructed by cloning the query builder
            // and replacing the select expression. Careful, Innodb is
            // notoriously slow with this method

            $qb = clone $this->qb;
            $qb->select('COUNT(*)');

            $stmt = $qb->execute();

            if (!$stmt instanceof Statement) {
                throw new UnexpectedTypeException($stmt, 'Doctrine\\DBAL\\Driver\\Statement');
            }

            $this->elementCount = $stmt->fetchColumn();
        }

        return $this->elementCount;
    }

    /**
     * {@inheritDoc}
     */
    public function getElements($offset, $count)
    {
        $this->qb->setFirstResult($offset);
        $this->qb->setMaxResults($count);

        $stmt = $this->qb->execute();

        if (!$stmt instanceof Statement) {
            throw new UnexpectedTypeException($stmt, 'Doctrine\\DBAL\\Driver\\Statement');
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}