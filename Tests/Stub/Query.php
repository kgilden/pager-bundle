<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden kristen.gilden@gmail.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Tests\Stub;

use Doctrine\ORM\AbstractQuery;

/**
 * A stub Query implementation to use in classes
 *
 * @author Kristen Gilden <kristen.gilden@gmail.com>
 */
class Query extends AbstractQuery
{
    /**
     * @var mixed
     */
    private $return_value;

    /**
     * Sets the value to be returned when MockQuery::execute is called.
     *
     * @param mixed $return_value
     */
    public function setExecuteReturnValue($return_value)
    {
        $this->return_value = $return_value;
    }

    /**
     * {@inheritDoc}
     */
    public function execute($parameters = null, $hydrationMode = null)
    {
        return $this->return_value;
    }

    /**
     * {@inheritDoc}
     */
    public function getSQL()
    {
        /* Do nothing */
    }

    /**
     * {@inheritDoc}
     */
    protected function _doExecute()
    {
        /* Do nothing */
    }
}