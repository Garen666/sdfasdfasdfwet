<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package SMSUtils
 */

if (class_exists('PackageLoader')) {
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/SMSUtils.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/SMSUtils_ISender.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/SMSUtils_Exception.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/SMSUtils_SenderTurbosmsua.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/SMSUtils_SenderQueDB.class.php');
} else {
    include_once(dirname(__FILE__).'/SMSUtils.class.php');
    include_once(dirname(__FILE__).'/SMSUtils_ISender.class.php');
    include_once(dirname(__FILE__).'/SMSUtils_Exception.class.php');
    include_once(dirname(__FILE__).'/SMSUtils_SenderTurbosmsua.class.php');
    include_once(dirname(__FILE__).'/SMSUtils_SenderQueDB.class.php');
}