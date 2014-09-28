<?php

namespace Fc\SettingsBundle\Model\Definition;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\Config\FileLocator;
use Symfony\Component\Yaml\Dumper;
use Symfony\Component\Yaml\Parser;
use Fc\SettingsBundle\Model\Definition\DefinitionValidator;
use Fc\SettingsBundle\Model\Definition\SettingDefinition;
use Fc\SettingsBundle\Model\Definition\SettingNode;

class DefinitionManager
{

    private $bundleStorage;
    private $kernel;
    private $settingsManager;


    public function __construct ($bundleStorage, $kernel, $settingsManager)
    {
        $this->bundleStorage   = $bundleStorage;
        $this->kernel          = $kernel;
        $this->settingsManager = $settingsManager;
    }


    public function createFile($fileName)
    {
        if ($file = $this->locateFile($fileName)) {
            throw new \Exception(sprintf('File %s already exists', $fileName));
        }

        $fs = new Filesystem();

        if (!$fs->exists($this->bundleStorage[0])) {
            $fs->mkdir($this->bundleStorage[0], 0666);
        }

        return $this->bundleStorage[0] . "/" . $fileName;
    }


    public function fileExists($file)
    {
        $fs = new Filesystem();
        return $fs->exists($file);
    }


    /**
     * Load a setting definition file
     *
     * Loads a setting definition file by hive [ and cluster name ],
     * parses the yaml content, and returns a SettingDefinition.
     *
     * @param string $hive
     * @param string $cluster
     * @return $this
     */
    public function loadFile($hive, $cluster = null)
    {
        $fileName = $this->buildFileName($hive, $cluster);

        if (!$file = $this->locateFile($fileName)) {
            throw new \Exception(
                sprintf(
                    "Settings Definition File '%s' does not exist in any of the following paths you specified for settings storage: %s",
                    $fileName,
                    implode(', ', $this->bundleStorage)
                )
            );
        }
        $yaml = new Parser();
        $fileContents = $yaml->parse(file_get_contents($file));
        $settingDefinition = $this->unserialize($fileContents);

        return $settingDefinition;
    }


    /**
     * Locate a setting definition file
     *
     * Checks each bundle defined in settings config, and the app/Resources
     * default path for a setting definition file. Returns the the file path
     * or false.
     *
     * @param string $filename
     * @return filepath|false
     */
    public function locateFile($fileName)
    {
        // Check each path for the file
        foreach ($this->bundleStorage as $key => $path) {
            // Standard path
            if ('@' != substr($path,0,1)) {
                if($this->fileExists($path . '/' . $fileName)) {
                     return $path . '/' . $fileName;
                }
            }
            // Bundle alias path (@BundleName/path/to/file)
            else {
                try {
                    return $this->kernel->locateResource($path . '/' . $fileName);
                }
                catch (\Exception $e) {
                }
            }
        }

        return false;
    }


    /**
     * Save a SettingDefinition to a yaml file
     *
     * @param SettingDefinition
     */
    public function saveFile(SettingDefinition $settingDefinition)
    {
        $fileName = $this->buildFileNameFromDefinition($settingDefinition);

        if (!$file = $this->locateFile($fileName)) {
            $file = $this->createFile($fileName);
        }

        $serializedDefinition = $this->serialize($settingDefinition);

        $validator = new DefinitionValidator($serializedDefinition, $this->settingsManager);
        $validator->validate();

        $dumper = new Dumper();
        $yaml = $dumper->dump($serializedDefinition, 5);

        $fs = new Filesystem();
        $fs->dumpFile($file, $yaml, 0666);

        return $this;
    }


    /**
     * Builds a file name based on a hive [ and cluster ].
     *
     * @param string $hive
     * @param string $cluster
     * @return string $filename
     */
    private function buildFileName($hive, $cluster = null)
    {
        $filename = (
            null !== $cluster ?
            $hive . '-' . $cluster . '.yml' :
            $hive . '.yml'
        );

        return $filename;
    }


    /**
     * Builds a file name based on setting definition.
     *
     * @param SettingDefinition
     * @return string $filename
     */
    private function buildFileNameFromDefinition(SettingDefinition $SettingDefinition)
    {
        $filename = (
            'cluster' == $SettingDefinition->getType() ?
            $SettingDefinition->getHive() . '-' . $SettingDefinition->getKey() . '.yml' :
            $SettingDefinition->getKey() . '.yml'
        );

        return $filename;
    }


    /**
     * Serialize a SettingDefinition
     *
     * Serializes a SettingDefinition so it can be saved to
     * a yaml file.
     *
     * @param SettingDefinition
     * @return array
     */
    private function serialize(SettingDefinition $settingDefinition)
    {
        $definitionNodes = $settingDefinition->getSettingNodes()->toArray();

        $serializedNodes = array();
        foreach ($definitionNodes as $node => $nodeData) {
            $serializedNodes[$node]['default']     = $nodeData->getDefault();
            $serializedNodes[$node]['description'] = $nodeData->getDescription();
            $serializedNodes[$node]['type']        = $nodeData->getType();
            foreach( $nodeData->getFormat()->dumpToArray() as $key => $val) {
                $serializedNodes[$node][$key] = $val;
            }
        }

        $serializedDefinition = array(
            $settingDefinition->getKey() => array(
                'hive'  => $settingDefinition->getHive(),
                'type'  => $settingDefinition->getType(),
                'nodes' => $serializedNodes
            )
        );

    /*    print "<pre>";
        print getType($serializedDefinition['theme']['nodes']['bar']['default']);
        print "\n";
        print_r($serializedDefinition);
        exit;*/

        return $serializedDefinition;
    }


    /**
     * Unserialize a setting definition yaml
     *
     * Serializes a SettingDefinition so it can be saved to
     * a yaml file.
     *
     * @param SettingDefinition
     * @return array
     */
    private function unserialize($fileContents)
    {
        $validator = new DefinitionValidator($fileContents, $this->settingsManager);
        $validator->validate();

        $key = array_keys($fileContents)[0];

        $settingDefinition = new SettingDefinition();
        $settingDefinition->setKey($key);
        $settingDefinition->setHive($fileContents[$key]['hive']);
        $settingDefinition->setType($fileContents[$key]['type']);

        foreach ($fileContents[$key]['nodes'] as $nodeName => $nodeAttributes) {
            $settingNode = new SettingNode(
                array(
                    'nodeName'       => $nodeName,
                    'nodeAttributes' => $nodeAttributes
                )
            );
            $settingDefinition->addSettingNode($settingNode);
        }

        return $settingDefinition;
    }

}