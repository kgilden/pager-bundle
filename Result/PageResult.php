<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden gilden@planet.ee
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Result;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @author Kristen Gilden <gilden@planet.ee>
 */
class PageResult extends ArrayCollection implements Collection
{
    /**
     * @var integer
     */
    protected $currentPage;

    /**
     * @var integer
     */
    protected $pageCount;

    /**
     * @param array $elements
     * @param integer $current_page
     * @param integer $page_count
     */
    public function __construct(array $elements = array(), $currentPage = 1, $pageCount = 1)
    {
        parent::__construct($elements);

        if ($currentPage > $pageCount) {
            throw new \LogicException('Current page is greater than total page count');
        }

        if ($currentPage < 1) {
            throw new \LogicException('Current page cannot be non-positive');
        }

        if ($pageCount < 1) {
            throw new \LogicException('Total page count cannot be non-positive');
        }

        $this->currentPage = $currentPage;
        $this->pageCount   = $pageCount;
    }

    /**
     * {@inheritDoc}
     */
    public function getPageCount()
    {
        return $this->pageCount;
    }

    /**
     * {@inheritDoc}
     */
    public function getPageNumber()
    {
       return $this->currentPage;
    }

    /**
     * {@inheritDoc}
     */
    public function isFirstPage()
    {
        return 1 === $this->currentPage;
    }

    /**
     * {@inheritDoc}
     */
    public function isLastPage()
    {
        return $this->pageCount === $this->currentPage;
    }
}