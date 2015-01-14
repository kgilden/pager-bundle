<?php

namespace KG\Bundle\PagerBundle\Exception;

class InvalidPageException extends KGPagerException
{
    /**
     * @var integer
     */
    private $currentPage;

    /**
     * @var integer
     */
    private $pageCount;

    /**
     * @param integer $currentPage
     * @param integer $pageCount
     * @param string  $message
     */
    public function __construct($currentPage, $pageCount, $message = null)
    {
        $this->currentPage = $currentPage;
        $this->pageCount = $pageCount;

        $message = $message ?: sprintf('The current page (%d) is out of the paginated page range (%d).', $currentPage, $pageCount);

        parent::__construct($message);
    }

    /**
     * @return integer
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * @return integer
     */
    public function getPageCount()
    {
        return $this->pageCount;
    }
}
