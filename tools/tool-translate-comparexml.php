<?php
require(dirname(__FILE__).'/../packages/Engine/include.2.6.php');

/**
 * Сравнение XML-файлов с переводами.
 *
 * Идем по файлу-1 и говорим, каких переводов нет в файле-2.
 */

$file1 = PackageLoader::Get()->getProjectPath().'/media/translate/ru.xml';
$file2 = PackageLoader::Get()->getProjectPath().'/media/translate/en.xml';

$xml1 = (array) simplexml_load_string(file_get_contents($file1));
$xml2 = (array) simplexml_load_string(file_get_contents($file2));

$a = array();
foreach ($xml1 as $key => $value) {
	if (!isset($xml2[$key])) {
		print $key."\n";

		$a[$key] = $value;
	}
}

print "\n\n\n";
print "Please, add to $file2 and translate it";
print "\n\n\n";

foreach ($a as $key => $value) {
	print "<$key>$value</$key>\n";
}

print "\n\ndone.\n\n";