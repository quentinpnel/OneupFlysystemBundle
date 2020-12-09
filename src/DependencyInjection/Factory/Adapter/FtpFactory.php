<?php

declare(strict_types=1);

namespace Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter;

use Oneup\FlysystemBundle\DependencyInjection\Factory\AdapterFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FtpFactory implements AdapterFactoryInterface
{
    public function getKey(): string
    {
        return 'ftp';
    }

    public function create(ContainerBuilder $container, string $id, array $config): void
    {
        $definition = $container
            ->setDefinition($id, new ChildDefinition('oneup_flysystem.adapter.ftp'))
            ->replaceArgument(0, $config)
        ;
    }

    public function addConfiguration(NodeDefinition $node): void
    {
        $node
            ->children()
                ->scalarNode('host')->isRequired()->end()

                ->scalarNode('port')->defaultValue(21)->end()
                ->scalarNode('username')->defaultNull()->end()
                ->scalarNode('password')->defaultNull()->end()
                ->scalarNode('root')->defaultNull()->end()
                ->booleanNode('ssl')->defaultFalse()->end()
                ->scalarNode('timeout')->defaultValue(90)->end()
                ->scalarNode('permPrivate')->defaultValue(0000)->end()
                ->scalarNode('permPublic')->defaultNull(0744)->end()
                ->booleanNode('passive')->defaultTrue()->end()
                ->scalarNode('transferMode')->defaultValue(\defined('FTP_BINARY') ? FTP_BINARY : null)->end()
                ->scalarNode('systemType')->defaultNull()->end()
                ->booleanNode('ignorePassiveAddress')->defaultNull()->end()
                ->booleanNode('recurseManually')->defaultFalse()->end()
            ->end()
        ;
    }
}