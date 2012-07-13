<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden gilden@planet.ee
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Pager;

use KG\Bundle\PagerBundle\Result\Collection;

/**
 * @author Kristen Gilden <gilden@planet.ee>
 */
interface PagerInterface
{
    /**
     * Paginates the query.
     *
     * @param mixed $query    The query to be paginated. It may be any object
     *                        provided there exists a paging engine that
     *                        knows how to page said object.
     *
     * @return Collection
     */
    function paginate($query);

    /**
     * Returns whether the query is supported by the pager.
     *
     * @param mixed $query
     *
     * @return boolean
     */
    function supports($query);
}
