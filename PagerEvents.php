<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden gilden@planet.ee
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle;

/**
 * @author Kristen Gilden <gilden@planet.ee>
 */
class PagerEvents
{
    /**
     * The pager.paginate event is fired every time something needs to
     * be paged. The pager with the knowledge to paginate the target
     * should notify itself via the event.
     *
     * @var string
     */
    const PAGINATE = 'pager.paginate';
}