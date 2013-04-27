<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden gilden@planet.ee
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Result\Helper;

use KG\Bundle\PagerBundle\Exception\UnexpectedTypeException;

/**
 * Applies page callbacks. The array of elements is passed down to the
 * callback and the transformed element array is expected to be output.
 *
 * @author Kristen Gilden <gilden@planet.ee>
 */
class PageCallback implements CallbackInterface
{
    /**
     * @var callable
     */
    protected $callback;

    /**
     * @param callable $callback
     */
    public function __construct($callback)
    {
        if (!(is_callable($callback))) {
            throw new \InvalidArgumentException('$callback must be callable.');
        }

        $this->callback = $callback;
    }

    /**
     * {@inheritDoc}
     */
    public function apply(array $elements)
    {
        $elements = call_user_func($this->callback, $elements);

        if (!is_array($elements)) {
            throw new UnexpectedTypeException($elements, 'array');
        }

        return $elements;
    }
}
