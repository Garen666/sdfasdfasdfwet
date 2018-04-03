<?php
/**
 * WebProduction Packages. SQLObject.
 * Copyright (C) 2007-2014 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

if (class_exists('PackageLoader')) {
    PackageLoader::Get()->import('SQLObjectSync');
    PackageLoader::Get()->import('Events');
    PackageLoader::Get()->import('ConnectionManager');

    try {
        PackageLoader::Get()->import('DebugException');
    } catch (Exception $e) {}

    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/SQLObject.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/SQLObject_Config.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/SQLObject_ConfigClass.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/SQLObject_Exception.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/SQLObject_Pool.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/SQLObject_FieldValue.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/SQLObject_Event.class.php');
    //PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/SQLObject_IHandler.class.php');
    //PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/SQLObject_HandlerMySQL.class.php');

    Events::Get()->addEvent('SQLObjectInsertBefore', new SQLObject_Event());
    Events::Get()->addEvent('SQLObjectInsertAfter', new SQLObject_Event());
    Events::Get()->addEvent('SQLObjectUpdateBefore', new SQLObject_Event());
    Events::Get()->addEvent('SQLObjectUpdateAfter', new SQLObject_Event());
    Events::Get()->addEvent('SQLObjectDeleteBefore', new SQLObject_Event());
    Events::Get()->addEvent('SQLObjectDeleteAfter', new SQLObject_Event());
} else {
    throw new Exception('Can not use SQLObject without PackageLoader', 0);
}
