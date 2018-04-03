<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2012 WebProduction <webproduction.ua>
 *
 * This program is free software; you can not redistribute it and/or
 * modify it.
 */

/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package MailUtils
 */

if (class_exists('PackageLoader')) {
    PackageLoader::Get()->import('Smarty');

    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/MailUtils_Letter.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/MailUtils_Config.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/MailUtils_Smarty.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/MailUtils_SmartySender.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/MailUtils_ISender.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/MailUtils_SenderMail.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/MailUtils_SenderSMTP.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/MailUtils_SenderQueDB.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/MailUtils_SMTP.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/MailUtils_Exception.class.php');
} else {
    include_once(dirname(__FILE__).'/MailUtils_Letter.class.php');
    include_once(dirname(__FILE__).'/MailUtils_Config.class.php');
    include_once(dirname(__FILE__).'/MailUtils_Smarty.class.php');
    include_once(dirname(__FILE__).'/MailUtils_SmartySender.class.php');
    include_once(dirname(__FILE__).'/MailUtils_ISender.class.php');
    include_once(dirname(__FILE__).'/MailUtils_SenderMail.class.php');
    include_once(dirname(__FILE__).'/MailUtils_SenderSMTP.class.php');
    include_once(dirname(__FILE__).'/MailUtils_SenderQueDB.class.php');
    include_once(dirname(__FILE__).'/MailUtils_SMTP.class.php');
    include_once(dirname(__FILE__).'/MailUtils_Exception.class.php');
}