<?php

namespace KG\Bundle\PagerBundle\Tests\DependencyInjection;

use KG\Bundle\PagerBundle\DependencyInjection\KGPagerExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Parser;

class KGPagerExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testServicesLoaded()
    {
        $container = new ContainerBuilder();
        $loader = new KGPagerExtension();
        $loader->load(array($this->getFullConfig()), $container);

        $this->assertTrue($container->has('kg_pager'));
    }

    public function testOutOfRangeRedirectorDisabledByDefault()
    {
        $container = new ContainerBuilder();
        $loader = new KGPagerExtension();
        $loader->load(array($this->getEmptyConfig()), $container);

        $this->assertNotContains('kg_pager.invalid_page_redirector', array_keys($container->findTaggedServiceIds('kernel.event_listener')));
    }

    public function testListenerAddedIfOutOfRangeRedirectsEnabled()
    {
        $container = new ContainerBuilder();
        $loader = new KGPagerExtension();
        $loader->load(array($this->getFullConfig()), $container);

        $this->assertContains('kg_pager.invalid_page_redirector', array_keys($container->findTaggedServiceIds('kernel.event_listener')));
    }

    private function getEmptyConfig()
    {
        $yaml = <<<YAML
YAML;

        $parser = new Parser();

        return $parser->parse($yaml);
    }

    private function getFullConfig()
    {
        $yaml = <<<YAML
redirect_if_out_of_range: true
YAML;

        $parser = new Parser();

        return $parser->parse($yaml);
    }
}
