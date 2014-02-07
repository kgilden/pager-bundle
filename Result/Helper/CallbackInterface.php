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
 * CallbackInterface is an attempt to generalize different types of callbacks
 * applied to Page objects. At the moment this is just an implementation detail
 * and should not be used by userland code.
 *
 * @author Kristen Gilden <kristen.gilden@gmail.com>
 */
interface CallbackInterface
{
    /**
     * Applies the callback.
     *
     * @param array $elements
     *
     * @return array The elements with the current callback applied
     */
    public function apply(array $elements);
}
