<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden gilden@planet.ee
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Doctrine;

use Doctrine\ORM\Query\AST\AggregateExpression;
use Doctrine\ORM\Query\AST\PathExpression;
use Doctrine\ORM\Query\AST\SelectExpression;
use Doctrine\ORM\Query\AST\SelectStatement;
use Doctrine\ORM\Query\TreeWalkerAdapter;

/**
 * Additional information can be found at http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/cookbook/dql-custom-walkers.html#generic-count-query-for-pagination
 *
 * @author Kristen Gilden <gilden@planet.ee>
 */
class CountSQLWalker extends TreeWalkerAdapter
{
    /**
     * Walks down a SelectStatement AST node, thereby generating the appropriate SQL.
     *
     * @param SelectStatement $AST
     *
     * @return string The SQL.
     */
    public function walkSelectStatement(SelectStatement $AST)
    {
        $parent = null;
        $parentName = null;
        foreach ($this->_getQueryComponents() AS $dqlAlias => $qComp) {

            if (!array_key_exists('parent', $qComp)) {
                continue;
            }

            if ($qComp['parent'] === null && $qComp['nestingLevel'] == 0) {
                $parent = $qComp;
                $parentName = $dqlAlias;
                break;
            }
        }

        $pathExpression = new PathExpression(
            PathExpression::TYPE_STATE_FIELD | PathExpression::TYPE_SINGLE_VALUED_ASSOCIATION, $parentName,
            $parent['metadata']->getSingleIdentifierFieldName()
        );
        $pathExpression->type = PathExpression::TYPE_STATE_FIELD;

        $AST->selectClause->selectExpressions = array(
            new SelectExpression(
                new AggregateExpression('count', $pathExpression, true), null
            )
        );

        // ordering does not matter for the count query
        $AST->groupByClause = null;
        $AST->orderByClause = null;
    }
}