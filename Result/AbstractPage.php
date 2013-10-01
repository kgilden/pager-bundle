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

use KG\Bundle\PagerBundle\Result\Helper\ElementCallback;

use ArrayIterator;
use KG\Bundle\PagerBundle\Exception\ElementsAccessedException;
use KG\Bundle\PagerBundle\Exception\IllegalMethodException;
use KG\Bundle\PagerBundle\Result\Helper\PageCallback;

/**
 * Implements the array part of the PagerInterface.
 *
 * @author Kristen Gilden <kristen.gilden@gmail.com>
 */
abstract class AbstractPage implements PageInterface
{
    /**
     * @var array
     */
    private $_elements;

    /**
     * Whether the callbacks have already been applied
     *
     * @var boolean
     */
    private $cbsApplied = false;

    /**
     * Have any of the elements already been accessed?
     *
     * @var boolean
     */
    private $accessed = false;

    /**
     * @var CallbackInterface[]
     */
    private $callbacks = array();

    /**
     * @var array
     */
    private $elementCbs = array();

    /**
     * @var array
     */
    private $pageCbs = array();

    /**
     * @param array|null $elements
     */
    public function __construct(array $elements = null)
    {
        if (!is_null($elements)) {
            $this->set($elements);
        }
    }

    /**
     * ArrayAccess implementation of offsetExists
     */
    public function offsetExists($offset)
    {
        $this->applyCbs();

        return isset($this->_elements[$offset]);
    }

    /**
     * ArrayAccess implementation of offsetGet
     */
    public function offsetGet($offset)
    {
        $this->applyCbs();

        if (isset($this->_elements[$offset])) {
            return $this->_elements[$offset];
        }

        return null;
    }

    /**
     * ArrayAccess implementation of offsetSet()
     */
    public function offsetSet($offset, $value)
    {
        throw new IllegalMethodException();
    }

    /**
     * ArrayAccess implementation of offsetUnset()
     */
    public function offsetUnset($offset)
    {
        throw new IllegalMethodException();
    }

    /**
     * Returns the number of elements in the page.
     *
     * Implementation of the Countable interface.
     *
     * @return integer The number of elements in the collection.
     */
    public function count()
    {
        $this->applyCbs();

        return count($this->_elements);
    }

    /**
     * Gets an iterator for iterating over the elements in the page.
     *
     * @return ArrayIterator
     */
    public function getIterator()
    {
        $this->applyCbs();

        return new ArrayIterator($this->_elements);
    }

    /**
     * {@inheritDoc}
     */
    public function all()
    {
        $this->applyCbs();

        return $this->_elements;
    }

    /**
     * {@inheritDoc}
     */
    public function addPageCb($cb)
    {
        if ($this->cbsApplied) {
            $message = "Cannot add page callbacks after accessing elements.";
            throw new ElementsAccessedException($message);
        }

        $this->callbacks[] = new PageCallback($cb);
    }

    /**
     * {@inheritDoc}
     */
    public function addElementCb($cb)
    {
        if ($this->cbsApplied) {
            $message = "Cannot add element callbacks after accessing elements.";
            throw new ElementsAccessedException($message);
        }

        $this->callbacks[] = new ElementCallback($cb);
    }

    /**
     * Sets the elements in the page.
     *
     * @param array $elements
     */
    protected function set(array $elements)
    {
        // Callbacks will be added prior to the use of any public access
        // methods. You should keep this in mind and follow the same
        // principle when extending from this class.
        $this->_elements = $elements;
        $this->cbsApplied = false;
    }

    /**
     * Applies both element and page callbacks on the elements.
     */
    private function applyCbs()
    {
        if ($this->cbsApplied) {
            return;
        }

        $elements = $this->_elements;

        foreach ($this->callbacks as $callback) {
            $elements = $callback->apply($elements);
        }

        $this->_elements  = $elements;
        $this->cbsApplied = true;
    }
}
