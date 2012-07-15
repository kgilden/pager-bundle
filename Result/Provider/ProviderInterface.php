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

use KG\Bundle\PagerBundle\Result\Collection;

/**
 * Result providers abstract away the specific way the total number of results
 * and results themselves are provided. For example, there might be a provider
 * for paging an array, Doctrine's ORM Query etc.
 *
 * @author Kristen Gilden <gilden@planet.ee>
 */
interface ProviderInterface
{
    /**
     * Paginates the query and returns the results in a collection.
     *
     * @param mixed $query      A query to be paginated
     *
     * @return Collection
     */
    function getPageResult($query);
}
