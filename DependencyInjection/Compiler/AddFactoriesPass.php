<?php

/*
 * This file is part of the KGPagerBundle package.
 *
 * (c) Kristen Gilden gilden@planet.ee
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KG\Bundle\PagerBundle\DependencyInjection\Compiler;

use KG\Bundle\PagerBundle\Exception\UnexpectedTypeException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;


/**
 * This compiler pass registers the result provider factories in the Pager.
 *
 * @author Kristen Gilden <gilden@planet.ee>
 */
class AddFactoriesPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('kg_pager')) {
            return;
        }

        $factories = array();

        $factory_generic = $container->getParameter('kg_pager.factory.generic.class');
        $interface       = $container->getParameter('kg_pager.interface.provider');

        foreach ($container->findTaggedServiceIds('kg_pager.factory') as $id => $tags) {
            $definition = $container->getDefinition($id);

            // Provider classes must implement provider interface.
            // This solution provides feedback of possible errors
            // at compile time already. It is only applied to servies
            // that inherit from GenericFactory. Other factories should
            // enforce type inside the classes.
            if (is_a($definition->getClass(), $factory_generic)) {
                $provider  = $definition->getArgument(0);

                if (!is_a($provider, $interface)) {
                    throw new UnexpectedTypeException($provider, $interface);
                }
            }

            $factories[] = new Reference($id);
        }

        $definition = $container->getDefinition('kg_pager');
        $definition->replaceArgument(0, $factories);
    }
}