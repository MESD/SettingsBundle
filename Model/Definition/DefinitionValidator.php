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
        $this->validateStructure();
        $this->validateNodes();

        print $this->file;
        print "<br />";
        print "<pre>";
        print_r($this->fileContents);
        exit;
    }


    private function validateStructure()
    {
        // Validate key element
        if(1 !== count(array_keys($this->fileContents))) {
            throw new \Exception(
                sprintf(
                    "Settings Definition File '%s' has more than one key element: %s",
                    $this->file,
                    implode(', ', array_keys($this->fileContents))
                )
            );
        }

        $key = array_keys($this->fileContents)[0];

        // Is type set and valid?
        if (!array_key_exists('type', $this->fileContents[$key])){
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
        if (!array_key_exists('hive', $this->fileContents[$key])){
            throw new \Exception(
                sprintf(
                    "Settings Definition File '%s' is missing the definition 'hive' element",
                    $this->file
                )
            );
        }
        elseif ('hive' == $this->fileContents[$key]['type'] &&
                $key   != $this->fileContents[$key]['hive']    ) {
            throw new \Exception(
                sprintf(
                    "Settings Definition File '%s' has a type of 'hive' buy the key element and hive element do not match. Key: %s, Hive: %s",
                    $this->file,
                    $key,
                    $this->fileContents[$key]['hive']
                )
            );
        }
        // Check if hive is defined in database
        else {
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

        // If type is cluster, check if cluster is defined in database
        if ('cluster' == $this->fileContents[$key]['type']) {
            if (!$this->settingsManager
                    ->clusterExists(
                        $this->fileContents[$key]['hive'],
                        $key
                    )
                ) {
                throw new \Exception(
                    sprintf(
                        "Settings Cluster '%s' does not exisit",
                        $key
                    )
                );
            }
        }


        // Check for any additional elements that should not exisit
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

        foreach ($this->fileContents[$key]['nodes'] as $node => $attributes) {

            // Is type set and valid?
            if (!array_key_exists('type', $attributes)) {
                throw new \Exception(
                    sprintf(
                        "Settings Definition File '%s' is missing the 'type' element for node '%s'",
                        $this->file,
                        $node
                    )
                );
            }
            elseif (!in_array(
                        $attributes['type'],
                        array('array', 'boolean', 'float', 'integer', 'string'))
                    ) {
                throw new \Exception(
                    sprintf(
                        "Settings Definition File '%s' has an invalid 'type' element on node '%s'",
                        $this->file,
                        $node
                    )
                );
            }

            // Perform node type specific validation
            $methodName = 'validateNode' . ucwords($attributes['type']);
            $this->$methodName($node, $attributes);
        }
    }


    private function validateNodeArray($nodeName, $nodeAttributes)
    {
        // Is prototype set?
        if (!array_key_exists('prototype', $nodeAttributes)) {
            throw new \Exception(
                sprintf(
                    "Settings Definition File '%s' is missing the 'prototype' element for array node '%s'",
                    $this->file,
                    $nodeName
                )
            );
        }
        // Is prototype 'type' set?
        elseif (!array_key_exists('type', $nodeAttributes['prototype'])) {
            throw new \Exception(
                sprintf(
                    "Settings Definition File '%s' is missing the 'type' element for array prototype on node '%s'",
                    $this->file,
                    $nodeName
                )
            );
        }
        // Is prototype 'type' valid?
        elseif (!in_array(
                    $nodeAttributes['prototype']['type'],
                    array('boolean', 'float', 'integer', 'string'))
                ) {
            throw new \Exception(
                sprintf(
                    "Settings Definition File '%s' has an invalid 'type' element for array prototype on node '%s'",
                    $this->file,
                    $nodeName
                )
            );
        }
        // Perform node prototype specific validation
        else {
            $methodName = 'validateNode' . ucwords($nodeAttributes['prototype']['type']);
            $this->$methodName($nodeName, $nodeAttributes['prototype']);
        }

        // If default is set
        if (array_key_exists('default', $nodeAttributes)) {

            // Is default an array?
            if (!is_array($nodeAttributes['default'])) {
                throw new \Exception(
                    sprintf(
                        "Settings Definition File '%s' has an invalid 'default' element value on node '%s'. Expected type array, found type %s",
                        $this->file,
                        $nodeName,
                        gettype($nodeAttributes['default'])
                    )
                );
            }

            // Check each item in default array
            foreach ($nodeAttributes['default'] as $key => $val ) {

                $type = ('double' == gettype($val) ? 'float' : gettype($val));

                //  Ensure value matches type
                if ($type != $nodeAttributes['prototype']['type']) {
                    throw new \Exception(
                        sprintf(
                            "Settings Definition File '%s' has an invalid 'default' element value on array node '%s'. Expected type '%s', found type %s",
                            $this->file,
                            $nodeName,
                            $nodeAttributes['prototype']['type'],
                            $type
                        )
                    );
                }

                // Ensure value matches format
                // String
                if ('string' == $nodeAttributes['prototype']['type'] &&
                    strlen($val) > $nodeAttributes['prototype']['length']) {
                    throw new \Exception(
                        sprintf(
                            "Settings Definition File '%s' has an invalid 'default' element value on array node '%s'. Expected %u chars max, found %u chars",
                            $this->file,
                            $nodeName,
                            $nodeAttributes['prototype']['length'],
                            strlen($val)
                        )
                    );
                }
                // Integer
                elseif ('integer' == $nodeAttributes['prototype']['type'] &&
                    strlen($val) > $nodeAttributes['prototype']['digits']) {
                    throw new \Exception(
                        sprintf(
                            "Settings Definition File '%s' has an invalid 'default' element value on array node '%s'. Expected %u digits max, found %u digits",
                            $this->file,
                            $nodeName,
                            $nodeAttributes['prototype']['digits'],
                            strlen($val)
                        )
                    );
                }
                // Float
                elseif ('float' == $nodeAttributes['prototype']['type']) {

                    $floatParts = preg_split('/\./', $val, 2);

                    // Check digits
                    if (strlen($floatParts[0]) > $nodeAttributes['prototype']['digits']) {
                        throw new \Exception(
                            sprintf(
                                "Settings Definition File '%s' has an invalid 'default' element value on array node '%s'. Expected %u digits max, found %u digits",
                                $this->file,
                                $nodeName,
                                $nodeAttributes['prototype']['digits'],
                                strlen($floatParts[0])
                            )
                        );
                    }

                    // Check precision, if needed
                    if (2 == count($floatParts)) {
                        if (strlen($floatParts[1]) > $nodeAttributes['prototype']['precision']) {
                            throw new \Exception(
                                sprintf(
                                    "Settings Definition File '%s' has an invalid 'default' element value on array node '%s'. Expected %u precision digits max, found %u precision digits",
                                    $this->file,
                                    $nodeName,
                                    $nodeAttributes['prototype']['precision'],
                                    strlen($floatParts[1])
                                )
                            );
                        }
                    }
                }
            }
        }


        // Check for any additional elements that should not exisit
        unset($nodeAttributes['type']);
        unset($nodeAttributes['prototype']);
        unset($nodeAttributes['default']);
        if(0 < count(array_keys($nodeAttributes))) {
            throw new \Exception(
                sprintf(
                    "Settings Definition File '%s' has invalid elements for node '%s': %s",
                    $this->file,
                    $nodeName,
                    implode(', ', array_keys($nodeAttributes))
                )
            );
        }

    }


    private function validateNodeBoolean($nodeName, $nodeAttributes)
    {
        // If default is set, ensure it's type is boolean
        if (array_key_exists('default', $nodeAttributes) &&
            !is_bool($nodeAttributes['default'])            ) {
            throw new \Exception(
                sprintf(
                    "Settings Definition File '%s' has an invalid 'default' element value on node '%s'. Expected type boolean, found type %s",
                    $this->file,
                    $nodeName,
                    gettype($nodeAttributes['default'])
                )
            );
        }

        // Check for any additional elements that should not exisit
        unset($nodeAttributes['type']);
        unset($nodeAttributes['default']);
        if(0 < count(array_keys($nodeAttributes))) {
            throw new \Exception(
                sprintf(
                    "Settings Definition File '%s' has invalid elements for boolean node '%s': %s",
                    $this->file,
                    $nodeName,
                    implode(', ', array_keys($nodeAttributes))
                )
            );
        }

    }


    private function validateNodeFloat($nodeName, $nodeAttributes)
    {
        // Is digits set and valid?
        if (!array_key_exists('digits', $nodeAttributes)) {
            throw new \Exception(
                sprintf(
                    "Settings Definition File '%s' is missing the 'digits' element for float node '%s'",
                    $this->file,
                    $nodeName
                )
            );
        }
        elseif (!is_int($nodeAttributes['digits'])) {
            throw new \Exception(
                sprintf(
                    "Settings Definition File '%s' has an invalid 'digits' element value on node '%s'. Expected type integer, found type %s",
                    $this->file,
                    $nodeName,
                    gettype($nodeAttributes['digits'])
                )
            );
        }

        // Is precision set and valid?
        if (!array_key_exists('precision', $nodeAttributes)) {
            throw new \Exception(
                sprintf(
                    "Settings Definition File '%s' is missing the 'precision' element for float node '%s'",
                    $this->file,
                    $nodeName
                )
            );
        }
        elseif (!is_int($nodeAttributes['precision'])) {
            throw new \Exception(
                sprintf(
                    "Settings Definition File '%s' has an invalid 'precision' element value on node '%s'. Expected type integer, found type %s",
                    $this->file,
                    $nodeName,
                    gettype($nodeAttributes['digits'])
                )
            );
        }

        // If default is set
        if (array_key_exists('default', $nodeAttributes)) {

            // Ensure it's type is float
            if (!is_float($nodeAttributes['default'])) {
                throw new \Exception(
                    sprintf(
                        "Settings Definition File '%s' has an invalid 'default' element value on node '%s'. Expected type float, found type %s",
                        $this->file,
                        $nodeName,
                        gettype($nodeAttributes['default'])
                    )
                );
            }

            // Ensure float matches digits and precision
            $floatParts = preg_split('/\./', $nodeAttributes['default'], 2);

            // Check digits
            if (strlen($floatParts[0]) > $nodeAttributes['digits']) {
                throw new \Exception(
                    sprintf(
                        "Settings Definition File '%s' has an invalid 'default' element value on node '%s'. Expected %u digits max, found %u digits",
                        $this->file,
                        $nodeName,
                        $nodeAttributes['digits'],
                        strlen($floatParts[0])
                    )
                );
            }

            // Check precision, if needed
            if (2 == count($floatParts)) {
                if (strlen($floatParts[1]) > $nodeAttributes['precision']) {
                    throw new \Exception(
                        sprintf(
                            "Settings Definition File '%s' has an invalid 'default' element value on node '%s'. Expected %u precision digits max, found %u precision digits",
                            $this->file,
                            $nodeName,
                            $nodeAttributes['precision'],
                            strlen($floatParts[1])
                        )
                    );
                }
            }
        }

        // Check for any additional elements that should not exisit
        unset($nodeAttributes['type']);
        unset($nodeAttributes['default']);
        unset($nodeAttributes['digits']);
        unset($nodeAttributes['precision']);
        if(0 < count(array_keys($nodeAttributes))) {
            throw new \Exception(
                sprintf(
                    "Settings Definition File '%s' has invalid elements for float node '%s': %s",
                    $this->file,
                    $nodeName,
                    implode(', ', array_keys($nodeAttributes))
                )
            );
        }

    }


    private function validateNodeInteger($nodeName, $nodeAttributes)
    {
        // Is digits set and valid?
        if (!array_key_exists('digits', $nodeAttributes)) {
            throw new \Exception(
                sprintf(
                    "Settings Definition File '%s' is missing the 'digits' element for integer node '%s'",
                    $this->file,
                    $nodeName
                )
            );
        }
        elseif (!is_int($nodeAttributes['digits'])) {
            throw new \Exception(
                sprintf(
                    "Settings Definition File '%s' has an invalid 'digits' element value on node '%s'. Expected type integer, found type %s",
                    $this->file,
                    $nodeName,
                    gettype($nodeAttributes['digits'])
                )
            );
        }

        // If default is set
        if (array_key_exists('default', $nodeAttributes)) {

            // Ensure it's type is integer
            if(!is_int($nodeAttributes['default'])) {
                throw new \Exception(
                    sprintf(
                        "Settings Definition File '%s' has an invalid 'default' element value on node '%s'. Expected type integer, found type %s",
                        $this->file,
                        $nodeName,
                        gettype($nodeAttributes['default'])
                    )
                );
            }

            // Check digits
            if (strlen($nodeAttributes['default']) > $nodeAttributes['digits']) {
                throw new \Exception(
                    sprintf(
                        "Settings Definition File '%s' has an invalid 'default' element value on node '%s'. Expected %u digits max, found %u digits",
                        $this->file,
                        $nodeName,
                        $nodeAttributes['digits'],
                        strlen($nodeAttributes['default'])
                    )
                );
            }

        }

        // Check for any additional elements that should not exisit
        unset($nodeAttributes['type']);
        unset($nodeAttributes['default']);
        unset($nodeAttributes['digits']);
        if(0 < count(array_keys($nodeAttributes))) {
            throw new \Exception(
                sprintf(
                    "Settings Definition File '%s' has invalid elements for integer node '%s': %s",
                    $this->file,
                    $nodeName,
                    implode(', ', array_keys($nodeAttributes))
                )
            );
        }

    }


    private function validateNodeString($nodeName, $nodeAttributes)
    {
        // Is length set and valid?
        if (!array_key_exists('length', $nodeAttributes)) {
            throw new \Exception(
                sprintf(
                    "Settings Definition File '%s' is missing the 'length' element for string node '%s'",
                    $this->file,
                    $nodeName
                )
            );
        }
        elseif (!is_int($nodeAttributes['length'])) {
            throw new \Exception(
                sprintf(
                    "Settings Definition File '%s' has an invalid 'length' element value on node '%s'. Expected type integer, found type %s",
                    $this->file,
                    $nodeName,
                    gettype($nodeAttributes['length'])
                )
            );
        }

        // If default is set
        if (array_key_exists('default', $nodeAttributes)) {

            // Ensure it's type is string
            if(!is_string($nodeAttributes['default'])) {
                throw new \Exception(
                    sprintf(
                        "Settings Definition File '%s' has an invalid 'default' element value on node '%s'. Expected type string, found type %s",
                        $this->file,
                        $nodeName,
                        gettype($nodeAttributes['default'])
                    )
                );
            }

             // Check length
            if (strlen($nodeAttributes['default']) > $nodeAttributes['length']) {
                throw new \Exception(
                    sprintf(
                        "Settings Definition File '%s' has an invalid 'default' element value on node '%s'. Expected %u chars max, found %u chars",
                        $this->file,
                        $nodeName,
                        $nodeAttributes['length'],
                        strlen($nodeAttributes['default'])
                    )
                );
            }
        }

        // Check for any additional elements that should not exisit
        unset($nodeAttributes['type']);
        unset($nodeAttributes['length']);
        unset($nodeAttributes['default']);
        if(0 < count(array_keys($nodeAttributes))) {
            throw new \Exception(
                sprintf(
                    "Settings Definition File '%s' has invalid elements for string node '%s': %s",
                    $this->file,
                    $nodeName,
                    implode(', ', array_keys($nodeAttributes))
                )
            );
        }
    }

}