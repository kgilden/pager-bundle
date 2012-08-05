<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden gilden@planet.ee
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Exception;

class ProviderNotFoundException extends KGPagerException
{
    public function __construct($target)
    {
        if (is_object($target)) {
            $target = get_class($target);
        } elseif (!is_string($target)) {
            $target = gettype($target);
        }

        $message = sprintf('Could not find a provider to paginate "%s"', $target);

        parent::__construct($message);
    }
}