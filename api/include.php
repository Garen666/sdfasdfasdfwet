<?php
/**
 * WebProduction Shop (wpshop)
 * @copyright (C) 2011-2014 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

// для авторизации с одной сессией на разных поддоменах
ini_set('session.cookie_domain', '.'.Engine::Get()->getProjectHost());
ini_set('session.cookie_secure', 'off');
ini_set('session.use_only_cookies', 1);

// issue #45129
@session_start();

try {
    // подключаем SQLObject
    PackageLoader::Get()->import('SQLObject');

    // текущее соединение с базой
    $connection = ConnectionManager::Get()->getConnectionMySQL();

    // задаем соединение с SQLObject
    // строка ОБЯЗАТЕЛЬНА!
    SQLObject_Config::Get()->setConnectionDatabase($connection);
} catch (Exception $e) {

}

// задаем SQLObject путь для генерации файлов
SQLObject_Config::Get()->setPathDatabaseClasses(PROJECT_PATH.'api/db/');

// подключаем пакеты, которые нужны на всех страницах
PackageLoader::Get()->import('jQuery');
PackageLoader::Get()->import('jQueryUI');
PackageLoader::Get()->registerJSFile('/_js/jquery.uploadify.js');
PackageLoader::Get()->registerJSFile('/_js/jquery.cookie.js');
PackageLoader::Get()->registerJSFile('/_js/jquery.colorpicker.js');
PackageLoader::Get()->registerJSFile('/_js/no-conflict.js');
PackageLoader::Get()->registerJSFile('/_js/mouse.js');
PackageLoader::Get()->registerJSFile('/_js/os-detection.js');
PackageLoader::Get()->registerJSFile('/_js/jquery.jcarousellite.js');
PackageLoader::Get()->registerJSFile('/_js/jquery.eislideshow.js');
PackageLoader::Get()->registerJSFile('/_js/jquery.easing.1.3.js');
PackageLoader::Get()->registerJSFile('/_js/jquery.mousewheel.js');
PackageLoader::Get()->registerJSFile('/_js/jquery.maskedinput.js');
PackageLoader::Get()->registerJSFile('/_js/jQueryTabs.js');
PackageLoader::Get()->registerJSFile('/_js/md5.js');
PackageLoader::Get()->registerJSFile('/_js/jquery.colorbox.js');
PackageLoader::Get()->registerJSFile('/_js/jq.scrollTo-min.js');
PackageLoader::Get()->registerCSSFile('/_css/colorbox.css');
PackageLoader::Get()->registerCSSFile('/_css/jquery.colorpicker.css');
PackageLoader::Get()->registerJSFile('/_js/jquery.hotkeys.js');
PackageLoader::Get()->registerJSFile('/_js/jquery.htmlarea.js');
PackageLoader::Get()->registerCSSFile('/_css/jquery.htmlarea.css');
PackageLoader::Get()->registerJSFile('/_js/masonry.pkgd.min.js');
PackageLoader::Get()->registerJSFile('/_js/jquery.uniform.min.js');
PackageLoader::Get()->registerJSFile('/_js/jquery.history.js');

PackageLoader::Get()->import('FS');
PackageLoader::Get()->import('StringUtils');
PackageLoader::Get()->import('ImageProcessor');
PackageLoader::Get()->import('Checker');
PackageLoader::Get()->import('MailUtils');
PackageLoader::Get()->import('ServiceUtils');
PackageLoader::Get()->import('DateTime');
PackageLoader::Get()->import('CommentsAPI');
PackageLoader::Get()->import('Forms');
PackageLoader::Get()->import('SCSSPHP');

// задаем отправщик писем
MailUtils_Config::Get()->setSender(new MailUtils_SenderQueDB());

// developer-mode
if (PackageLoader::Get()->getMode('development') && isset($connection)) {
    // отключаем кешироание вообще

    // игры
    $table = SQLObject_Config::Get()->addClass('XGame', 'game');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('name', 'varchar(255)');
    $table->addField('descriptionshort', 'varchar(50)');
    $table->addField('description', 'text');
    $table->addField('image', 'varchar(255)');
    $table->addField('hidden', 'tinyint(1)'); // cкрытая категория
    $table->addField('deleted', 'tinyint(1)'); // cкрытая категория
    $table->addField('url', 'varchar(100)'); // category url
    $table->addField('seodescription', 'varchar(255)'); // seo описание
    $table->addField('seotitle', 'varchar(255)'); // seo title
    $table->addField('seoh1', 'varchar(255)'); // seo h1 title у товара
    $table->addField('seocontent', 'text'); // seo текст
    $table->addField('seokeywords', 'varchar(255)'); // seo ключевые слова

    $table = SQLObject_Config::Get()->addClass('XGameFilter', 'gameFilter');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('name', 'varchar(255)');
    $table->addField('gameId', 'int(11)');
    $table->addField('hidden', 'tinyint(1)');
    $table->addField('deleted', 'tinyint(1)');

    $table = SQLObject_Config::Get()->addClass('XGameLotTypeFilter', 'gameLotTypeFilter');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('lotTypeId', 'int(11)');
    $table->addField('gameFilterId', 'tinyint(1)');

    $table = SQLObject_Config::Get()->addClass('XGameFilterValue', 'gameFilterValue');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('gameId', 'int(11)');
    $table->addField('gameFilterId', 'int(11)');
    $table->addField('value', 'varchar(255)');

    // типы лотов в играх
    $table = SQLObject_Config::Get()->addClass('XLotType', 'lotType');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('name', 'varchar(255)');
    $table->addField('gameId', 'int(11)');
    $table->addField('sort', 'int(11)');
    $table->addField('hidden', 'tinyint(1)'); // cкрытая категория
    $table->addField('deleted', 'tinyint(1)'); // cкрытая категория
    $table->addField('url', 'varchar(100)'); // category url
    $table->addField('description', 'varchar(500)'); // category url

    $table = SQLObject_Config::Get()->addClass('XLotFilter', 'lotFilter');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('name', 'varchar(255)');
    $table->addField('gameId', 'int(11)');
    $table->addField('lotTypeId', 'int(11)');
    $table->addField('hidden', 'tinyint(1)'); // cкрытая категория
    $table->addField('deleted', 'tinyint(1)'); // cкрытая категория



    $table = SQLObject_Config::Get()->addClass('XLotFilterValue', 'lotFilterValue');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('lotTypeId', 'int(11)');
    $table->addField('lotFilterId', 'int(11)');
    $table->addField('filterValue', 'varchar(255)'); // cкрытая категория

    $table = SQLObject_Config::Get()->addClass('XChat', 'chat');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('cdate', 'datetime');
    $table->addField('chatListId', 'int(11)');
    $table->addField('fromUserName', 'varchar(255)');
    $table->addField('toUserName', 'varchar(255)');
    $table->addField('show', 'tinyint(1)'); // cкрытая категория
    $table->addField('message', 'text');

    $table = SQLObject_Config::Get()->addClass('XChatList', 'chatList');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('fromUserId', 'int(11)');
    $table->addField('toUserId', 'int(11)');
    $table->addField('fromUserName', 'varchar(255)');
    $table->addField('time', 'int(11)');
    $table->addField('show', 'tinyint(1)');



    // лоты в играх
    /*$table = SQLObject_Config::Get()->addClass('XLot', 'lots');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('name', 'varchar(255)');
    $table->addField('description', 'text');
    $table->addField('gameId', 'int(11)');
    $table->addField('lotTypeId', 'int(11)');
    $table->addField('hidden', 'tinyint(1)'); // cкрытая категория
    $table->addField('deleted', 'tinyint(1)'); // cкрытая категория
    $table->addField('url', 'varchar(100)'); // category url
    $table->addField('seodescription', 'varchar(255)'); // seo описание
    $table->addField('seotitle', 'varchar(255)'); // seo title
    $table->addField('seoh1', 'varchar(255)'); // seo h1 title у товара
    $table->addField('seocontent', 'text'); // seo текст
    $table->addField('seokeywords', 'varchar(255)'); */// seo ключевые слова

    // лоты игроков
    $table = SQLObject_Config::Get()->addClass('XLot', 'lots');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('userId', 'int(11)');
    $table->addField('gameId', 'int(11)');
    $table->addField('lotTypeId', 'int(11)');



    // Сообщения
    $table = SQLObject_Config::Get()->addClass('XMessage', 'messages');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('cdate', 'datetime');
    $table->addField('fromUserId', 'int(11)');
    $table->addField('toUserId', 'int(11)');
    $table->addField('text', 'text');


    // Платежи
    $table = SQLObject_Config::Get()->addClass('XPayment', 'payments');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('cdate', 'datetime');
    $table->addField('userId', 'int(11)');
    $table->addField('orderId', 'int(11)');
    $table->addField('sum', 'decimal(15,2)');





    /////////////////////////////////////////////////////////////////////////////////////////

    // users (клиенты и юзеры)
    $table = SQLObject_Config::Get()->addTable('users', 'XUser');
    $table->addField('id', 'bigint(20) UNSIGNED', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('login', 'varchar(255)');
    $table->addField('password', 'varchar(255)');
    $table->addField('level', 'int(11)');
    $table->addField('cdate', 'datetime');
    $table->addField('adate', 'datetime');
    $table->addField('sdate', 'datetime');
    $table->addField('ip', 'varchar(15)');
    $table->addField('sid', 'varchar(255)');
    $table->addField('email', 'varchar(255)');
    $table->addField('commentadmin', 'varchar(255)'); // коментарии админа
    $table->addField('post', 'varchar(255)'); // должность
    $table->addField('groupid', 'int(11)'); // группа
    $table->addField('activatecode', 'varchar(16)'); // код активации акаунта
    $table->addField('distribution', 'tinyint(1)'); // Подписан ли на рассылку
    $table->addField('edate', 'datetime'); // дата/время актуальности пользователя
    $table->addField('udate', 'datetime'); // дата/время обновления юзера
    $table->addField('sourceid', 'int(11)'); // источник
    $table->addField('authorid', 'int(11)'); // кто автор (не редактируется)
    $table->addField('employer', 'tinyint(1)'); // сотрудник
    $table->addField('utm_source', 'varchar(255)');
    $table->addField('utm_medium', 'varchar(255)');
    $table->addField('utm_campaign', 'varchar(255)');
    $table->addField('utm_content', 'varchar(255)');
    $table->addField('utm_term', 'varchar(255)');
    $table->addField('utm_date', 'datetime');
    $table->addField('utm_referrer', 'varchar(255)');
    $table->addField('identifier', 'varchar(35)'); // md5 идентификатор пользователя для автоматической авторизации

    // индексы
    $table->addIndex('activatecode', 'index_activatecode');
    $table->addIndex(array('login', 'email'), 'index_loginemail');

    $table = SQLObject_Config::Get()->addClass('XUserACL', 'useracl', array($connection));
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('userid', 'int(11)');
    $table->addField('acl', 'varchar(255)');
    // индексы
    $table->addIndex('userid', 'index_userid');

    // группы пользователей
    $table = SQLObject_Config::Get()->addClass('XShopUserGroup', 'shopusergroup');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('name', 'varchar(255)');
    $table->addField('description', 'varchar(255)');
    $table->addField('group', 'varchar(50)');
    $table->addField('sort', 'int(11)');
    // индексы
    $table->addIndex('group', 'index_group');

    // роли
    $table = SQLObject_Config::Get()->addClass('XShopRole', 'shoprole');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('name', 'varchar(255)');
    $table->addField('description', 'varchar(255)');
    $table->addField('parentid', 'int(11)');

    // история звонков и пистем
    $table = SQLObject_Config::Get()->addClass('XShopEvent', 'shopevent');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('type', "varchar(255)"); // тип события
    $table->addField('cdate', 'datetime');
    $table->addField('session', 'varchar(255)'); // идентификатор сессии
    $table->addField('from', 'varchar(255)');
    $table->addField('to', 'varchar(255)');
    $table->addField('sourceid', 'int(11)'); // канал (идентификатор источника)
    $table->addField('subject', 'varchar(255)');
    $table->addField('content', 'text');
    $table->addField('hidden', 'tinyint(1)');
    $table->addField('hash', 'varchar(32)'); // md5-хеш для группировки от дублирования
    $table->addField('direction', 'int(2)'); // 0 - не известно, -1 - входящий в компанию, +1 - исходящий
    $table->addField('fromuserid', 'int(11)'); // ссылки на конкретного юзера
    $table->addField('touserid', 'int(11)'); // ссылки на конкретного юзера
    // индексы
    $table->addIndex('cdate', 'index_cdate');
    $table->addIndex('type', 'index_type');
    $table->addIndex(array('from', 'to', 'cdate'), 'index_from');
    $table->addIndex(array('to', 'from', 'cdate'), 'index_to');
    $table->addIndex(array('subject', 'cdate'), 'index_subject');
    $table->addIndex(array('touserid', 'fromuserid', 'cdate'), 'index_touserid');
    $table->addIndex(array('fromuserid', 'touserid', 'cdate'), 'index_fromuserid');

    // вложения для событий
    $table = SQLObject_Config::Get()->addTable('shopeventattachment', 'XShopEventAttachment');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('eventid', 'int(11)');
    $table->addField('file', 'varchar(255)');
    $table->addField('name', 'varchar(255)');
    $table->addField('contenttype', 'varchar(255)');
    // index
    $table->addIndex('eventid', 'index_eventid');

    // shop products
    $table = SQLObject_Config::Get()->addClass('XShopProduct', 'shopproduct');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('name', 'varchar(255)');
    $table->addField('description', 'text');
    $table->addField('tags', 'varchar(255)');
    $table->addField('categoryid', 'int(11)'); // категория
    $table->addField('hidden', 'tinyint(1)'); // скрыт ли товар от просмотра
    $table->addField('deleted', 'tinyint(1)'); // удален ли товар
    $table->addField('url', 'varchar(100)'); // product url
    $table->addField('descriptionshort', 'varchar(300)'); // краткое описание
    $table->addField('seodescription', 'varchar(255)'); // seo описание товара
    $table->addField('seotitle', 'varchar(255)'); // seo title у товара
    $table->addField('seoh1', 'varchar(255)'); // seo h1 title у товара
    $table->addField('seocontent', 'text'); // seo текст
    $table->addField('seokeywords', 'varchar(255)'); // seo ключевые слова
    $table->addField('udate', 'datetime');
    $table->addField('linkkey', 'varchar(255)');
    // индексы
    $table->addIndex('url', 'url');
    $table->addIndex('url', 'url');
    $table->addIndex('linkkey', 'index_linkkey');



    // категории товаров
    $table = SQLObject_Config::Get()->addClass('XShopCategory', 'shopcategory');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('name', 'varchar(255)');
    $table->addField('description', 'text');
    $table->addField('image', 'varchar(255)');
    $table->addField('parentid', 'int(11)');
    $table->addField('hidden', 'tinyint(1)'); // cкрытая категория
    $table->addField('url', 'varchar(100)'); // category url
    $table->addField('seodescription', 'varchar(255)'); // seo описание
    $table->addField('seotitle', 'varchar(255)'); // seo title
    $table->addField('seoh1', 'varchar(255)'); // seo h1 title у товара
    $table->addField('seocontent', 'text'); // seo текст
    $table->addField('seokeywords', 'varchar(255)'); // seo ключевые слова
    $table->addField('linkkey', 'varchar(255)');

    // индексы
    $table->addIndex('url', 'index_url');
    $table->addIndex(array('hidden'), 'index_hidden');
    $table->addIndex(array('linkkey'), 'index_linkkey');


    // shop orders
    $table = SQLObject_Config::Get()->addClass('XShopOrder', 'shoporder');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('name', 'varchar(255)'); // имя заказа
    $table->addField('userid', 'int(11)'); // кто клиент
    $table->addField('managerid', 'int(11)'); // кто менеджер (assingnee)
    $table->addField('authorid', 'int(11)'); // кто автор (не редактируется)
    $table->addField('cdate', 'datetime'); // дата создания
    $table->addField('udate', 'datetime'); // дата обновления
    $table->addField('statusid', 'int(11)');
    $table->addField('categoryid', 'int(11)');
    $table->addField('comments', 'text');
    $table->addField('sum', 'decimal(10,2)'); // полная сумма заказа, включая доставку, минус скидки, минус купоны
    $table->addField('currencyid', 'int(11)'); // валюта
    $table->addField('paymentid', 'int(11)'); // способ оплаты
    $table->addField('hash', 'varchar(32)'); // md5 для track-url
    $table->addField('dateclosed', 'datetime'); // когда закрыт заказ
    $table->addField('parentid', 'int(11)'); // родительская задача
    $table->addField('linkkey', 'varchar(255)'); // ссылка
    $table->addField('ip', 'varchar(15)');
    $table->addField('utm_source', 'varchar(255)');
    $table->addField('utm_medium', 'varchar(255)');
    $table->addField('utm_campaign', 'varchar(255)');
    $table->addField('utm_content', 'varchar(255)');
    $table->addField('utm_term', 'varchar(255)');
    $table->addField('utm_date', 'datetime');
    $table->addField('utm_referrer', 'varchar(255)');
    $table->addField('deleted', 'tinyint(1)');
    // index
    $table->addIndex(array('userid', 'cdate'), 'index_useridcdate');
    $table->addIndex(array('udate'), 'index_udate');
    $table->addIndex(array('cdate'), 'index_udate');
    $table->addIndex(array('deleted'), 'index_deleted');

    // история изменения полей заказа
    $table = SQLObject_Config::Get()->addClass('XShopOrderChange', 'shoporderchange');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('orderid', 'int(11)');
    $table->addField('cdate', 'datetime');
    $table->addField('key', 'varchar(255)');
    $table->addField('value', 'varchar(255)');
    $table->addField('userid', 'int(11)');

    // файлы-вложения (в заказ, в клиента)
    $table = SQLObject_Config::Get()->addClass('XShopFile', 'shopfile');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('key', 'varchar(255)');
    $table->addField('name', 'varchar(255)');
    $table->addField('file', 'varchar(255)');
    $table->addField('contenttype', 'varchar(255)');
    $table->addField('cdate', 'datetime');
    $table->addField('userid', 'int(11)');
    $table->addField('deleted', 'tinyint(1)');

    // shop order category (workflow)
    $table = SQLObject_Config::Get()->addClass('XShopOrderCategory', 'shopordercategory');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('name', 'varchar(255)');
    $table->addField('default', 'tinyint(1)'); // по умолчанию для новых заказов и задач
    $table->addField('hidden', 'tinyint(1)'); // скрытость

    // shop order/user source
    $table = SQLObject_Config::Get()->addClass('XShopSource', 'shopsource');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('name', 'varchar(255)');
    $table->addField('address', 'varchar(255)');

    // shop order status
    $table = SQLObject_Config::Get()->addClass('XShopOrderStatus', 'shoporderstatus');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('name', 'varchar(255)');
    $table->addField('message', 'text'); // сообщение по email
    $table->addField('messageadmin', 'text'); // сообщение по email для админа
    $table->addField('default', 'tinyint(1)'); // базовый или нет, заказ оформляется в базовый статус
    $table->addField('sort', 'int(11)'); // сортировка
    $table->addField('priority', 'int(11)'); // приоритет перекрытия
    $table->addField('linkkey', 'varchar(255)');
    $table->addField('categoryid', 'int(11)'); // статус только для категории заказа
    $table->addField('content', 'text'); // описание статуса
    $table->addField('x', 'int(11)');
    $table->addField('y', 'int(11)');
    $table->addField('width', 'int(11)');
    $table->addField('height', 'int(11)');
    $table->addField('colour', 'varchar(7)'); // цвет строки и ячейки
    $table->addField('term', 'int(11)'); // срок статуса
    $table->addField('termperiod', "enum('hour','day','week','month','year')"); // срок статуса
    $table->addField('processor', 'varchar(255)');
    $table->addField('roleid', 'int(11)'); // ответственная роль
    $table->addField('managerid', 'int(11)'); // конкретный ответственный
    $table->addField('cnt', 'int(11)'); // сколько на данном этапе
    $table->addField('cntlast', 'int(11)'); // сколько на данном этапе было
    $table->addField('smart', 'varchar(255)'); // умный обработчик (logicclass)
    $table->addField('onlyauto', 'tinyint(1)'); // этап нельзя выбрать вручную
    $table->addField('onlyissue', 'tinyint(1)'); // проверка на выполнение задач
    $table->addField('jumpmanager', 'tinyint(1)'); // прыгать ответственным
    $table->addField('prepayed', 'tinyint(1)');
    $table->addField('notifyemailclient', 'tinyint(1)');
    $table->addField('notifyemailadmin', 'tinyint(1)');
    $table->addField('notifyemailmanager', 'tinyint(1)');
    $table->addField('needcontent', 'tinyint(1)');
    $table->addField('needdocument', 'tinyint(1)');
    $table->addField('closed', 'tinyint(1)');
    $table->addField('shipped', 'tinyint(1)');
    $table->addField('autorepeatperiod', "enum('day','week','month')");
    $table->addField('autorepeatterm', 'int(11)');
    for ($j = 1; $j <= 10; $j++) {
        $table->addField('subworkflow'.$j, 'int(11)');
        $table->addField('subworkflow'.$j.'name', 'varchar(255)');
    }
    $table->addField('storage_incoming', 'tinyint(1)');
    $table->addField('storagenameid_incoming', 'tinyint(1)');
    $table->addField('storage_sale', 'tinyint(1)');
    $table->addField('storage_reserve', 'tinyint(1)');
    $table->addField('storage_unreserve', 'tinyint(1)');
    $table->addField('storage_return', 'tinyint(1)');
    // индексы
    $table->addIndex('default', 'index_default');
    $table->addIndex('linkkey', 'index_linkkey');

    // переходы между статусами (визуальные стрелки)
    $table = SQLObject_Config::Get()->addClass('XShopOrderStatusChange', 'shoporderstatuschange');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('categoryid', 'int(11)');
    $table->addField('elementfromid', 'int(11)');
    $table->addField('elementtoid', 'int(11)');

    // shop order items
    $table = SQLObject_Config::Get()->addClass('XShopOrderProduct', 'shoporderproduct');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('orderid', 'int(11)');
    $table->addField('productid', 'int(11)');
    $table->addField('productcount', 'decimal(10,3)');
    $table->addField('productname', 'varchar(255)');
    $table->addField('productprice', 'decimal(10,2)');
    $table->addField('currencyid', 'int(11)');
    $table->addField('serial', 'varchar(255)');
    $table->addField('warranty', 'varchar(255)');
    $table->addField('categoryname', 'varchar(255)');
    $table->addField('comment', 'text'); // примечание админа
    $table->addField('statusid', 'int(11)'); // строчка статуса
    $table->addField('params', 'varchar(255)'); // параметры заказа (скрытое поле)
    $table->addField('datefrom', 'datetime'); // сетка занятости: от
    $table->addField('dateto', 'datetime'); // сетка занятости: до
    $table->addField('linkkey', 'varchar(255)'); // связь
    $table->addField('sortable', 'int(11)'); // Сортировка
    $table->addField('sync', 'tinyint(1)');
    // индексы
    $table->addIndex('orderid', 'index_orderid');
    $table->addIndex('productid', 'index_productid');

    // shop product views
    $table = SQLObject_Config::Get()->addClass('XShopProductView', 'shopproductview');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('productid', 'int(11)');
    $table->addField('userid', 'int(11)');
    $table->addField('sessionid', 'varchar(32)');
    $table->addField('ip', 'varchar(15)');
    $table->addField('cdate', 'datetime');
    // индексы
    $table->addIndex('cdate', 'index_cdate');
    $table->addIndex('productid', 'index_productid');

    // shop product change
    $table = SQLObject_Config::Get()->addClass('XShopProductChange', 'shopproductchange');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('productid', 'int(11)');
    $table->addField('userid', 'int(11)');
    $table->addField('cdate', 'datetime');
    $table->addField('key', 'varchar(32)');
    $table->addField('valueold', 'text');
    $table->addField('valuenew', 'text');
    // индексы
    $table->addIndex('productid', 'index_productid');


    // shop currency - валюта
    $table = SQLObject_Config::Get()->addClass('XShopCurrency', 'shopcurrency');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('name', 'varchar(255)'); // имя валюты
    $table->addField('symbol', 'varchar(32)'); // значок валюты
    $table->addField('rate', 'float'); // курс относительно базовой
    $table->addField('default', 'tinyint(1)'); // базовая или нет, заказ оформляется в базовой
    $table->addField('hidden', 'tinyint(1)'); // скрыта или нет
    $table->addField('sort', 'int(11)'); // Порядок сортировки
    $table->addField('logicclass', 'varchar(255)'); // класс авто-обновления
    $table->addField('percent', 'decimal(10,3)'); // процент надбавки
    $table->addField('linkkey', 'varchar(255)');
    // индексы
    $table->addIndex('default', 'index_default');
    $table->addIndex('linkkey', 'index_linkkey');

    // настраиваемые колонки таблиц
    $table = SQLObject_Config::Get()->addClass('XShopTableColumn', 'shoptablecolumn');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('userid', 'int(11)');
    $table->addField('key', 'varchar(255)');
    $table->addField('visible', 'tinyint(1)');
    $table->addField('datasource', 'varchar(255)');
    // индексы
    $table->addIndex(array('userid', 'datasource'), 'index_useridatasource');

    // shop text pages
    $table = SQLObject_Config::Get()->addClass('XShopTextPage', 'shoptextpage');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('name', 'varchar(255)');
    $table->addField('btnname', 'varchar(255)');
    $table->addField('image', 'varchar(255)');
    $table->addField('content', 'text');
    $table->addField('parentid', 'int(11)');
    $table->addField('logicclass', 'varchar(255)');
    $table->addField('sort', 'int(11)');
    $table->addField('hidden', 'tinyint(1)');
    $table->addField('main', 'tinyint(1)');
    $table->addField('url', 'varchar(100)'); // page url
    $table->addField('key', 'varchar(255)'); // key
    $table->addField('seodescription', 'varchar(255)'); // seo описание
    $table->addField('seotitle', 'varchar(255)'); // seo title
    $table->addField('seoh1', 'varchar(255)'); // seo h1 title у товара
    $table->addField('seocontent', 'text'); // seo текст
    $table->addField('seokeywords', 'varchar(255)'); // seo ключевые слова
    $table->addField('linkkey', 'varchar(255)');
    // индексы
    $table->addIndex('url', 'index_url');
    $table->addIndex('linkkey', 'index_linkkey');
    $table->addIndex(array('parentid', 'hidden', 'sort', 'name'), 'index_parent');

    // shop settings
    $table = SQLObject_Config::Get()->addClass('XShopSettings', 'shopsettings');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('key', 'varchar(255)');
    $table->addField('name', 'varchar(255)');
    $table->addField('value', 'text');
    $table->addField('type', 'varchar(255)');
    $table->addField('tabname', 'varchar(255)');
    $table->addField('description', 'varchar(255)');
    // индексы
    $table->addIndexUnique('key', 'index_key');
    $table->addIndex('tabname', 'index_tabname');

    // shop feedback
    $table = SQLObject_Config::Get()->addClass('XShopFeedback', 'shopfeedback');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('name', 'varchar(255)');
    $table->addField('cdate', 'datetime');
    $table->addField('email', 'varchar(255)');
    $table->addField('message', 'varchar(255)');
    $table->addField('done', 'tinyint(1)');
    $table->addField('userid', 'int(11)');
    $table->addField('pageurl', 'varchar(255)');
    // index
    $table->addIndex('userid', 'index_userid');

    // shop faq
    $table = SQLObject_Config::Get()->addClass('XShopFaq', 'shopfaq');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('question', 'varchar(1000)');
    $table->addField('answer', 'varchar(2000)');
    $table->addField('cdate', 'datetime');
    $table->addField('userid', 'varchar(255)');
    $table->addField('linkkey', 'varchar(255)');
    // индексы
    $table->addIndex(array('question', 'answer'), true);
    $table->addIndex(array('linkkey'), 'index_linkkey');


    // shop payment - способы оплаты
    $table = SQLObject_Config::Get()->addClass('XShopPayment', 'shoppayment');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('name', 'varchar(255)');
    $table->addField('description', 'text');
    $table->addField('image', 'varchar(255)');
    $table->addField('hidden', 'tinyint(1)');
    $table->addField('contentid', 'varchar(255)'); // контент системы оплаты

    // shop payment - способы оплаты
    $table = SQLObject_Config::Get()->addClass('XShopPaymentResult', 'shoppaymentresult');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('amount', 'decimal(10,2)');
    $table->addField('orderid', 'int(11)');
    $table->addField('status', 'varchar(255)');

    // отзывы о магазине (Гостевая гнига)
    $table = SQLObject_Config::Get()->addClass('XShopGuestBook', 'shopguestbook');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('userid', 'int(11)');
    $table->addField('cdate', 'datetime'); // дата отзыва
    $table->addField('text', 'text'); //текст сообщения
    $table->addField('done', 'tinyint(1)'); // статус отзыва ( 0 - не просмотрен модератором, 1 - просмотрен)
    $table->addField('name', 'varchar(255)');
    $table->addField('image', 'varchar(255)');
    $table->addField('linkkey', 'varchar(255)');

    // таблица редиректов
    $table = SQLObject_Config::Get()->addClass('XShopRedirect', 'shopredirect');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('urlfrom', 'varchar(255)');
    $table->addField('urlto', 'varchar(255)');
    $table->addField('code', 'int(11)');
    // индексы
    $table->addIndexUnique('urlfrom', 'index_urlfrom');
    $table->addIndex('urlTo', 'index_urlto');

    // таблица SEO
    $table = SQLObject_Config::Get()->addClass('XShopSEO', 'shopseo');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('url', 'varchar(255)');  // URL
    $table->addField('seotitle', 'varchar(255)'); // seo title
    $table->addField('seoh1', 'varchar(255)'); // seo h1 header
    $table->addField('seokeywords', 'varchar(255)'); // seo meta keywords
    $table->addField('seodescription', 'varchar(255)'); // seo meta description
    $table->addField('seocontent', 'text'); // seo текст
    // индексы
    $table->addIndexUnique('url', 'index_url');

    // page open history
    $table = SQLObject_Config::Get()->addClass('XShopHistory', 'shophistory');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('userid', 'int(11)');
    $table->addField('cdate', 'datetime');
    $table->addField('url', 'varchar(255)');
    $table->addField('post', 'text');



    // contacts-to-groups
    $table = SQLObject_Config::Get()->addClass('XShopUser2Group', 'shopuser2group');
    $table->addField('id', 'int(11)', 'auto_increment');
    $table->addIndexPrimary('id');
    $table->addField('userid', 'int(11)');
    $table->addField('groupid', 'int(11)');
    // индексы
    $table->addIndexUnique(array('groupid', 'userid'), 'index_groupiduserid');

    // выполняем SQLObject Sync
    SQLObject_Config::Get()->process(true);

    // выполяем Engine pages generator
    Engine::GetGenerator()->process();
}

PackageLoader::Get()->registerPHPDirectory(dirname(__FILE__).'/db/');
PackageLoader::Get()->registerPHPDirectory(dirname(__FILE__).'/services/');
PackageLoader::Get()->registerPHPDirectory(dirname(__FILE__).'/system/');
PackageLoader::Get()->registerPHPDirectory(dirname(__FILE__).'/forms/');
PackageLoader::Get()->registerPHPDirectory(dirname(__FILE__).'/acl/');

// подключение сихронизатора базы данных
// запись дефолтных данных
if (PackageLoader::Get()->getMode('development') && isset($connection)) {
    try {
        SQLObject::TransactionStart();

        include(dirname(__FILE__).'/sync/include.php');

        SQLObject::TransactionCommit();
    } catch (Exception $ge) {
        SQLObject::TransactionRollback();
        throw $ge;
    }
}

// текущий язык
$language = Engine::Get()->getConfigFieldSecure('site-language');

// задаем перевода для пакетов
DateTime_Translate::Get()->setLanguage($language);
Forms_Translate::Get()->setLanguage($language);

// загружаем переводы для shop'a
$phpFile = PackageLoader::Get()->getProjectPath().'/media/translate/'.$language.'.php';
Shop::Get()->getTranslateService()->addTranslateFromPHP($phpFile);

// добавляем cron-события
Events::Get()->addEvent('afterCronMinute', new Events_Event());
Events::Get()->addEvent('afterCronHour', new Events_Event());
Events::Get()->addEvent('afterCronDay', new Events_Event());

// события для пересчета наличий
Events::Get()->addEvent('beforeProductAvailProcess', new Events_Event());
Events::Get()->addEvent('afterProductAvailProcess', new Events_Event());

// регистрируем обработчики событий
Events::Get()->observe(
'afterQueryDefine',
new Shop_AuthMachine()
);

Events::Get()->observe(
'afterCronDay',
new Shop_CronDayDefault()
);

Events::Get()->observe(
'afterCronHour',
new Shop_CronHourDefault()
);

Events::Get()->observe(
'afterCronMinute',
new Shop_CronMinuteDefault()
);

// задаем сервис авторизации
Engine_Auth::SetAuthService(Shop::Get()->getUserService());

// проверка прав
Events::Get()->observe(
'beforeContentProcess',
new Shop_ACLObserver()
);

// задаем собственный URLParser
Engine::Get()->setURLParser(Shop_URLParser::Get());

// Задаем соль для шифрования пароля.
// Соль не должна меняться, поскольку не кто потом не зайдёт в систему
// желательное значение соли это названия проекта
// Например: WebProduction
// если соль false то шифрование производится md5()
Shop::Get()->getUserService()->setPasswordSalt('WebProduction');

Events::Get()->observe(
'afterEngineFinal',
new Shop_CKFinderObserver()
);

// в каждый content передаем переменные contentID и currentURL,
// и переводы
Events::Get()->observe(
'beforeContentProcess',
new Shop_ContentValueObserver()
);

// регистрация событий OneClick (Shop):
// product
Events::Get()->addEvent('shopProductAddAfter', new Shop_Event_Product());
Events::Get()->addEvent('shopProductEditBefore', new Shop_Event_Product());
Events::Get()->addEvent('shopProductEditAfter', new Shop_Event_Product());
Events::Get()->addEvent('shopProductDeleteBefore', new Shop_Event_Product());
Events::Get()->addEvent('shopProductDeleteAfter', new Shop_Event_Product());

// order
Events::Get()->addEvent('shopOrderAddAfter', new Shop_Event_Order());
Events::Get()->addEvent('shopOrderEditBefore', new Shop_Event_Order());
Events::Get()->addEvent('shopOrderEditAfter', new Shop_Event_Order());
Events::Get()->addEvent('shopOrderDeleteBefore', new Shop_Event_Order());
Events::Get()->addEvent('shopOrderDeleteAfter', new Shop_Event_Order());
Events::Get()->addEvent('shopOrderStatusUpdateAfter', new Shop_Event_Order());

Events::Get()->addEvent('shopOrderProductDeleteBefore', new Shop_Event_OrderProduct());
Events::Get()->addEvent('shopOrderProductCountUpdateAfter', new Shop_Event_OrderProduct());

// user/client
Events::Get()->addEvent('shopUserAddAfter', new Shop_Event_User());
Events::Get()->addEvent('shopUserEditBefore', new Shop_Event_User());
Events::Get()->addEvent('shopUserEditAfter', new Shop_Event_User());


if (PackageLoader::Get()->getMode('development') || PackageLoader::Get()->getMode('sCssCompile')) {
    // Компилим все scss в css
    Compile_Scss_To_Css::Get()->compile();

    //    $minify = new ShopMinify('/_js/cache/', '/_css/cache/', false);
    //    $minify->process();
}


