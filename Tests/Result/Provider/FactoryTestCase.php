<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden kristen.gilden@gmail.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Tests\Result\Provider;

/**
 * A base class for testing factories.
 *
 * @author Kristen Gilden <kristen.gilden@gmail.com>
 */
abstract class FactoryTestCase extends \PHPUnit_Framework_TestCase
{
    const PROVIDER = 'KG\\Bundle\\PagerBundle\\Result\\Provider\\ProviderInterface';

    public function testSupportsTarget()
    {
        $factory = $this->getFactory();
        $target  = $this->getTarget();

        $this->assertTrue($factory->supports($target));
    }

    public function testGetReturnsProviderInterface()
    {
        $factory = $this->getFactory();
        $target  = $this->getTarget();

        $this->assertInstanceOf(self::PROVIDER, $factory->get($target));
    }

    /**
     * Gets a new factory object currently under testing.
     *
     * @return KG\Bundle\PagerBundle\Result\Provider\FactoryInterface
     */
    abstract protected function getFactory();

    /**
     * Gets the target to be tested with the factory. The target must
     * be supported by the factory for the tests to pass.
     *
     * @return mixed
     */
    abstract protected function getTarget();
}
