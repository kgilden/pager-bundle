<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden gilden@planet.ee
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Result;

use Doctrine\Common\Collections\Collection as BaseCollection;

/**
 * A Collection is a contract for all paged resultset objects to
 * implement. It's an extension of Doctrine's Collection interface
 * and adds paging related methods.
 *
 * @author Kristen Gilden <gilden@planet.ee>
 */
interface Collection extends BaseCollection
{
    /**
     * Gets the total number of pages.
     *
     * @return integer
     */
    function getPageCount();

    /**
     * Gets the page number that this Collection represents.
     *
     * @return integer
     */
    function getPageNumber();

    /**
     * @return boolean
     */
    function isFirstPage();

    /**
     * Returns whether the Collection represents the last page.
     *
     * @return boolean
     */
    function isLastPage();
}