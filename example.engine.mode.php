<?php
/**
 * WebProduction Shop (wpshop)
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * В этом файле определяются устанавливается режим работы Engine
 */

// PackageLoader::Get()->setMode('sCssCompile'); # Устанавливает режим компиляции scss файлов в css
// PackageLoader::Get()->setMode('development');
// PackageLoader::Get()->setMode('debug');

// Engine::Get()->enableErrorReporting();

// Engine::Get()->setConfigField('project-host', 'www.localhost');

// часовой пояс проекта
// date_default_timezone_set('Asia/Almaty');



/*

// connection to database
ConnectionManager::Get()->addConnectionDatabase(
new ConnectionManager_MySQLi(
'localhost',
'user',
'password',
'db'
));

*/

// подключение темы
// Engine::Get()->setConfigField('shop-template', 'mytheme');

// подключение модулей
Engine::Get()->setConfigField('shop-module', array('quiz'));

// язык сайта по дефолту русский
// можно прописать en, ua, ru
Engine::Get()->setConfigField('site-language', false);

// переопределение первых пунктов меню (до  модулей)
/*Engine::Get()->setConfigField('project-menu', array(
'/admin/shop/orders/' => 'Заказы',
'/admin/shop/orders/report/servicebusy/' => 'Сетка занятости',
'/admin/shop/users/' => 'Клиенты',
'/admin/shop/products/' => 'Продукты',
));*/

// автоматически переводить все английские фразы
// Engine::Get()->setConfigField('seo-transliterate-en2ru-auto', true);