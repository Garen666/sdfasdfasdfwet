<?php
require(dirname(__FILE__).'/../packages/Engine/include.2.6.php');

/**
 * В заданном XML-файле чистка дубликатов
 */

$file = PackageLoader::Get()->getProjectPath().'/media/translate/ua.xml';

$xml = (array) simplexml_load_string(file_get_contents($file));

foreach ($xml as $key => $value) {
	if (is_array($value)) {
	    $value[0] = trim($value[0]);
		print "<$key>{$value[0]}</$key>\n";
	} else {
	    $value = trim($value);
	    print "<$key>{$value}</$key>\n";
	}
}