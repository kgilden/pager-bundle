<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden gilden@planet.ee
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Tests\Result\Provider;

use KG\Bundle\PagerBundle\Result\Provider\GenericFactory;

/**
 * @author Kristen Gilden <gilden@planet.ee>
 */
class GenericFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testSupportsTarget()
    {
        $provider = 'stdClass';
        $target   = 'stdClass';
        $factory  = new GenericFactory($provider, $target);

        $this->assertTrue($factory->supports(new \stdClass()));
    }

    public function testNotSupportsTarget()
    {
        $provider = 'stdClass';
        $target   = 'KG\\Bundle\\PagerBundle\\Tests\\Stub\\Target';
        $factory  = new GenericFactory($provider, $target);

        $this->assertFalse($factory->supports(new \stdClass()));
    }

    public function testGetReturnsProviderInstance()
    {
        $provider = 'KG\\Bundle\\PagerBundle\\Tests\\Stub\\ResultProvider';
        $target   = 'stdClass';
        $factory  = new GenericFactory($provider, $target);

        $this->assertInstanceOf($provider, $factory->get($target));
    }
}