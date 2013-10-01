<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden kristen.gilden@gmail.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Result\Helper;

/**
 * Applies element callbacks. The callback is invoked once per each element.
 * The modified element is expected to be output.
 *
 * @author Kristen Gilden <kristen.gilden@gmail.com>
 */
class ElementCallback implements CallbackInterface
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
        foreach ($elements as $key => $element) {
            $elements[$key] = call_user_func($this->callback, $element);
        }

        return $elements;
    }
}
