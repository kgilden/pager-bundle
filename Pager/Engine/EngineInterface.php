<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden gilden@planet.ee
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Pager\Engine;

use KG\Bundle\PagerBundle\Result\Collection;

/**
 * Each engine implementing an EngineInterface is specialised to page only
 * a specific dataset. For example, there might be an engine for paging
 * array, Doctrine's ORM Query etc.
 *
 * @author Kristen Gilden <gilden@planet.ee>
 */
interface EngineInterface
{
    /**
     * Paginates the query and returns the collection.
     *
     * @param mixed $query      A query to be paginated
     *
     * @return Collection
     */
    function getPageResult($query);
}
