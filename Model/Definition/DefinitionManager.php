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


    public function setDefinition($definition)
    {
        $this->definition = $definition;

        return $this;
    }


    public function createFile($fileName, $type, $bundle = null)
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
    }



    public function fileExists($file)
    {
        $fs = new Filesystem();
        return $fs->exists($file);
    }


    /**
     * Load a setting defintion file by name
     *
     * @param string $filename
     * @return $this
     */
    public function loadFileByName($fileName)
    {
        if (!$this->file = $this->locateFile($fileName)) {
            throw new \Exception(
                sprintf(
                    "Settings Definition File '%s.yml' does not exist in any of the following paths you specified for settings storage: %s",
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
     * Locate a setting defintion file
     *
     * Checks each bundle defined in settings config, and the app/Resources
     * default path for a setting defintion file. Returns the the file path
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
                if($this->fileExists($path . '/' . $fileName . '.yml')) {
                     return $path . '/' . $fileName . '.yml';
                }
            }
            // Bundle alias path (@BundleName/path/to/file)
            else {
                try {
                    return $this->kernel->locateResource($path . '/' . $fileName . '.yml');
                }
                catch (\Exception $e) {
                }
            }
        }

        return false;
    }



/*    public function saveFile()
    {
        if (!$this->fileExists($fileName, $bundlePath)) {
            throw new \Exception(sprintf('File %s doen\'t exist', $this->file));
        }

        $fs = new Filesystem();

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


    private function unserialize($fileContents)
    {
        $validator = new DefinitionValidator($fileContents, $this->file, $this->settingsManager);
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