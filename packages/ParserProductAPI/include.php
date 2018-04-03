<?php
if (class_exists('PackageLoader')) {
    PackageLoader::Get()->import('TextProcessor');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/ParserProductAPI.class.php');
} else {
    include_once(dirname(__FILE__).'/ParserProductAPI.class.php');
}