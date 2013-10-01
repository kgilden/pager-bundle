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

use KG\Bundle\PagerBundle\Exception\UnexpectedTypeException;
use KG\Bundle\PagerBundle\Options\OptionsAware;
use Doctrine\DBAL\Driver\Statement;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\ResultSetMapping;
use PDO;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Kristen Gilden <kristen.gilden@gmail.com>
 */
class DBALQueryBuilderProvider extends OptionsAware implements ProviderInterface
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
     * @param array        $options
     */
    public function __construct(QueryBuilder $qb, array $options = array())
    {
        parent::__construct($options);

        $this->qb = $qb;
    }

    /**
     * {@inheritDoc}
     */
    public function getElementCount()
    {
        if (!isset($this->elementCount)) {

            $qb = clone $this->qb;
            $qb->select('COUNT(*)');

            if ($this->isComplexQuery($qb)) {
                // Not resetting select as this is already changed.
                $qb->resetQueryParts(array(
                    'from',
                    'join',
                    'set',
                    'where',
                    'groupBy',
                    'having',
                    'orderBy',
                ));

                $subQuery = sprintf('(%s)', $this->qb->getSQL());
                $qb->from($subQuery, 'kg_pager_count_table');
            }

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

        if ($this->options['is_native_query']) {
            $em   = $this->options['entity_manager'];
            $rsm  = $this->options['result_set_mapping'];
            $sql  = $this->qb->getSQL();

            $query = $em->createNativeQuery($sql, $rsm);
            $query->setParameters($this->qb->getParameters());

            return $query->execute();
        } else {
            $stmt = $this->qb->execute();

            if (!$stmt instanceof Statement) {
                throw new UnexpectedTypeException($stmt, 'Doctrine\\DBAL\\Driver\\Statement');
            }

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setOptional(array(
            'result_set_mapping',
            'entity_manager',
        ));

        $resolver->setAllowedTypes(array(
            'result_set_mapping' => 'Doctrine\\ORM\\Query\\ResultSetMapping',
            'entity_manager'     => 'Doctrine\\ORM\\EntityManager',
        ));

        $resolver->setDefaults(array(
            'is_native_query' => function (Options $options) {
                return isset($options['result_set_mapping'], $options['entity_manager']);
            }
        ));
    }

    /**
     * Checks whether the query is too complex for simple SQL part
     * substitution.
     *
     * The query is considered complex if any of the following statements
     * is true:
     *
     *  - it has parameters;
     *  - it is an aggregate query;
     *
     * @param QueryBuilder $qb
     *
     * @return boolean
     */
    private function isComplexQuery(QueryBuilder $qb)
    {
        if (count($qb->getParameters()) > 0) {
            return true;
        }

        if (count($qb->getQueryPart('groupBy')) > 0) {
            return true;
        }

        return false;
    }
}