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
    private $definition;
    private $file;
    private $kernel;
    private $settingsManager;


    public function __construct ($bundleStorage, $kernel, $settingsManager)
    {
        $this->bundleStorage   = $bundleStorage;
        $this->kernel          = $kernel;
        $this->settingsManager = $settingsManager;
    }


    public function getDefinition()
    {
        return $this->definition;
    }


    public function setDefinition(SettingDefinition $definition)
    {
        $this->definition = $definition;

        return $this;
    }


/*    public function createFile($fileName, $type, $bundle = null)
    {
        if ($this->file = $this->locateFile($fileName)) {
            throw new \Exception(sprintf('File %s already exists', $this->file));
        }

        $fs = new Filesystem();

        print $this->file;exit;

        if (!$fs->exists($this->fileDir)) {
            $fs->mkdir($this->fileDir, 0666);
        }

        $rootNode = ('cluster' === $type ? explode("-", $fileName)[1] : explode("-", $fileName)[0]);

        $this->definition = array(
            $rootNode => array(
                'type' => $type,
                'nodes' => array()
            )
        );

        $dumper = new Dumper();
        $yaml = $dumper->dump($this->definition, 5);

        $fs->dumpFile($this->file, $yaml, 0666);

        return $this;
    }*/



    public function fileExists($file)
    {
        $fs = new Filesystem();
        return $fs->exists($file);
    }


    /**
     * Load a setting definition file by hive [ and cluster name ]
     *
     * @param string $hive
     * @param string $cluster
     * @return $this
     */
    public function loadFile($hive, $cluster = null)
    {
        $fileName = $this->buildFileName($hive, $cluster);

        if (!$this->file = $this->locateFile($fileName)) {
            throw new \Exception(
                sprintf(
                    "Settings Definition File '%s' does not exist in any of the following paths you specified for settings storage: %s",
                    $fileName,
                    implode(', ', $this->bundleStorage)
                )
            );
        }
        $yaml = new Parser();
        $fileContents = $yaml->parse(file_get_contents($this->file));
        $this->definition = $this->unserialize($fileContents);

        return $this;
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



    public function saveFile(SettingDefinition $settingDefinition)
    {
        $fileName = $this->buildFileNameFromDefinition();

        if (!$fullQualifiedFileName = $this->locateFile($fileName)) {
            $fullQualifiedFileName = createFile();
        }

        $serializedDefinition = $this->serialize($settingDefinition);

        $validator = new DefinitionValidator($serializedDefinition, $this->settingsManager);
        $validator->validate();

        $dumper = new Dumper();
        $yaml = $dumper->dump($serializedDefinition, 5);

        $fs = new Filesystem();
        $fs->dumpFile($this->file, $yaml, 0666);

        return $this;
    }


    private function buildFileName($hive, $cluster = null)
    {
        $filename = (
            null !== $cluster ?
            $hive . '-' . $cluster . '.yml' :
            $hive . '.yml'
        );

        return $filename;
    }


    private function buildFileNameFromDefinition()
    {
        if (!$this->definition instanceof SettingDefinition) {
            throw new \Exception(
                sprintf(
                    "Expected setting definition to be an instance of %s, but found: %s",
                    'Fc\SettingsBundle\Model\Definition\SettingDefinition',
                    (is_object($this->definition)) ? get_class($this->definition) : gettype($this->definition)
                )
            );
        }

        $filename = (
            'cluster' == $this->definition->getType() ?
            $this->definition->getHive() . '-' . $this->definition->getKey() . '.yml' :
            $this->definition->getKey() . '.yml'
        );

        return $filename;
    }


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

        return $serializedDefinition;
    }


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