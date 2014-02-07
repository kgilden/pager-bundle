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
 * ElementsAccessedException gets thrown, if the result set has already
 * been accessed and therefor the action attempted to be done is now
 * illegal (e.g. Adding extra callbacks after accessing elements).
 *
 * @author Kristen Gilden <kristen.gilden@gmail.com>
 */
class ElementsAccessedException extends KGPagerException
{
    public function __construct($message = null, $code = null, $previous = null)
    {
        if (is_null($message)) {
            $message = "Elements have already been accessed.";
        }

        parent::__construct($message, $code, $previous);
    }
}
