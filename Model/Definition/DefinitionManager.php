<?php

namespace Fc\SettingsBundle\Model\Definition;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\Config\FileLocator;
use Symfony\Component\Yaml\Dumper;
use Symfony\Component\Yaml\Parser;
use Fc\SettingsBundle\Model\Definition\DefinitionValidator;
use Fc\SettingsBundle\Model\Definition\SettingDefinition;

class DefinitionManager
{

    private $bundleStorage;
    private $definition;
    private $file;
    private $kernel;


    public function __construct ($bundleStorage, $kernel)
    {
        $this->bundleStorage = $bundleStorage;
        $this->kernel        = $kernel;
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

/*
    public function createFile($fileName, $type)
    {
        if ($this->fileExists($fileName, $bundlePath)) {
            throw new \Exception(sprintf('File %s already exists', $this->file));
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
    }
*/


    public function fileExists($file)
    {
        $fs = new Filesystem();
        return $fs->exists($file);
    }


    public function loadFileByName($fileName)
    {
        $this->file = $this->locateFile($fileName);
        $yaml = new Parser();
        $fileContents = $yaml->parse(file_get_contents($this->file));
        $validator = new DefinitionValidator($fileContents, $this->file);
        $validator->validate();
        //$this->definition = new SettingDefinition($fileContents);

        return $this;
    }


    public function locateFile($fileName)
    {
        foreach ($this->bundleStorage as $key => $path) {
            if ('@' != substr($path,0,1)) {
                if($this->fileExists($path . '/' . $fileName . '.yml')) {
                     return $path . '/' . $fileName . '.yml';
                }
            }
            else {
                try {
                    return $this->kernel->locateResource($path . '/' . $fileName . '.yml');
                }
                catch (\Exception $e) {
                }
            }
        }

        // If we arrive here, the definition file was not found
        throw new \Exception(
            sprintf(
                "Settings Definition File '%s.yml' does not exist in any of the following paths you specified for settings storage: %s",
                $fileName,
                implode(', ', $this->bundleStorage)
            )
        );
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


    private function unserialize()
    {



    }

}