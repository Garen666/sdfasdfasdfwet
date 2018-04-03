<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2012 WebProduction <webproduction.com.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package CommentsAPI
 */
class CommentsAPI_Loader implements PackageLoader_ILoader {

    public function __construct($paramsArray) {
        // в режиме разработки создаем таблицы
        if (PackageLoader::Get()->getMode('development')) {
            $table = SQLObject_Config::Get()->addTable('commentsapi_comment', 'CommentsAPI_XComment');
            $table->addField('id', 'int(11)', 'auto_increment');
            $table->addIndexPrimary('id');
            $table->addField('cdate', 'datetime');
            $table->addField('id_user', 'int(11)');
            $table->addIndex('id_user');
            $table->addField('key', 'varchar(32)');
            $table->addIndex('key');
            $table->addField('sessionid', 'varchar(32)');
            $table->addField('ip', 'varchar(15)');
            $table->addField('content', 'text');
        }

        PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/CommentsAPI.class.php');
        PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/CommentsAPI_Exception.class.php');
    }

}