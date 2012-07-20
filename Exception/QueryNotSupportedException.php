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
 * @author Kristen Gilden <gilden@planet.ee>
 */
class QueryNotSupportedException extends KGPagerException
{
    public function __construct($message = null, $code = null, $previous = null)
    {
        $message = is_null($message)
                 ? 'Query type is not supported'
                 : $message;

        parent::__construct($message, $code, $previous);
    }
}
