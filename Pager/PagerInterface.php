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
     * @param mixed $target    The target to be paginated.
     *
     * @return Collection
     */
    function paginate($target);
}
