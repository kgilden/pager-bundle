<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden gilden@planet.ee
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Pager;

use KG\Bundle\PagerBundle\Exception\TargetNotSupportedException;

/**
 * Composite pager consists of a number of different pager objects. It can
 * select the correct pager based on the specified target.
 *
 * @author Kristen Gilden <gilden@planet.ee>
 */
class CompositePager implements PagerInterface
{
    /**
     * @var array
     */
    protected $pagers;

    /**
     * @param array $pager
     */
    public function __construct(array $pagers)
    {
        $this->pagers = $pagers;
    }

    /**
     * {@inheritDoc}
     */
    public function paginate($target, array $options = array())
    {
        if ($pager = $this->getPagerByTarget($target)) {
            return $pager->paginate($target, $options);
        }

        throw new TargetNotSupportedException();
    }

    /**
     * {@inheritDoc}
     */
    public function supports($target)
    {
        return $this->getPagerByTarget($target) ? true : false;
    }

    /**
     *
     * @param mixed $target
     *
     * @return PagerInterface|null
     */
    protected function getPagerByTarget($target)
    {
        foreach ($this->pagers as $pager) {
            if ($pager->supports($target)) {
                return $pager;
            }
        }

        return null;
    }
}
