<?php

namespace Mesd\SettingsBundle\Model\Definition;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\Config\FileLocator;
use Symfony\Component\Yaml\Dumper;
use Symfony\Component\Yaml\Parser;
use Mesd\SettingsBundle\Model\Definition\DefinitionValidator;
use Mesd\SettingsBundle\Model\Definition\SettingDefinition;
use Mesd\SettingsBundle\Model\Definition\SettingNode;
use Mesd\SettingsBundle\Model\SettingManager;

class DefinitionManager
{

    private $bundleStorage;
    private $kernel;
    private $settingManager;


    public function __construct ($bundleStorage, $kernel, SettingManager $settingManager)
    {
        $this->bundleStorage   = $bundleStorage;
        $this->kernel          = $kernel;
        $this->settingManager  = $settingManager;
    }


    /**
     * Builds a file name based on a hive [ and cluster ].
     *
     * @param string $hiveName
     * @param string $clusterName
     * @return string $filename
     */
    public function buildFileName($hiveName, $clusterName = null)
    {
        $hive = $this->settingManager->loadHive($hiveName);

        $filename = (
            false === $hive->getDefinedAtHive() ?
            strtolower($hiveName) . '-' . strtolower($clusterName) . '.yml' :
            strtolower($hiveName) . '.yml'
        );

        return $filename;
    }


    /**
     * Builds a file name based on SettingDefinition.
     *
     * @param SettingDefinition
     * @return string $filename
     */
    private function buildFileNameFromDefinition(SettingDefinition $SettingDefinition)
    {
        $filename = (
            'cluster' == $SettingDefinition->getType() ?
            strtolower($SettingDefinition->getHive()) . '-' . strtolower($SettingDefinition->getKey()) . '.yml' :
            strtolower($SettingDefinition->getKey()) . '.yml'
        );

        return $filename;
    }


    /**
     * Create file path for new definition file
     *
     * Create a fully qualified file path for a new definition file
     * and ensure that the directory structure is in place. The actual
     * file will be created in the saveFile() method.
     *
     * @param string $fileName
     * @param string $filePath
     * @return string|Exception
     */
    public function createFile($fileName, $filePath = null)
    {
        if ($this->locateFile($fileName, $filePath)) {
            throw new \Exception(sprintf('File %s already exists', $fileName));
        }

        $storagePaths = ($filePath) ? array(0 => $filePath) : $this->bundleStorage;

        $fs = new Filesystem();

        // Standard path
        if ('@' != substr($storagePaths[0],0,1)) {
            $path = $storagePaths[0];
        }
        // Bundle alias path (@BundleName/path/to/file)
        else {
            try {
                $path = $this->kernel->locateResource($storagePaths[0]);
            }
            catch (\Exception $e) {
            }
        }

        if (!$path) {
            throw new \Exception(sprintf(
                'Could not create file %s',
                $storagePaths[0] . '/' . $fileName
            ));
        }

        if (!$fs->exists($path)) {
            $fs->mkdir($path, 0776);
        }

        return $path . '/' . $fileName;
    }


    /**
     * Determine if a given file exists
     *
     * @param string $file
     * @return boolean true|false
     */
    public function fileExists($file)
    {
        $fs = new Filesystem();
        return $fs->exists($file);
    }


    /**
     * Load a setting definition file
     *
     * Loads a setting definition file by hive [ and cluster name ],
     * parses the yaml content, and returns a SettingDefinition object.
     *
     * @param string $hiveName
     * @param string $clusterName
     * @return SettingDefinition
     */
    public function loadFile($hiveName, $clusterName = null)
    {
        $fileName = $this->buildFileName($hiveName, $clusterName);

        if (!$file = $this->locateFile($fileName)) {
            throw new \Exception(
                sprintf(
                    "Settings Definition File '%s' does not exist in any of the following paths you have configured for settings storage: %s",
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
     * Checks $filePath
     *   -or-
     * Each bundle defined in settings config and the app/Resources
     * default path for a setting definition file. Returns the the
     * fully qualifed file name or false.
     *
     * @param string $fileName
     * @param string $filePath
     * @return string|false
     */
    public function locateFile($fileName, $filePath = null)
    {
        $storagePaths = ($filePath) ? array(0 => $filePath) : $this->bundleStorage;

        // Check each path for the file
        foreach ($storagePaths as $key => $path) {
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
     * Saves a SettingDefinition to a yaml setting file. If the file
     * does not exist, it will be created. The SettingDefinition
     * will be validated before being saved.
     *
     * @param SettingDefinition
     * @return string $file
     */
    public function saveFile(SettingDefinition $settingDefinition)
    {
        $fileName = $this->buildFileNameFromDefinition($settingDefinition);

        if (!$file = $this->locateFile($fileName, $settingDefinition->getFilePath())) {
            $file = $this->createFile($fileName, $settingDefinition->getFilePath());
        }

        $serializedDefinition = $this->serialize($settingDefinition);

        $validator = new DefinitionValidator($serializedDefinition, $this->settingManager);
        $validator->validate();

        $dumper = new Dumper();
        $yaml = $dumper->dump($serializedDefinition, 5);

        $fs = new Filesystem();
        $fs->dumpFile($file, $yaml, 0666);

        return $file;
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

        return $serializedDefinition;
    }


    /**
     * Unserialize a setting definition yaml
     *
     * Unserializes a setting definition yaml file, validates the
     * content, and converts the data into a SettingDefinition.
     *
     * @param string $fileContents
     * @return SettingDefinition
     */
    private function unserialize($fileContents)
    {
        $validator = new DefinitionValidator($fileContents, $this->settingManager);
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


    /**
     * Get bundleStorage
     *
     * BundleStorage holds the aviable bundle paths and defualt
     * storage location for Setting Definition files.
     *
     * @return array $bundleStorage
     */
    public function getBundleStorage()
    {
        return $this->bundleStorage;
    }

}