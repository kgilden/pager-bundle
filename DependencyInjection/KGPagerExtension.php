<?php

namespace KG\Bundle\PagerBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class KGPagerExtension extends Extension
{
    const PREFIX_PAGER = 'kg_pager.pager';

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $this->registerPagers($config['pagers'], $container);
        $this->setDefaultPager($config['default'], $container);
    }

    /**
     * @param string           $name
     * @param ContainerBuilder $container
     */
    private function setDefaultPager($name, ContainerBuilder $container)
    {
        $defaultId = sprintf('%s.%s', self::PREFIX_PAGER, $name);

        if (!$container->findDefinition($defaultId)) {
            throw new LogicException(sprintf('No pager named %s registered (i.e. found no service named %s).', $name, $defaultId));
        }

        $container->setAlias('kg_pager', $defaultId);
    }

    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    private function registerPagers(array $configs, ContainerBuilder $container)
    {
        foreach ($configs as $name => $config) {
            $serviceId = sprintf("%s.%s", self::PREFIX_PAGER, $name);
            $definition = $container->register($serviceId, $container->getParameter('kg_pager.class'));

            // Sets the default items per page for the given pager.
            if (isset($config['per_page'])) {
                $definition->addArgument($config['per_page']);
            }

            // Changes the strategy, if this pager should merge last two pages
            // given the following threshold.
            if (isset($config['merge']) && $config['merge'] > 0) {
                $strategyDefinition = new Definition($container->getParameter('kg_pager.strategy.last_page_merged.class'));
                $strategyDefinition->addArgument($config['merge']);

                $definition->addArgument($strategyDefinition);
            }

            // Wraps the pager inside a request decorator to have it automatically
            // infer the current page from the request.
            if ($config['key']) {
                $container
                    ->register($serviceId, $container->getParameter('kg_pager.request_decorator.class'))
                    ->setArguments(array(
                        $definition,
                        $container->getDefinition('request_stack'),
                        $config['key'],
                    ))
                ;
            }
        }
    }
}
