<?php

namespace Fc\SettingsBundle\Model\Definition;


class DefinitionValidator
{

    private $file;
    private $fileContents;
    private $settingsManager;


    public function __construct (array $fileContents, $file, $settingsManager)
    {
        $this->file            = $file;
        $this->fileContents    = $fileContents;
        $this->settingsManager = $settingsManager;
    }


    public function validate()
    {
        $this->validateKey();
        $this->validateStructure();
        $this->validateNodes();

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
                    "Settings Definition File '%s' is missing the definition 'type' element",
                    $this->file
                )
            );
        }
        elseif ('hive'    != $this->fileContents[$key]['type'] &&
                'cluster' != $this->fileContents[$key]['type']    ) {
            throw new \Exception(
                sprintf(
                    "Settings Definition File '%s' has an invalid definition 'type' element",
                    $this->file
                )
            );
        }

        // Is hive set and valid?
        if (!array_key_exists('hive',$this->fileContents[$key])){
            throw new \Exception(
                sprintf(
                    "Settings Definition File '%s' is missing the definition 'hive' element",
                    $this->file
                )
            );
        }
        else {
            // Check if hive is defined in database
            if (!$this->settingsManager
                    ->hiveExists(
                        $this->fileContents[$key]['hive']
                    )
                ) {
                throw new \Exception(
                    sprintf(
                        "Settings Hive '%s' does not exisit",
                        $this->fileContents[$key]['hive']
                    )
                );
            }
        }

        //Check for any additional elements that should not exisit
        $elements = $this->fileContents[$key];
        unset($elements['type']);
        unset($elements['hive']);
        unset($elements['nodes']);
        if(0 < count(array_keys($elements))) {
            throw new \Exception(
                sprintf(
                    "Settings Definition File '%s' has invalid definition elements: %s",
                    $this->file,
                    implode(', ', array_keys($elements))
                )
            );
        }
    }


    private function validateNodes()
    {
        $key = array_keys($this->fileContents)[0];

        print "<pre>";
        foreach ($this->fileContents[$key]['nodes'] as $key => $val) {
            print "Key: " . $key . "\n";
            print_r($val);
        }
    }

}