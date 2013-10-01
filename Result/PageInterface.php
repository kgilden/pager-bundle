<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden kristen.gilden@gmail.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Result;

use ArrayAccess, Countable, IteratorAggregate;

/**
 * @author Kristen Gilden <kristen.gilden@gmail.com>
 */
interface PageInterface extends ArrayAccess, Countable, IteratorAggregate
{
    /**
     * Sets the total number of elements paged.
     *
     * @param integer $elementCount
     *
     * @api
     */
    function setElementCount($elementCount);

    /**
     * Gets the total number of elements paged.
     *
     * @return integer
     *
     * @api
     */
    function getElementCount();

    /**
     * @param integer $elementsPerPage
     *
     * @api
     */
    function setElementsPerPage($elementsPerPage);

    /**
     * Gets the offset from the first element as if the elements were not paged.
     *
     * @return integer
     *
     * @api
     */
    function getOffset();

    /**
     * Gets the total number of pages.
     *
     * @return integer
     *
     * @api
     */
    function getPageCount();

    /**
     * Sets the number of the current page.
     *
     * @param integer $currentPage
     *
     * @api
     */
    function setCurrentPage($currentPage);

    /**
     * Gets the page number that this instance represents.
     *
     * @return integer
     *
     * @api
     */
    function getCurrentPage();

    /**
     * @return boolean
     *
     * @api
     */
    function isFirst();

    /**
     * @return boolean
     *
     * @api
     */
    function isLast();

    /**
     * Gets all the elements.
     *
     * @return array
     *
     * @api
     */
    function all();

    /**
     * Adds a callback to modify each result separately by executing it once
     * per every element. They are applied in a FIFO order (including page
     * callbacks).
     *
     * The following example illustrates this:
     * <code>
     * <?php
     * $page = new Page();  // implements this interface
     * $page->addElementCb(function ($element) {
     *     $element->foo = 'baz';
     *
     *     // the callback MUST return the altered element
     *     return $element;
     * });
     * </code>
     *
     *
     * @param mixed $cb
     *
     * @api
     */
    function addElementCb($cb);

    /**
     * Adds a callback to modify the results in bulk. The whole result set is
     * passed to the callback, which is expected to return the modified result
     * set. Callbacks are applied in a FIFO fashion (including element
     * callbacks).
     *
     * The following example illustrates this:
     * <code>
     * <?php
     * // Page implements PageInterface.
     * $page = new Page();
     * $page->addPageCb(function ($elements) {
     *     foreach ($elements as $element) {
     *         $element->foo = 'baz';
     *     }
     *
     *     // The callback must return the altered elements.
     *     return $elements;
     * });
     * </code>
     *
     *
     * @param mixed $cb
     *
     * @return PageInterface
     *
     * @api
     */
    function addPageCb($cb);
}