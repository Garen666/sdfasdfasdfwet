<?php
/**
 * WebProduction Shop (wpshop)
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * В этом файле определяются дополнительные константы, подключаются пакеты, API,
 * подключается автоматат состояний
 * описываются дополнительные вызовы в зависимости от режима работы Engine.
 */

// опраделяемся с языком по умолчанию (ru)
if (!Engine::Get()->getConfigFieldSecure('site-language')) {
    Engine::Get()->setConfigField('site-language', 'ru');
}

// определение темы по умолчанию, если она еще не задана
$template = Engine::Get()->getConfigFieldSecure('shop-template');
if (!$template) {
    Engine::Get()->setConfigField('shop-template', 'default');
}

// регистрируем контенты в движке
include(dirname(__FILE__).'/contents/contents_global.php');
include(dirname(__FILE__).'/contents/shop/admin/contents_admin.php');
include(dirname(__FILE__).'/contents/shop/admin/orders/contents_orders.php');
include(dirname(__FILE__).'/contents/shop/admin/products/contents_products.php');
include(dirname(__FILE__).'/contents/shop/admin/users/contents_users.php');
include(dirname(__FILE__).'/contents/shop/admin/statistics/contents_statistics.php');
include(dirname(__FILE__).'/contents/help/contents_help.php');

// подключаем API
include(dirname(__FILE__).'/api/include.php');

// подключение модулей
try {
    $moduleArray = Engine::Get()->getConfigField('shop-module');
    if ($moduleArray) {
        foreach ($moduleArray as $moduleName) {
            Shop_ModuleLoader::Get()->import($moduleName);
        }
    }
} catch (Engine_Exception $me) {

}

if (PackageLoader::Get()->getMode('development')) {
    // dev-mode
    // выполяем Engine Contents Generator
    Engine::GetGenerator()->process();
}