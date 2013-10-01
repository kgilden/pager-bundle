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

use KG\Bundle\PagerBundle\Result\Provider\ProviderInterface;
use KG\Bundle\PagerBundle\Exception\UnexpectedTypeException;

/**
 * The LazyPage solves the problem of not knowing all the necessary params
 * to perform the pagination prior to rendering the page. Different templates
 * might need to display a different number of records on a single page.
 *
 * The problem is solved by introducing a LazyPage, which has a reference
 * to result provider interface, which can populate the page on demand.
 *
 * @author Kristen Gilden <kristen.gilden@gmail.com>
 */
final class LazyPage extends Page
{
    /**
     * @var ProviderInterface
     */
    protected $provider;

    /**
     * @var boolean
     */
    private $elementsPopulated;

    /**
     * @param ProviderInterface $provider
     */
    public function __construct(ProviderInterface $provider)
    {
        $this->setProvider($provider);
        $this->elementsPopulated = false;
    }

    /**
     * @param ProviderInterface $provider
     */
    public function setProvider(ProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * {@inheritDoc}
     */
    public function getElementCount()
    {
        if (!isset($this->elementCount)) {
            $this->setElementCount($this->provider->getElementCount());
        }

        return parent::getElementCount();
    }

    /**
     * {@inheritDoc}
     */
    public function setCurrentPage($currentPage)
    {
        try {
            $currentPageOld = $this->getCurrentPage();
        } catch (\RuntimeException $e) {
            $currentPageOld = null;
        }

        if ($currentPageOld !== $currentPage) {
            // Repopulate the elements, if the current page has been changed.
            $this->elementsPopulated = false;
        }

        parent::setCurrentPage($currentPage);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetExists($index)
    {
        $this->populateElements();

        return parent::offsetExists($index);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetGet($index)
    {
        $this->populateElements();

        return parent::offsetGet($index);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetSet($index, $value)
    {
        $this->populateElements();

        return parent::offsetSet($index, $value);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetUnset($offset)
    {
        $this->populateElements();

        return parent::offsetUnset($offset);
    }

    /**
     * {@inheritDoc}
     */
    public function count()
    {
        $this->populateElements();

        return parent::count();
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator()
    {
        $this->populateElements();

        return parent::getIterator();
    }

    /**
     * {@inheritDoc}
     */
    public function all()
    {
        $this->populateElements();

        return parent::all();
    }

    /**
     * Loads the elements from the provider
     */
    private function populateElements()
    {
        if (true === $this->elementsPopulated) {
            return;
        }

        $elements = $this->provider->getElements(
            $this->getOffset(),
            $this->getElementsPerPage()
        );

        if (!is_array($elements)) {
            throw new UnexpectedTypeException($elements, 'array');
        }

        $this->set($elements);
        $this->elementsPopulated = true;
    }
}