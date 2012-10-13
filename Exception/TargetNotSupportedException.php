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

/**
 * Gets thrown if a pager does not support the specified paging target.
 *
 * @author Kristen Gilden <gilden@planet.ee>
 */
class TargetNotSupportedException extends \RuntimeException
{
	public function __construct($message = null, $code = null, $previous = null)
    {
        if (is_null($message)) {
            $message = 'This pager does not know how to page the target';
        }

        parent::__construct($message, $code, $previous);
    }
}