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

use KG\Bundle\PagerBundle\Pager\FOSElasticaPager;

class FosElasticaPagerTest extends \PHPUnit_Framework_TestCase
{
    public function testSupportsAdapter()
    {
        $pager = new FOSElasticaPager();

        $this->assertTrue($pager->supports($this->getMockAdapter()));
    }

    public function testPaginateReturnsPager()
    {
        $pager = new FOSElasticaPager();
        $page = $pager->paginate($this->getMockAdapter());

        $this->assertInstanceOf('KG\Bundle\PagerBundle\Result\PageInterface', $page);
    }

    private function getMockAdapter()
    {
        return $this->getMock('FOS\ElasticaBundle\Paginator\PaginatorAdapterInterface');
    }
}
