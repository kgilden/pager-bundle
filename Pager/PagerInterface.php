<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden kristen.gilden@gmail.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Pager;

/**
 * @author Kristen Gilden <kristen.gilden@gmail.com>
 */
interface PagerInterface
{
    /**
     * @param mixed $target     The target to be paginated.
     * @param array $options    Paging specific options.
     *
     * @return Collection
     *
     * @api
     */
    function paginate($target, array $options = array());

    /**
     * Returns whether the pager is able to paginate the specified target.
     *
     * @param mixed $target
     *
     * @return boolean
     *
     * @api
     */
    function supports($target);
}
