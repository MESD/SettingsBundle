<?php

namespace Fc\SettingsBundle\Model\Definition;


class DefinitionValidator
{

    private $file;
    private $fileContents;


    public function __construct (array $fileContents, $file)
    {
        $this->file         = $file;
        $this->fileContents = $fileContents;
    }

    public function validate()
    {
        $this->validateKey();
        $this->validateStructure();

        print $this->file;
        print "<br />";
        print "<pre>";
        print_r($this->fileContents);
        exit;
    }


    private function validateKey()
    {
        if(1 !== count(array_keys($this->fileContents))) {
            throw new \Exception(
                sprintf(
                    "Settings Definition File '%s' has more than one key element: %s",
                    $this->file,
                    implode(', ', array_keys($this->fileContents))
                )
            );
        }
    }

    private function validateStructure()
    {
        $key = array_keys($this->fileContents)[0];

        // Is type set and valid?
        if (!array_key_exists('type',$this->fileContents[$key])){
            throw new \Exception(
                sprintf(
                    "Settings Definition File '%s' is missing the 'type' element",
                    $this->file
                )
            );
        }
        elseif ('hive'    != $this->fileContents[$key]['type'] &&
                'cluster' != $this->fileContents[$key]['type']    ) {
            throw new \Exception(
                sprintf(
                    "Settings Definition File '%s' has an invalid 'type'",
                    $this->file
                )
            );
        }


    }


    private function validateNodes()
    {
        //print "<pre>";
        foreach ($this->fileContents as $key => $val) {
            print_r($val);
        }

    }

}