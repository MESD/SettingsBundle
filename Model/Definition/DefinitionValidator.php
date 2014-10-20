<?php

namespace Mesd\SettingsBundle\Model\Definition;


class DefinitionValidator
{
    private $definition;
    private $settingsManager;


    public function __construct (array $definition, $settingsManager)
    {
        $this->definition      = $definition;
        $this->settingsManager = $settingsManager;
    }


    public function validate()
    {
        $this->validateStructure();
        $this->validateNodes();
    }


    private function validateStructure()
    {
        // Validate key element
        if(1 !== count(array_keys($this->definition))) {
            throw new \Exception(
                sprintf(
                    "Settings Definition has more than one key element: %s",
                    implode(', ', array_keys($this->definition))
                )
            );
        }

        $key = array_keys($this->definition)[0];

        // Is type set and valid?
        if (!array_key_exists('type', $this->definition[$key])){
            throw new \Exception(
                sprintf(
                    "Settings Definition '%s' is missing the definition 'type' element",
                    $key
                )
            );
        }
        elseif ('hive'    != $this->definition[$key]['type'] &&
                'cluster' != $this->definition[$key]['type']    ) {
            throw new \Exception(
                sprintf(
                    "Settings Definition '%s' has an invalid definition 'type' element",
                    $key
                )
            );
        }

        // Is hive set and valid?
        if (!array_key_exists('hive', $this->definition[$key])){
            throw new \Exception(
                sprintf(
                    "Settings Definition '%s' is missing the definition 'hive' element",
                    $key
                )
            );
        }
        elseif ('hive' == $this->definition[$key]['type'] &&
                $key   != $this->definition[$key]['hive']    ) {
            throw new \Exception(
                sprintf(
                    "Settings Definition has type 'hive', but the key element and hive element do not match. Key: %s, Hive: %s",
                    $key,
                    $this->definition[$key]['hive']
                )
            );
        }
        // Check if hive is defined in database
        else {
            if (!$this->settingsManager
                    ->hiveExists(
                        $this->definition[$key]['hive']
                    )
                ) {
                throw new \Exception(
                    sprintf(
                        "Settings Hive '%s' does not exist.",
                        $this->definition[$key]['hive']
                    )
                );
            }
        }

        // If type is cluster, check if cluster is defined in database
        if ('cluster' == $this->definition[$key]['type']) {
            if (!$this->settingsManager
                    ->clusterExists(
                        $this->definition[$key]['hive'],
                        $key
                    )
                ) {
                throw new \Exception(
                    sprintf(
                        "Settings Cluster '%s' does not exist.",
                        $key
                    )
                );
            }
        }


        // Check for any additional elements that should not exisit
        $elements = $this->definition[$key];
        unset($elements['type']);
        unset($elements['hive']);
        unset($elements['nodes']);
        if(0 < count(array_keys($elements))) {
            throw new \Exception(
                sprintf(
                    "Settings Definition '%s' has invalid definition elements: %s",
                    $key,
                    implode(', ', array_keys($elements))
                )
            );
        }
    }


    private function validateNodes()
    {
        $key = array_keys($this->definition)[0];

        foreach ($this->definition[$key]['nodes'] as $node => $attributes) {

            // Is type set and valid?
            if (!array_key_exists('type', $attributes)) {
                throw new \Exception(
                    sprintf(
                        "Settings Definition '%s' is missing the 'type' element for node '%s'",
                        $key,
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
                        "Settings Definition '%s' has an invalid 'type' element on node '%s'",
                        $key,
                        $node
                    )
                );
            }

            // Perform node type specific validation
            $methodName = 'validateNode' . ucwords($attributes['type']);
            $this->$methodName($node, $attributes, $key);
        }
    }


    private function validateNodeArray($nodeName, $nodeAttributes, $key)
    {
        // Is prototype set?
        if (!array_key_exists('prototype', $nodeAttributes)) {
            throw new \Exception(
                sprintf(
                    "Settings Definition '%s' is missing the 'prototype' element for array node '%s'",
                    $key,
                    $nodeName
                )
            );
        }
        // Is prototype 'type' set?
        elseif (!array_key_exists('type', $nodeAttributes['prototype'])) {
            throw new \Exception(
                sprintf(
                    "Settings Definition '%s' is missing the 'type' element for array prototype on node '%s'",
                    $key,
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
                    "Settings Definition '%s' has an invalid 'type' element for array prototype on node '%s'",
                    $key,
                    $nodeName
                )
            );
        }
        // Perform node prototype specific validation
        else {
            $methodName = 'validateNode' . ucwords($nodeAttributes['prototype']['type']);
            $this->$methodName($nodeName, $nodeAttributes['prototype'], $key);
        }

        // If default is set
        if (array_key_exists('default', $nodeAttributes) && !is_null($nodeAttributes['default'])) {

            // Is default an array?
            if (!is_array($nodeAttributes['default'])) {
                throw new \Exception(
                    sprintf(
                        "Settings Definition '%s' has an invalid 'default' element value on node '%s'. Expected type array, found type %s",
                        $key,
                        $nodeName,
                        gettype($nodeAttributes['default'])
                    )
                );
            }

            // Check each item in default array
            foreach ($nodeAttributes['default'] as $k => $val ) {

                $type = ('double' == gettype($val) ? 'float' : gettype($val));

                //  Ensure value matches type
                if ($type != $nodeAttributes['prototype']['type']) {
                    throw new \Exception(
                        sprintf(
                            "Settings Definition '%s' has an invalid 'default' element value on array node '%s', key %u. Expected type '%s', found type %s",
                            $key,
                            $nodeName,
                            $k,
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
                            "Settings Definition '%s' has an invalid 'default' element value on array node '%s', key %u. Expected %u chars max, found %u chars",
                            $key,
                            $nodeName,
                            $k,
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
                            "Settings Definition '%s' has an invalid 'default' element value on array node '%s', key %u. Expected %u digits max, found %u digits",
                            $key,
                            $nodeName,
                            $k,
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
                                "Settings Definition '%s' has an invalid 'default' element value on array node '%s', key %u. Expected %u digits max, found %u digits",
                                $key,
                                $nodeName,
                                $k,
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
                                    "Settings Definition '%s' has an invalid 'default' element value on array node '%s', key %u. Expected %u precision digits max, found %u precision digits",
                                    $key,
                                    $nodeName,
                                    $k,
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
        unset($nodeAttributes['description']);
        if(0 < count(array_keys($nodeAttributes))) {
            throw new \Exception(
                sprintf(
                    "Settings Definition '%s' has invalid elements for node '%s': %s",
                    $key,
                    $nodeName,
                    implode(', ', array_keys($nodeAttributes))
                )
            );
        }

    }


    private function validateNodeBoolean($nodeName, $nodeAttributes, $key)
    {
        // If default is set, ensure it's type is boolean
        if (array_key_exists('default', $nodeAttributes) &&
            !is_bool($nodeAttributes['default']) &&
            !is_null($nodeAttributes['default'])) {
            throw new \Exception(
                sprintf(
                    "Settings Definition '%s' has an invalid 'default' element value on node '%s'. Expected type boolean, found type %s",
                    $key,
                    $nodeName,
                    gettype($nodeAttributes['default'])
                )
            );
        }

        // Check for any additional elements that should not exisit
        unset($nodeAttributes['type']);
        unset($nodeAttributes['default']);
        unset($nodeAttributes['description']);
        if(0 < count(array_keys($nodeAttributes))) {
            throw new \Exception(
                sprintf(
                    "Settings Definition '%s' has invalid elements for boolean node '%s': %s",
                    $key,
                    $nodeName,
                    implode(', ', array_keys($nodeAttributes))
                )
            );
        }

    }


    private function validateNodeFloat($nodeName, $nodeAttributes, $key)
    {
        // Is digits set and valid?
        if (!array_key_exists('digits', $nodeAttributes)) {
            throw new \Exception(
                sprintf(
                    "Settings Definition '%s' is missing the 'digits' element for float node '%s'",
                    $key,
                    $nodeName
                )
            );
        }
        elseif (!is_int($nodeAttributes['digits'])) {
            throw new \Exception(
                sprintf(
                    "Settings Definition '%s' has an invalid 'digits' element value on node '%s'. Expected type integer, found type %s",
                    $key,
                    $nodeName,
                    gettype($nodeAttributes['digits'])
                )
            );
        }

        // Is precision set and valid?
        if (!array_key_exists('precision', $nodeAttributes)) {
            throw new \Exception(
                sprintf(
                    "Settings Definition '%s' is missing the 'precision' element for float node '%s'",
                    $key,
                    $nodeName
                )
            );
        }
        elseif (!is_int($nodeAttributes['precision'])) {
            throw new \Exception(
                sprintf(
                    "Settings Definition '%s' has an invalid 'precision' element value on node '%s'. Expected type integer, found type %s",
                    $key,
                    $nodeName,
                    gettype($nodeAttributes['digits'])
                )
            );
        }

        // If default is set
        if (array_key_exists('default', $nodeAttributes)) {

            // Ensure it's type is float or int
            if (!is_float($nodeAttributes['default']) &&
                !is_int($nodeAttributes['default']) &&
                !is_null($nodeAttributes['default'])) {
                throw new \Exception(
                    sprintf(
                        "Settings Definition '%s' has an invalid 'default' element value on node '%s'. Expected type float, found type %s",
                        $key,
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
                        "Settings Definition '%s' has an invalid 'default' element value on node '%s'. Expected %u digits max, found %u digits",
                        $key,
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
                            "Settings Definition '%s' has an invalid 'default' element value on node '%s'. Expected %u precision digits max, found %u precision digits",
                            $key,
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
        unset($nodeAttributes['description']);
        if(0 < count(array_keys($nodeAttributes))) {
            throw new \Exception(
                sprintf(
                    "Settings Definition '%s' has invalid elements for float node '%s': %s",
                    $key,
                    $nodeName,
                    implode(', ', array_keys($nodeAttributes))
                )
            );
        }

    }


    private function validateNodeInteger($nodeName, $nodeAttributes, $key)
    {
        // Is digits set and valid?
        if (!array_key_exists('digits', $nodeAttributes)) {
            throw new \Exception(
                sprintf(
                    "Settings Definition '%s' is missing the 'digits' element for integer node '%s'",
                    $key,
                    $nodeName
                )
            );
        }
        elseif (!is_int($nodeAttributes['digits'])) {
            throw new \Exception(
                sprintf(
                    "Settings Definition '%s' has an invalid 'digits' element value on node '%s'. Expected type integer, found type %s",
                    $key,
                    $nodeName,
                    gettype($nodeAttributes['digits'])
                )
            );
        }

        // If default is set
        if (array_key_exists('default', $nodeAttributes)) {

            // Ensure it's type is integer
            if(!is_int($nodeAttributes['default']) && !is_null($nodeAttributes['default'])) {
                throw new \Exception(
                    sprintf(
                        "Settings Definition '%s' has an invalid 'default' element value on node '%s'. Expected type integer, found type %s",
                        $key,
                        $nodeName,
                        gettype($nodeAttributes['default'])
                    )
                );
            }

            // Check digits
            if (strlen($nodeAttributes['default']) > $nodeAttributes['digits']) {
                throw new \Exception(
                    sprintf(
                        "Settings Definition '%s' has an invalid 'default' element value on node '%s'. Expected %u digits max, found %u digits",
                        $key,
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
        unset($nodeAttributes['description']);
        if(0 < count(array_keys($nodeAttributes))) {
            throw new \Exception(
                sprintf(
                    "Settings Definition '%s' has invalid elements for integer node '%s': %s",
                    $key,
                    $nodeName,
                    implode(', ', array_keys($nodeAttributes))
                )
            );
        }
    }


    private function validateNodeString($nodeName, $nodeAttributes, $key)
    {
        // Is length set and valid?
        if (!array_key_exists('length', $nodeAttributes)) {
            throw new \Exception(
                sprintf(
                    "Settings Definition '%s' is missing the 'length' element for string node '%s'",
                    $key,
                    $nodeName
                )
            );
        }
        elseif (!is_int($nodeAttributes['length'])) {
            throw new \Exception(
                sprintf(
                    "Settings Definition '%s' has an invalid 'length' element value on node '%s'. Expected type integer, found type %s",
                    $key,
                    $nodeName,
                    gettype($nodeAttributes['length'])
                )
            );
        }

        // If default is set
        if (array_key_exists('default', $nodeAttributes)) {

            // Ensure it's type is string
            if(!is_string($nodeAttributes['default']) && !is_null($nodeAttributes['default'])) {
                throw new \Exception(
                    sprintf(
                        "Settings Definition '%s' has an invalid 'default' element value on node '%s'. Expected type string, found type %s",
                        $key,
                        $nodeName,
                        gettype($nodeAttributes['default'])
                    )
                );
            }

             // Check length
            if (strlen($nodeAttributes['default']) > $nodeAttributes['length']) {
                throw new \Exception(
                    sprintf(
                        "Settings Definition '%s' has an invalid 'default' element value on node '%s'. Expected %u chars max, found %u chars",
                        $key,
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
        unset($nodeAttributes['description']);
        if(0 < count(array_keys($nodeAttributes))) {
            throw new \Exception(
                sprintf(
                    "Settings Definition '%s' has invalid elements for string node '%s': %s",
                    $key,
                    $nodeName,
                    implode(', ', array_keys($nodeAttributes))
                )
            );
        }
    }

}