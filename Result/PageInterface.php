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

use ArrayAccess, Countable, IteratorAggregate;

/**
 * @author Kristen Gilden <gilden@planet.ee>
 */
interface PageInterface extends ArrayAccess, Countable, IteratorAggregate
{
    /**
     * Sets the total number of elements paged.
     *
     * @param integer $elementCount
     */
    function setElementCount($elementCount);

    /**
     * @param integer $elementsPerPage
     */
    function setElementsPerPage($elementsPerPage);

    /**
     * Gets the total number of pages.
     *
     * @return integer
     */
    function getPageCount();

    /**
     * Sets the number of the current page.
     *
     * @param integer $currentPage
     */
    function setCurrentPage($currentPage);

    /**
     * Gets the page number that this instance represents.
     *
     * @return integer
     */
    function getCurrentPage();

    /**
     * @return boolean
     */
    function isFirst();

    /**
     * @return boolean
     */
    function isLast();

    /**
     * Gets all the elements.
     *
     * @return array
     */
    function all();
}