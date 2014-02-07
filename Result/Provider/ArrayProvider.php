<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden kristen.gilden@gmail.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Result\Provider;

/**
 * A simple Array Provider demonstrating the paging mechanism.
 *
 * @author Kristen Gilden <kristen.gilden@gmail.com>
 */
class ArrayProvider implements ProviderInterface
{
    /**
     * @var array
     */
    protected $target;

    public function __construct(array $target)
    {
        $this->target = $target;
    }

    /**
     * {@inheritDoc}
     */
    public function getElementCount()
    {
        return count($this->target);
    }

    /**
     * {@inheritDoc}
     */
    public function getElements($offset, $count)
    {
        return array_slice($this->target, $offset, $count);
    }
}
