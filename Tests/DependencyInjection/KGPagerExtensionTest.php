<?php

namespace KG\Bundle\PagerBundle\Tests\DependencyInjection;

use KG\Bundle\PagerBundle\DependencyInjection\KGPagerExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Parser;

class KGPagerExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testServicesLoaded()
    {
        $config = $this->getFullConfig();
        $loader = new KGPagerExtension();
        $loader->load(array($config), $container = new ContainerBuilder());

        $this->assertTrue($container->has('kg_pager'));
    }

    private function getEmptyConfig()
    {
        $yaml = <<<YAML
YAML;

        $parser = new Parser();

        return $parser->parse($yaml);
    }
}
