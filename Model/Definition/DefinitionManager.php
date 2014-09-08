<?php

namespace Fc\SettingsBundle\Model\Definition;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\Config\FileLocator;
use Symfony\Component\Yaml\Dumper;
use Symfony\Component\Yaml\Parser;
use Fc\SettingsBundle\Model\Definition\SettingDefinition;
use Fc\SettingsBundle\Model\Definition\SettingDefinitionFile;


class DefinitionManager {

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



    public function fileExists($file)
    {
        $fs = new Filesystem();
        return $fs->exists($file);
    }


    public function loadFileByName($fileName)
    {
        $this->locateFile($fileName);

        print $this->file;exit;

        $fs = new Filesystem();
        $yaml = new Parser();
        $this->definition = $yaml->parse(file_get_contents($this->file));

        return $this;
    }


    public function locateFile($fileName)
    {
        foreach ($this->bundleStorage as $key => $path) {
            if ('@' != substr($path,0,1)) {
                if($this->fileExists($path . '/' . $fileName . '.yml')) {
                    $this->file = $path . '/' . $fileName . '.yml';
                    return $this;
                }
            }
            else {
                try {
                    $this->file = $this->kernel->locateResource($path . '/' . $fileName . '.yml');
                    return $this;
                }
                catch (\Exception $e) {
                }
            }
        }

        throw new \Exception(
            sprintf(
                "Settings Definition File '%s.yml' does not exist in any of the following paths: %s",
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
}