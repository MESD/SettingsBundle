<?php

namespace Fc\SettingsBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class FcSettingsExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);


        //Peform some extra validation
        if (1 > count($config["bundles"])) {
            unset($config["bundles"]);
        }
        if (true === $config["auto_map"] && isset($config["bundles"])) {
            throw new \Exception("FcSetttingsBundle Config Error: You may set auto_map: true or specify bundles, not both");
        }

        // Store fc_settings config parameters in container
        foreach( $config as $parameter => $value ) {

            if (is_array($value)) {
                foreach ($value as $key => $val) {
                    if (is_array($val)) {
                        foreach ($val as $k => $v) {
                            $container->setParameter(
                                'fc_settings.' . $parameter . '.' . $key . '.' . $k,
                                $v
                            );
                        }
                    }
                    else {
                        $container->setParameter(
                            'fc_settings.' . $parameter . '.' . $key,
                            $val
                        );
                    }
                }
            }
            else {
                $container->setParameter(
                    'fc_settings.' . $parameter,
                    $value
                );
            }
        }


        // Creat an array to hold setting definition file locations
        $bundleStorage = array();

        // Make the first/defualt location in the kernel root directory
        $bundleStorage[0] = $container->getParameter('kernel.root_dir') . '/Resources/settings';

        // Load all user requested bundle paths from config
        if(isset($config["bundles"]) || true === $config["auto_map"]) {
            foreach ($container->getParameter('kernel.bundles') as $bundle => $bundlePath) {
                if(isset( $config["bundles"])) {
                    if (array_key_exists($bundle, $config["bundles"])) {
                        $bundleStorage[] = '@' . $bundle . '/Resources/settings';
                    }
                }
                elseif (true === $config["auto_map"]) {
                    $bundleStorage[] = '@' . $bundle . '/Resources/settings';
                }
            }
        }

        $container->setParameter(
            'fc_settings.bundle_storage',
            $bundleStorage
        );


        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}