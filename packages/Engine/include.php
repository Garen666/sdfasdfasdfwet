<?php
/**
 * WebProduction Packages
 * @copyright (C) 2007-2012 WebProduction <webproduction.ua>
 *
 * This program is commercial software;
 * you can not distribute it and/or modify it.
 */

/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Engine
 */

// задаем локаль по умолчанию
setlocale(LC_ALL, 'en_EN.utf8');
if (function_exists('mb_internal_encoding')) {
    mb_internal_encoding("UTF-8");
}

// fix for Mac OS X PHP 5.3 default
@date_default_timezone_set(date_default_timezone_get());

// проверяем, задан ли project path
PackageLoader::Get()->getProjectPath();

define('ENGINE_PATH', dirname(__FILE__).'/');

// подключаем Storage
// (необходим для кеширования)
PackageLoader::Get()->import('Storage');

// подключем Events
PackageLoader::Get()->import('Events');

try {
    // пытаемся подключить пакет DebugException автоматически
    // но DebugException является не обязательным
    PackageLoader::Get()->import('DebugException');
} catch (Exception $e) {}

// подключаем все классы Engine:

PackageLoader::Get()->registerPHPClass(ENGINE_PATH.'Engine_Exception.class.php');

PackageLoader::Get()->registerPHPClass(ENGINE_PATH.'Engine.class.php');

PackageLoader::Get()->registerPHPClass(ENGINE_PATH.'Engine_Smarty.class.php');

PackageLoader::Get()->registerPHPClass(ENGINE_PATH.'Engine_ContentDataSource.class.php');

PackageLoader::Get()->registerPHPClass(ENGINE_PATH.'Engine_Request.class.php');

PackageLoader::Get()->registerPHPClass(ENGINE_PATH.'Engine_Content.class.php');
PackageLoader::Get()->registerPHPClass(ENGINE_PATH.'Engine_Class.class.php');

PackageLoader::Get()->registerPHPClass(ENGINE_PATH.'Engine_ContentDriver.class.php');

PackageLoader::Get()->registerPHPClass(ENGINE_PATH.'Engine_IURLParser.class.php');
PackageLoader::Get()->registerPHPClass(ENGINE_PATH.'Engine_URLParser.class.php');

PackageLoader::Get()->registerPHPClass(ENGINE_PATH.'Engine_ILinkMaker.class.php');
PackageLoader::Get()->registerPHPClass(ENGINE_PATH.'Engine_ALinkMaker.class.php');
PackageLoader::Get()->registerPHPClass(ENGINE_PATH.'Engine_LinkMaker.class.php');

// Engine events
PackageLoader::Get()->registerPHPClass(ENGINE_PATH.'Engine_Event_ContentProcess.class.php');
PackageLoader::Get()->registerPHPClass(ENGINE_PATH.'Engine_Event_ContentRender.class.php');

PackageLoader::Get()->registerPHPClass(ENGINE_PATH.'Engine_Auth.class.php');

PackageLoader::Get()->registerPHPClass(ENGINE_PATH.'Engine_Generator.class.php');

PackageLoader::Get()->registerPHPClass(ENGINE_PATH.'Engine_HTMLHead.class.php');

PackageLoader::Get()->registerPHPClass(ENGINE_PATH.'Engine_Response.class.php');