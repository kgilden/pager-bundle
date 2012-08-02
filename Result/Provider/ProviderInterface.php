<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden gilden@planet.ee
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Result\Provider;

/**
 * Contract for all paging providers to implement.
 *
 * @author Kristen Gilden <gilden@planet.ee>
 */
interface ProviderInterface
{
    /**
     * @return integer
     */
    function getElementCount();

    /**
     * Gets the paged elements.
     *
     * @param integer $offset Index of the first element to be returned
     * @param integer $count  Number of elements to be returned
     *
     * @return array
     */
    function getElements($offset, $count);
}
