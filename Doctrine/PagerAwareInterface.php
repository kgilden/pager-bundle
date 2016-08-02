<?php

namespace KG\Bundle\PagerBundle\Doctrine;

use KG\Pager\PagerInterface;

interface PagerAwareInterface
{
    /**
     * Sets the given pager to this object.
     *
     * @param PagerInterface $pager
     */
    public function setPager(PagerInterface $pager);
}
