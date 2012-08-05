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

use ArrayIterator;

/**
 * Implements the array part of the PagerInterface.
 *
 * @author Kristen Gilden <gilden@planet.ee>
 */
abstract class AbstractPage implements PageInterface
{
    /**
     * @var array
     */
    private $_elements;

    /**
     * ArrayAccess implementation of offsetExists
     */
    public function offsetExists($offset)
    {
        return isset($this->_elements[$offset]);
    }

    /**
     * ArrayAccess implementation of offsetGet
     */
    public function offsetGet($offset)
    {
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
        if (empty($offset)) {
            $this->_elements[] = $value;
        } else {
            $this->_elements[$offset] = $value;
        }
    }

    /**
     * ArrayAccess implementation of offsetUnset()
     */
    public function offsetUnset($offset)
    {
        if (isset($this->_elements[$offset])) {
            unset($this->_elements[$offset]);
        }
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
        return count($this->_elements);
    }

    /**
     * Gets an iterator for iterating over the elements in the page.
     *
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->_elements);
    }

    /**
     * {@inheritDoc}
     */
    public function all()
    {
        return $this->_elements;
    }

    /**
     * Sets the elements in the page.
     *
     * @param array $elements
     */
    protected function set(array $elements)
    {
        $this->_elements = $elements;
    }
}
