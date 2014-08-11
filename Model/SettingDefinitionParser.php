<?php

namespace Fc\SettingsBundle\Model;

use Symfony\Component\Yaml\Parser;

class SettingDefinitionParser {


	
	$yaml = new Parser();

	$value = $yaml->parse(file_get_contents('/path/to/file.yml'));

}