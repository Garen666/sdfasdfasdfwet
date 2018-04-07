<?php
// вычисляем путь к шаблону
$templateName = Engine::Get()->getConfigFieldSecure('shop-template');
$templatePath = PackageLoader::Get()->getProjectPath().'/templates/'.$templateName.'/';

// инсталлятор
Engine::GetContentDataSource()->registerContent(
    'install-tpl',
    array(
'filehtml' => dirname(__FILE__).'/install/install_tpl.html',
'filephp' => dirname(__FILE__).'/install/install_tpl.php',
'filecss' => dirname(__FILE__).'/install/install_tpl.css',
),
    'override'
);

Engine::GetContentDataSource()->registerContent('install', array(
'title' => 'Install OneClick',
'url' => '/install/',
'filehtml' => dirname(__FILE__).'/install/install.html',
'filephp' => dirname(__FILE__).'/install/install.php',
'filejs' => dirname(__FILE__).'/install/install.js',
'moveto' => 'install-tpl',
'moveas' => 'content',
), 'override');

// ошибки
Engine::GetContentDataSource()->registerContent('404', array(
'title' => 'Error 404',
'filehtml' => $templatePath.'error/error404.html',
'filephp' => dirname(__FILE__).'/errors/error404.php',
'moveto' => 'shop-tpl',
'moveas' => 'content',
), 'override');

Engine::GetContentDataSource()->registerContent('401', array(
'title' => 'Error 401',
'filehtml' => $templatePath.'error/error401.html',
'moveto' => 'shop-tpl',
'moveas' => 'content',
), 'override');

Engine::GetContentDataSource()->registerContent('403', array(
'title' => 'Error 403',
'url' => '/elogin/',
'filehtml' => dirname(__FILE__).'/shop/shop_login.html',
'filephp' => dirname(__FILE__).'/shop/shop_login.php',
'filejs' => dirname(__FILE__).'/shop/shop_login.js',
'moveto' => 'shop-tpl',
'moveas' => 'content',
), 'override');

Engine::GetContentDataSource()->registerContent('500', array(
'title' => 'Error 500',
'filehtml' => $templatePath.'error/error500.html',
'moveto' => 'shop-tpl',
'moveas' => 'content',
), 'override');

// авторизация и регистрация
Engine::GetContentDataSource()->registerContent('logout', array(
'url' => '/logout/',
'filehtml' => $templatePath.'/auth/auth_logout.html',
'filephp' => dirname(__FILE__).'/auth/auth_logout.php',
'moveto' => 'shop-tpl',
'moveas' => 'content',
), 'override');

Engine::GetContentDataSource()->registerContent('registration', array(
'url' => '/registration/',
'filehtml' => $templatePath.'/auth/auth_registration.html',
'filephp' => dirname(__FILE__).'/auth/auth_registration.php',
'filejs' => $templatePath.'/auth/auth_ajs.js',
'moveto' => 'shop-tpl',
'moveas' => 'content',
), 'override');

Engine::GetContentDataSource()->registerContent('remindpassword', array(
'url' => '/remindpassword/',
'filehtml' => $templatePath.'/auth/auth_remindpassword.html',
'filephp' => dirname(__FILE__).'/auth/auth_remindpassword.php',
'filejs' => $templatePath.'/auth/auth_ajs.js',
'moveto' => 'shop-tpl',
'moveas' => 'content',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-account-activate', array(
'url' => '/activate/{email}/{code}/',
'filehtml' => $templatePath.'/auth/account_activate.html',
'filephp' => dirname(__FILE__).'/auth/account_activate.php',
'filejs' => $templatePath.'/auth/account_activate.js',
'moveto' => 'shop-tpl',
'moveas' => 'content',
), 'override');

Engine::GetContentDataSource()->registerContent('automatic-authorization-redirect', array(
'url' => '/automatic_authorization/{identifier}/{redirect}/',
'filephp' => dirname(__FILE__).'/auth/automatic_authorization_redirect.php',
), 'override');

// шаблоны
Engine::GetContentDataSource()->registerContent('index', array(
'url' => '/index.html',
'filehtml' => dirname(__FILE__).'/shop/shop_index.html',
'filephp' => dirname(__FILE__).'/shop/shop_index.php',
'filejs' => dirname(__FILE__).'/shop/shop_index.js',
'moveto' => 'shop-tpl',
'moveas' => 'content',
'cache' => array('ttl' => 3600, 'type' => 'page', 'modifiers' => array('url', 'no-auth')),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-tpl', array(
'filehtml' => dirname(__FILE__).'/shop/shop_tpl.html',
'filephp' => dirname(__FILE__).'/shop/shop_tpl.php',
'filecss' => array($templatePath.'/shop_tpl.css', $templatePath.'/shop_tpl.ie.css'),
'filejs' => dirname(__FILE__).'/shop/shop_tpl.js',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-payment-interkassa', array(
'url' => array('/payment/interkassa/', '/payment/interkassa/{result}/'),
'filehtml' => $templatePath.'/shop_payment_interkassa.html',
'filephp' => dirname(__FILE__).'/shop/shop_payment_interkassa.php',
'moveto' => 'shop-tpl',
'moveas' => 'content',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-payment-liqpay', array(
'url' => array('/payment/liqpay/', '/payment/liqpay/{result}/'),
'filehtml' => $templatePath.'/shop_payment_liqpay.html',
'filephp' => dirname(__FILE__).'/shop/shop_payment_liqpay.php',
'moveto' => 'shop-tpl',
'moveas' => 'content',
), 'override');



Engine::GetContentDataSource()->registerContent('shop-search-company-autocomplete', array(
'url' => '/search/companyautocomplete/',
'filephp' => dirname(__FILE__).'/shop/shop_search_company_autocomplete.php',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-search-autocomplete-json', array(
'url' => '/search/jsonautocomplete/',
'filephp' => dirname(__FILE__).'/shop/shop_search_json_autocomplete.php',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-search-autocomplete', array(
'url' => array('/search/autocomplete/{type}/', '/search/autocomplete/'),
'filehtml' => $templatePath.'/shop_search_autocomplete.html',
'filephp' => dirname(__FILE__).'/shop/shop_search_autocomplete.php',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-search', array(
'url' => array('/search/', '/search/{queryfixed}/'),
'filehtml' => $templatePath.'/shop_search.html',
'filephp' => dirname(__FILE__).'/shop/shop_search.php',
'moveto' => 'shop-tpl',
'moveas' => 'content',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-faq', array(
'filehtml' => $templatePath.'/shop_faq.html',
'filephp' => dirname(__FILE__).'/shop/shop_faq.php',
'cache' => array('ttl' => 3600, 'type' => 'page', 'modifiers' => array('url', 'no-auth')),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-faq-read-answer', array(
'url' => '/faq/{id}/',
'filehtml' => $templatePath.'/shop_faq_read_answer.html',
'filephp' => dirname(__FILE__).'/shop/shop_faq_read_answer.php',
'moveto' => 'shop-tpl',
'moveas' => 'content',
'cache' => array('ttl' => 3600, 'type' => 'page', 'modifiers' => array('url', 'no-auth')),
), 'override');


Engine::GetContentDataSource()->registerContent('shop-payment', array(
'filehtml' => $templatePath.'/shop_payment.html',
'filephp' => dirname(__FILE__).'/shop/shop_payment.php',
'cache' => array('ttl' => 3600, 'type' => 'page', 'modifiers' => array('url', 'no-auth')),
), 'override');


Engine::GetContentDataSource()->registerContent('shop-category', array(
'url' => '/category/{id}/',
'filehtml' => $templatePath.'/shop_category.html',
'filephp' => dirname(__FILE__).'/shop/shop_category.php',
'moveto' => 'shop-tpl',
'moveas' => 'content',
'cache' => array('ttl' => 3600, 'type' => 'page', 'modifiers' => array('url', 'no-auth')),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-tag', array(
'url' => '/tag/{id}/',
'filehtml' => $templatePath.'/shop_tag.html',
'filephp' => dirname(__FILE__).'/shop/shop_tag.php',
'moveto' => 'shop-tpl',
'moveas' => 'content',
'cache' => array('ttl' => 3600, 'type' => 'page', 'modifiers' => array('url', 'no-auth')),
), 'override');



Engine::GetContentDataSource()->registerContent('shop-page', array(
'url' => '/page/{id}/',
'filehtml' => $templatePath.'/shop_page.html',
'filephp' => dirname(__FILE__).'/shop/shop_page.php',
'moveto' => 'shop-tpl',
'moveas' => 'content',
'cache' => array('ttl' => 3600, 'type' => 'page', 'modifiers' => array('url', 'no-auth')),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-page-content', array(
'filehtml' => $templatePath.'/shop_page_content.html',
'filephp' => dirname(__FILE__).'/shop/shop_page_content.php',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-page-html', array(
'filehtml' => $templatePath.'/shop_page_html.html',
'filephp' => dirname(__FILE__).'/shop/shop_page_html.php',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-page-yandex-map', array(
    'filehtml' => $templatePath.'/shop_page_yandex_map.html',
    'filephp' => dirname(__FILE__).'/shop/shop_page_yandex_map.php',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-product', array(
'url' => '/product/{id}/',
'filehtml' => $templatePath.'/shop_product.html',
'filejs' => $templatePath.'/shop_product.js',
'filephp' => dirname(__FILE__).'/shop/shop_product.php',
'moveto' => 'shop-tpl',
'moveas' => 'content',
'cache' => array('ttl' => 3600, 'type' => 'page', 'modifiers' => array('url', 'no-auth')),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-product-list', array(
'filehtml' => $templatePath.'/shop_product_list.html',
'filephp' => dirname(__FILE__).'/shop/shop_product_list.php',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-product-list-ajax', array(
    'url' => '/shop-product-list/ajax/',
    'filephp' => dirname(__FILE__).'/shop/shop_product_list_ajax.php',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-product-list-filters', array(
'filehtml' => $templatePath.'/shop_product_list_filters.html',
'filephp' => dirname(__FILE__).'/shop/shop_product_list_filters.php',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-product-list-key', array(
'filehtml' => $templatePath.'/shop_product_list_key.html',
'filephp' => dirname(__FILE__).'/shop/shop_product_list_key.php',
), 'override');


Engine::GetContentDataSource()->registerContent('shop-order', array(
'url' => '/order/{hash}/',
'filehtml' => $templatePath.'/shop_order.html',
'filephp' => dirname(__FILE__).'/shop/shop_order.php',
'moveto' => 'shop-tpl',
'moveas' => 'content',
), 'override');

Engine::GetContentDataSource()->registerContent('unsubscribe', array(
'url' => '/unsubscribe/',
'filehtml' => $templatePath.'/user_unsubscribe.html',
'filephp' => dirname(__FILE__).'/shop/user_unsubscribe.php',
'moveto' => 'shop-tpl',
'moveas' => 'content',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-product-carousel', array(
'filehtml' => $templatePath.'/shop_product_carousel.html',
'filephp' => dirname(__FILE__).'/shop/shop_product_carousel.php',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-guestbook', array(
'url' => '/guestbook/',
'filehtml' => $templatePath.'/shop_guestbook.html',
'filephp' => dirname(__FILE__).'/shop/shop_guestbook.php',
), 'override');

Engine::GetContentDataSource()->registerContent('robots-txt', array(
'url' => '/robots.txt',
'filephp' => dirname(__FILE__).'/robots_txt.php',
), 'override');


// клиентская часть
Engine::GetContentDataSource()->registerContent('shop-client-tpl', array(
'filehtml' => $templatePath.'client/admin_client_tpl.html',
'filephp' => dirname(__FILE__).'/shop/client/admin_client_tpl.php',
'moveto' => 'shop-tpl',
'moveas' => 'content',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-client-profile', array(
'title' => 'Profile',
'url' => '/client/profile/',
'filehtml' => $templatePath.'client/client_shop_profile.html',
'filephp' => dirname(__FILE__).'/shop/client/client_shop_profile.php',
'moveto' => 'shop-client-tpl',
'moveas' => 'content',
'level' => '1',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-client-products-viewed', array(
'title' => 'Viewed products',
'url' => '/client/products/viewed/',
'filehtml' => $templatePath.'client/client_shop_products_viewed.html',
'filephp' => dirname(__FILE__).'/shop/client/client_shop_products_viewed.php',
'moveto' => 'shop-client-tpl',
'moveas' => 'content',
'level' => '1',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-client-products-ordered', array(
'title' => 'Ordered products',
'url' => '/client/products/ordered/',
'filehtml' => $templatePath.'client/client_shop_products_ordered.html',
'filephp' => dirname(__FILE__).'/shop/client/client_shop_products_ordered.php',
'moveto' => 'shop-client-tpl',
'moveas' => 'content',
'level' => '1',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-client-orders', array(
'title' => 'My orders',
'url' => '/client/orders/',
'filehtml' => $templatePath.'client/client_shop_orders.html',
'filephp' => dirname(__FILE__).'/shop/client/client_shop_orders.php',
'moveto' => 'shop-client-tpl',
'moveas' => 'content',
'level' => '1',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-client-orders-view', array(
'title' => 'My order',
'url' => '/client/orders/{id}/',
'filehtml' => $templatePath.'client/client_shop_orders_view.html',
'filephp' => dirname(__FILE__).'/shop/client/client_shop_orders_view.php',
'moveto' => 'shop-client-tpl',
'moveas' => 'content',
'level' => '1',
), 'override');
///////////////////////////////////////////////////

Engine::GetContentDataSource()->registerContent('shop-sale', array(
    'title' => 'Мои продажи',
    'url' => '/sale/',
    'filehtml' => dirname(__FILE__).'/shop/shop_sale.html',
    'filephp' => dirname(__FILE__).'/shop/shop_sale.php',
    'filejs' => dirname(__FILE__).'/shop/shop_sale.js',
    'moveto' => 'shop-tpl',
    'moveas' => 'content',
    'cache' => array('ttl' => 3600, 'type' => 'page', 'modifiers' => array('url', 'no-auth')),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-buy', array(
    'title' => 'Мои покупки',
    'url' => '/buy/',
    'filehtml' => dirname(__FILE__).'/shop/shop_buy.html',
    'filephp' => dirname(__FILE__).'/shop/shop_buy.php',
    'filejs' => dirname(__FILE__).'/shop/shop_buy.js',
    'moveto' => 'shop-tpl',
    'moveas' => 'content',
    'cache' => array('ttl' => 3600, 'type' => 'page', 'modifiers' => array('url', 'no-auth')),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-login', array(
    'title' => 'Войти',
    'url' => '/login/',
    'filehtml' => dirname(__FILE__).'/shop/shop_login.html',
    'filephp' => dirname(__FILE__).'/shop/shop_login.php',
    'filejs' => dirname(__FILE__).'/shop/shop_login.js',
    'moveto' => 'shop-tpl',
    'moveas' => 'content',
    'cache' => array('ttl' => 3600, 'type' => 'page', 'modifiers' => array('url', 'no-auth')),
), 'override');


Engine::GetContentDataSource()->registerContent('shop-chat', array(
    'title' => 'Сообщения',
    'url' => '/chat/',
    'filehtml' => dirname(__FILE__).'/shop/shop_chat.html',
    'filephp' => dirname(__FILE__).'/shop/shop_chat.php',
    'filejs' => dirname(__FILE__).'/shop/shop_chat.js',
    'moveto' => 'shop-tpl',
    'moveas' => 'content',
    'cache' => array('ttl' => 3600, 'type' => 'page', 'modifiers' => array('url', 'no-auth')),
), 'override');


Engine::GetContentDataSource()->registerContent('shop-profile', array(
    'title' => 'Кабинет',
    'url' => '/profile/',
    'filehtml' => dirname(__FILE__).'/shop/shop_profile.html',
    'filephp' => dirname(__FILE__).'/shop/shop_profile.php',
    'filejs' => dirname(__FILE__).'/shop/shop_profile.js',
    'moveto' => 'shop-tpl',
    'moveas' => 'content',
    'cache' => array('ttl' => 3600, 'type' => 'page', 'modifiers' => array('url', 'no-auth')),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-game', array(
    'url' => '/game/{id}/',
    'filephp' => dirname(__FILE__).'/shop/shop_game.php',
    'moveto' => 'shop-tpl',
    'moveas' => 'content',
), 'override');

Engine::GetContentDataSource()->registerContent('lot-type', array(
    'url' => '/lot/type/{id}/',
    'filehtml' => dirname(__FILE__).'/shop/lot_type.html',
    'filephp' => dirname(__FILE__).'/shop/lot_type.php',
    'filejs' => dirname(__FILE__).'/shop/lot_type.js',
    'moveto' => 'shop-tpl',
    'moveas' => 'content',
    'cache' => array('ttl' => 3600, 'type' => 'page', 'modifiers' => array('url', 'no-auth')),
), 'override');

Engine::GetContentDataSource()->registerContent('lot-type-sale', array(
    'url' => '/lot/type/{id}/sale/',
    'filehtml' => dirname(__FILE__).'/shop/lot_type_sale.html',
    'filephp' => dirname(__FILE__).'/shop/lot_type_sale.php',
    'filejs' => dirname(__FILE__).'/shop/lot_type_sale.js',
    'moveto' => 'shop-tpl',
    'moveas' => 'content',
    'cache' => array('ttl' => 3600, 'type' => 'page', 'modifiers' => array('url', 'no-auth')),
), 'override');

Engine::GetContentDataSource()->registerContent('lot-type-sale-other', array(
    'url' => '/lot/type/{id}/sale/other/',
    'filehtml' => dirname(__FILE__).'/shop/lot_type_sale_other.html',
    'filephp' => dirname(__FILE__).'/shop/lot_type_sale_other.php',
    'filejs' => dirname(__FILE__).'/shop/lot_type_sale_other.js',
    'moveto' => 'shop-tpl',
    'moveas' => 'content',
    'cache' => array('ttl' => 3600, 'type' => 'page', 'modifiers' => array('url', 'no-auth')),
), 'override');

Engine::GetContentDataSource()->registerContent('lot-type-sale-other-popup-ajax', array(
    'url' => '/lot/type/{id}/sale/other/popup/ajax/',
    'filehtml' => dirname(__FILE__).'/shop/lot_type_sale_other_popup_ajax.html',
    'filephp' => dirname(__FILE__).'/shop/lot_type_sale_other_popup_ajax.php',
), 'override');

Engine::GetContentDataSource()->registerContent('lot-type-sale-other-popup-save-ajax', array(
    'url' => '/lot/type/{id}/sale/other/popup/save/ajax/',
    'filephp' => dirname(__FILE__).'/shop/lot_type_sale_other_popup_save_ajax.php',
), 'override');



