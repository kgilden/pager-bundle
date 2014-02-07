<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden kristen.gilden@gmail.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Pager;

use KG\Bundle\PagerBundle\Exception\TargetNotSupportedException;
use KG\Bundle\PagerBundle\Result\LazyPage;

/**
 * Common implementation across all pagers.
 *
 * @author Kristen Gilden <kristen.gilden@gmail.com>
 */
abstract class Pager implements PagerInterface
{
    /**
     * {@inheritDoc}
     */
    public function paginate($target, array $options = array())
    {
        if (!$this->supports($target)) {
            throw new TargetNotSupportedException();
        }

        return new LazyPage($this->getProvider($target, $options));
    }

    /**
     * Gets a provider for the specified target.
     *
     * @param mixed $target
     * @param array $options
     *
     * @return ProviderInterface
     */
    abstract protected function getProvider($target, array $options);
}
