<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden kristen.gilden@gmail.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Exception;

/**
 * Gets thrown for methods not allowed to be used.
 *
 * @author Kristen Gilden <kristen.gilden@gmail.com>
 */
class IllegalMethodException extends KGPagerException
{
    public function __construct($message = null, $code = null, $previous = null)
    {
        if (is_null($message)) {
            list(,$caller) = debug_backtrace(false);

            $message = "Unexpected call to illegal method \"$caller[function]\".";
        }

        parent::__construct($message, $code, $previous);
    }
}
