<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden kristen.gilden@gmail.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\Tests\Pager;

use KG\Bundle\PagerBundle\Pager\GenericPager;

use KG\Bundle\PagerBundle\Result\Provider\GenericFactory;

/**
 * @author Kristen Gilden <kristen.gilden@gmail.com>
 */
class GenericPagerTest extends \PHPUnit_Framework_TestCase
{
    const CLASS_PAGE     = 'KG\\Bundle\\PagerBundle\\Result\\PageInterface';
    const CLASS_PROVIDER = 'KG\\Bundle\\PagerBundle\\Tests\\Stub\\ResultProvider';
    const CLASS_TARGET   = 'KG\\Bundle\\PagerBundle\\Tests\\Stub\\Target';

    public function testSupportsTarget()
    {
        $pager    = new GenericPager(self::CLASS_PROVIDER, 'stdClass');

        $this->assertTrue($pager->supports(new \stdClass()));
    }

    public function testNotSupportsTarget()
    {
        $provider = 'stdClass';
        $pager    = new GenericPager('stdClass', self::CLASS_TARGET);

        $this->assertFalse($pager->supports(new \stdClass()));
    }

    public function testPaginateReturnsPageInterface()
    {
        $pager    = new GenericPager(self::CLASS_PROVIDER, 'stdClass');

        $this->assertInstanceOf(self::CLASS_PAGE, $pager->paginate(new \stdClass));
    }
}