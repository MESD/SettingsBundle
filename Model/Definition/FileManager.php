<?php

namespace Fc\SettingsBundle\Model\Definition;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Dumper;
use Symfony\Component\Yaml\Parser;


class FileManager {

    private $bundleStorage;
    private $definition;
    private $file;
    private $fileDir;
    private $fileLocator;
    private $kernelRootDir;


    public function __construct ($kernelRootDir, $bundleStorage, $fileLocator)
    {
        $this->kernelRootDir = $kernelRootDir;
        $this->bundleStorage = $bundleStorage;
        $this->fileLocator   = $fileLocator;
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


    public function createFile ($fileName, $type)
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


    public function fileExists ()
    {
        $fs = new Filesystem();

        return $fs->exists($this->file);
    }


    public function load ()
    {
        if (!$this->fileExists($fileName, $bundlePath)) {
            throw new \Exception(sprintf('File %s doen\'t exist', $this->file));
        }

        $fs = new Filesystem();
        $yaml = new Parser();
        $this->definition = $yaml->parse(file_get_contents($this->file));

        return $this;
    }


    public function locateFile ($fileName)
    {
        if ($bundlePath) {
            $this->fileDir  = $bundlePath . '/Resources/settings/';
        }
        else {
            $this->fileDir  = $this->kernelRootDir . '/Resources/settings/';
        }

        $this->file = $this->fileDir . $fileName . '.yml';

        if (!$this->fileExists()) {
            throw new \Exception(sprintf('File %s does not exist', $this->file));
        }

        return $this;
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