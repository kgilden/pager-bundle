<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden kristen.gilden@gmail.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Result;

/**
 * @author Kristen Gilden <kristen.gilden@gmail.com>
 */
class Page extends AbstractPage
{
    /**
     * @var integer
     */
    protected $elementCount;

    /**
     * @var integer
     */
    protected $elementsPerPage;

    /**
     * The page number this Page represents
     *
     * @var integer
     */
    protected $currentPage;

    /**
     * @param array $elements
     */
    public function __construct(array $elements = array())
    {
        $this->set($elements);
    }

    /**
     * {@inheritDoc}
     */
    public function setElementCount($elementCount)
    {
        if (0 > ($elementCount = (int) $elementCount)) {
            throw new \LogicException('Invalid negative element count');
        }

        $this->elementCount = $elementCount;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getElementCount()
    {
        if (!isset($this->elementCount)) {
            throw new \RuntimeException('Element count is not set');
        }

        return $this->elementCount;
    }

    /**
     * {@inheritDoc}
     */
    public function setElementsPerPage($elementsPerPage)
    {
        if ($elementsPerPage < 1) {
            throw new \LogicException('More than 0 elements must be on a page');
        }

        $this->elementsPerPage = $elementsPerPage;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getOffset()
    {
        $elementsPerPage = $this->getElementsPerPage();
        $currentPage     = $this->getCurrentPage();

        return ($currentPage - 1) * $elementsPerPage;
    }

    /**
     * {@inheritDoc}
     */
    public function getPageCount()
    {
        $elementCount = $this->getElementCount();
        $elementsPerPage = $this->getElementsPerPage();

        $pageCount = (int) ceil($elementCount / $elementsPerPage);

        if (0 === $pageCount) {
            // $pageCount is 0, if 0 elements were found. Page count is 1 to
            // prevent any possible errors in client code.
            $pageCount = 1;
        }

        return $pageCount;
    }

    /**
     * {@inheritDoc}
     */
    public function setCurrentPage($currentPage)
    {
        $currentPage = (int) $currentPage;

        if ($currentPage > $this->getPageCount()) {
            throw new \OutOfRangeException('The current page cannot be out of the paginated page range');
        }

        if ($currentPage < 1) {
            throw new \OutOfRangeException('Current page cannot be non-positive');
        }

        $this->currentPage = $currentPage;
    }

    /**
     * {@inheritDoc}
     */
    public function getCurrentPage()
    {
        if (!isset($this->currentPage)) {
            throw new \RuntimeException('Current page is not set');
        }

        return $this->currentPage;
    }

    /**
     * {@inheritDoc}
     */
    public function isFirst()
    {
        return 1 === $this->getCurrentPage();
    }

    /**
     * {@inheritDoc}
     */
    public function isLast()
    {
        return $this->getPageCount() === $this->getCurrentPage();
    }

    /**
     * Gets the maximum number of elements on each page.
     *
     * @return integer
     */
    protected function getElementsPerPage()
    {
        if (!isset($this->elementsPerPage)) {
            // Most likely caused by a forgetful devolper.
            throw new \RuntimeException('Number of elements per page is not set');
        }

        return $this->elementsPerPage;
    }
}