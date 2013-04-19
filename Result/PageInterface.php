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
     * Gets the total number of elements paged.
     *
     * @return integer
     */
    function getElementCount();

    /**
     * @param integer $elementsPerPage
     */
    function setElementsPerPage($elementsPerPage);

    /**
     * Gets the offset from the first element as if the elements were not paged.
     *
     * @return integer
     */
    function getOffset();

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

    /**
     * Adds a callback function to modify each result separately. The callback
     * is called for each element separately. It is expected to return the
     * modified element. Callbacks are applied in a FIFO fashion.
     *
     * Element callbacks must be run after page callbacks.
     *
     * @param mixed $cb
     *
     * @return PageInterface
     */
    function addElementCb($cb);

    /**
     * Adds a callback function to modify the results before returning
     * them by any of the other methods. The whole result set is passed
     * to the callback.
     *
     * The callback is expected to return the modified result set. Callbacks
     * are applied in a FIFO fashion.
     *
     * Page callbacks must be run before element callbacks.
     *
     * @param mixed $cb
     *
     * @return PageInterface
    */
    function addPageCb($cb);
}