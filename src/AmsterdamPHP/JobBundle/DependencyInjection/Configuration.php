<?php

namespace AmsterdamPHP\JobBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ScalarNodeDefinition;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('amsterdam_php_job');

        $rootNode->append(new ScalarNodeDefinition('google_analytics_ua_code'));
        $rootNode->append(new ScalarNodeDefinition('google_analytics_url'));
        $rootNode->append(new ScalarNodeDefinition('abuse_report_email_address'));

        return $treeBuilder;
    }
}
