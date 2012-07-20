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

use KG\Bundle\PagerBundle\Exception\QueryNotSupportedException;
use KG\Bundle\PagerBundle\Result\PageResult;

/**
 * Abstract result provider for generalizing the workflow and making
 * it easier to develop additional providers.
 *
 * @author Kristen Gilden <gilden@planet.ee>
 */
abstract class AbstractProvider implements ProviderInterface
{
    /**
     * @var integer
     */
    private $currentPage;

    /**
     * @var integer
     */
    private $recordsPerPage;

    /**
     * @param integer $currentPage
     * @throws \LogicException when the argument is non-positive
     */
    public function setCurrentPage($currentPage)
    {
        if ($currentPage < 1) {
            throw new \LogicException('Current page cannot be non-positive');
        }

        $this->currentPage = $currentPage;

        return $this;
    }

    /**
     * @param integer $recordsPerPage
     * @throws \LogicException when the argument is non-positive
     */
    public function setRecordsPerPage($recordsPerPage)
    {
        if ($recordsPerPage < 1) {
            throw new \LogicException('There must be more than 0 records per page');
        }

        $this->recordsPerPage = $recordsPerPage;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getPageResult($query)
    {
        if (!$this->supports($query)) {
            throw new QueryNotSupportedException();
        }

        $pageCount = (int) ceil($this->getTotalRecords($query) / $this->recordsPerPage);

        if (0 === $pageCount) {
            $pageCount = 1;
        }

        $offset    = ($this->currentPage - 1) * $this->recordsPerPage;
        $records   = $this->getRecords($query, $offset, $this->recordsPerPage);

        $result = new PageResult($records, $this->currentPage, $pageCount);

        return $result;
    }

    /**
     * Returns the total number of results to be paged.
     *
     * @param mixed $query
     *
     * @return integer
     */
    abstract protected function getTotalRecords($query);

    /**
     * Gets the paged results for the given offset and records per page.
     *
     * @param mixed $query
     * @param integer $offset            0Index of the first record that should be returned
     * @param integer $recordsPerPage
     *
     * @return array
     */
    abstract protected function getRecords($query, $offset, $recordsPerPage);

    /**
     * Returns whether the query is supported or not.
     *
     * @param mixed $query
     *
     * @return boolean
     */
    abstract protected function supports($query);
}
