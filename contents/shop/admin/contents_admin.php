<?php
Engine::GetContentDataSource()->registerContent('shop-admin-games', array(
    'title' => 'Games',
    'url' => array('/admin/shop/games/'),
    'filehtml' => dirname(__FILE__).'/games/games_index.html',
    'filephp' => dirname(__FILE__).'/games/games_index.php',
    'filejs' => dirname(__FILE__).'/games/games_index.js',
    'moveto' => 'shop-admin-tpl',
    'moveas' => 'content',
    'level' => '2',
    'role' => array('games'),
), 'override');


Engine::GetContentDataSource()->registerContent('shop-admin-games-manage', array(
    'title' => 'Games manager',
    'url' => '/admin/shop/games/manage/',
    'filehtml' => dirname(__FILE__).'/games/games_manage.html',
    'filephp' => dirname(__FILE__).'/games/games_manage.php',
    'filejs' => dirname(__FILE__).'/games/games_manage.js',
    'moveto' => 'shop-admin-tpl',
    'moveas' => 'content',
    'level' => '2',
    'role' => array('games'),
), 'override');


Engine::GetContentDataSource()->registerContent('shop-admin-games-add', array(
    'title' => 'Game Add',
    'url' => '/admin/shop/games/add/',
    'filehtml' => dirname(__FILE__).'/games/games_add.html',
    'filephp' => dirname(__FILE__).'/games/games_add.php',
    'filejs' => dirname(__FILE__).'/games/games_add.js',
    'moveto' => 'shop-admin-tpl',
    'moveas' => 'content',
    'level' => '2',
    'role' => array('games_add'),
), 'override');


Engine::GetContentDataSource()->registerContent('shop-admin-games-control', array(
    'title' => 'Game Edit',
    'url' => '/admin/shop/games/{id}/',
    'filehtml' => dirname(__FILE__).'/games/games_control.html',
    'filephp' => dirname(__FILE__).'/games/games_control.php',
    'filejs' => dirname(__FILE__).'/games/games_control.js',
    'moveto' => 'shop-admin-tpl',
    'moveas' => 'content',
    'level' => '2',
    'role' => array('games_control'),
), 'override');


///////////////////////////////////////////////////////////////////
Engine::GetContentDataSource()->registerContent('todo-index', array(
'title' => 'ToDo',
'url' => '/admin/todo/',
'filehtml' => dirname(__FILE__).'/todo/todo_index.html',
'filephp' => dirname(__FILE__).'/todo/todo_index.php',
'filejs' => dirname(__FILE__).'/todo/todo_index.js',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('todo-update', array(
'url' => '/admin/todo/update/',
'filephp' => dirname(__FILE__).'/todo/todo_update.php',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('ui', array(
'url' => '/admin/ui/',
'filehtml' => dirname(__FILE__).'/ui.html',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '1',
), 'override');

Engine::GetContentDataSource()->registerContent('datasource-filter', array(
'filehtml' => dirname(__FILE__).'/datasource_filter.html',
'filephp' => dirname(__FILE__).'/datasource_filter.php',
'filejs' => dirname(__FILE__).'/datasource_filter.js',
'level' => '1',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-selectwindow', array(
'url' => '/admin/selectwindow/',
'filehtml' => dirname(__FILE__).'/selectwindow/selectwindow_index.html',
'filephp' => dirname(__FILE__).'/selectwindow/selectwindow_index.php',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-welcome', array(
'title' => 'Welcome',
'url' => '/admin/welcome/',
'filehtml' => dirname(__FILE__).'/welcome/welcome_index.html',
'filejs' => dirname(__FILE__).'/welcome/welcome_index.js',
'filephp' => dirname(__FILE__).'/welcome/welcome_index.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-dashboard', array(
'title' => 'Dashboard',
'url' => '/admin/',
'filehtml' => dirname(__FILE__).'/dashboard/dashboard_index.html',
'filephp' => dirname(__FILE__).'/dashboard/dashboard_index.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
), 'override');

// строчка задачи для календаря
Engine::GetContentDataSource()->registerContent('calendar-block', array(
'filehtml' => dirname(__FILE__).'/calendar/calendar_block.html',
'filephp' => dirname(__FILE__).'/calendar/calendar_block.php',
), 'override');

// обновление задачи в календаре
Engine::GetContentDataSource()->registerContent('calendar-issue-update-ajax', array(
'url' => '/calendar/issue/update/',
'filephp' => dirname(__FILE__).'/calendar/calendar_issue_update.php',
'level' => '2',
), 'override');

// ajax переключатель месяцев календаря
Engine::GetContentDataSource()->registerContent('calendar-block-load-ajax', array(
'url' => '/admin/shop/calendal/load/month/ajax/',
'filephp' => dirname(__FILE__).'/calendar/calendar_block_load_ajax.php',
), 'override');




Engine::GetContentDataSource()->registerContent('shop-admin-comments', array(
'title' => 'Comments',
'url' => '/admin/shop/comments/',
'filehtml' => dirname(__FILE__).'/comments/comments_index.html',
'filephp' => dirname(__FILE__).'/comments/comments_index.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('comments'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-comments-control', array(
'title' => 'Comments',
'url' => array('/admin/shop/comments/add/', '/admin/shop/comments/{id}/'),
'filehtml' => dirname(__FILE__).'/comments/comments_control.html',
'filephp' => dirname(__FILE__).'/comments/comments_control.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('comments'),
), 'override');



Engine::GetContentDataSource()->registerContent('shop-admin-feedback', array(
'title' => 'Feedback',
'url' => '/admin/shop/feedback/',
'filehtml' => dirname(__FILE__).'/feedback/feedback_index.html',
'filephp' => dirname(__FILE__).'/feedback/feedback_index.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('feedback'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-feedback-control', array(
'title' => 'Feedback',
'url' => '/admin/shop/feedback/{id}/',
'filehtml' => dirname(__FILE__).'/feedback/feedback_control.html',
'filephp' => dirname(__FILE__).'/feedback/feedback_control.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('feedback'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-category', array(
'title' => 'Categories list',
'url' => '/admin/shop/category/',
'filehtml' => dirname(__FILE__).'/category/category_index.html',
'filephp' => dirname(__FILE__).'/category/category_index.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('settings'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-manage', array(
'title' => 'Categories manager',
'url' => '/admin/shop/category/manage/',
'filehtml' => dirname(__FILE__).'/category/category_manage.html',
'filephp' => dirname(__FILE__).'/category/category_manage.php',
'filejs' => dirname(__FILE__).'/category/category_manage.js',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('category'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-category-control', array(
'title' => 'Manage category',
'url' => array('/admin/shop/category/add/', '/admin/shop/category/{key}/'),
'filehtml' => dirname(__FILE__).'/category/category_control.html',
'filephp' => dirname(__FILE__).'/category/category_control.php',
'filejs' => dirname(__FILE__).'/category/category_control.js',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('settings'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-redirect', array(
'title' => 'URL and redirects',
'url' => '/admin/shop/redirect/',
'filehtml' => dirname(__FILE__).'/redirect/redirect_index.html',
'filephp' => dirname(__FILE__).'/redirect/redirect_index.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('redirect'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-redirect-control', array(
'title' => 'URL and redirects',
'url' => array('/admin/shop/redirect/add/', '/admin/shop/redirect/{key}/'),
'filehtml' => dirname(__FILE__).'/redirect/redirect_control.html',
'filephp' => dirname(__FILE__).'/redirect/redirect_control.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('redirect'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-seo', array(
'title' => 'SEO',
'url' => '/admin/shop/seo/',
'filehtml' => dirname(__FILE__).'/seo/seo_index.html',
'filephp' => dirname(__FILE__).'/seo/seo_index.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('seo'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-seo-control', array(
'title' => 'Add SEO',
'url' => array('/admin/shop/seo/add/', '/admin/shop/seo/{key}/'),
'filehtml' => dirname(__FILE__).'/seo/seo_control.html',
'filephp' => dirname(__FILE__).'/seo/seo_control.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('seo'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-role', array(
'title' => 'role',
'url' => '/admin/role/',
'filehtml' => dirname(__FILE__).'/role/role_index.html',
'filephp' => dirname(__FILE__).'/role/role_index.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '3',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-role-control', array(
'title' => 'Add role',
'url' => array('/admin/role/add/', '/admin/role/{key}/'),
'filehtml' => dirname(__FILE__).'/role/role_control.html',
'filephp' => dirname(__FILE__).'/role/role_control.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '3',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-ordercategory', array(
'title' => 'Order categories',
'url' => '/admin/shop/ordercategory/',
'filehtml' => dirname(__FILE__).'/ordercategory/ordercategory_index.html',
'filephp' => dirname(__FILE__).'/ordercategory/ordercategory_index.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('settings'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-ordercategory-control', array(
'title' => 'Order categories',
'url' => array('/admin/shop/ordercategory/add/', '/admin/shop/ordercategory/{key}/'),
'filehtml' => dirname(__FILE__).'/ordercategory/ordercategory_control.html',
'filephp' => dirname(__FILE__).'/ordercategory/ordercategory_control.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('settings'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-source', array(
'title' => 'Order/user source',
'url' => '/admin/shop/source/',
'filehtml' => dirname(__FILE__).'/source/source_index.html',
'filephp' => dirname(__FILE__).'/source/source_index.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('settings'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-source-control', array(
'title' => 'Order/user source',
'url' => array('/admin/shop/source/add/', '/admin/shop/source/{key}/'),
'filehtml' => dirname(__FILE__).'/source/source_control.html',
'filephp' => dirname(__FILE__).'/source/source_control.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('settings'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-orderstatus', array(
'title' => 'Order statuses',
'url' => '/admin/shop/orderstatus/',
'filehtml' => dirname(__FILE__).'/orderstatus/orderstatus_index.html',
'filephp' => dirname(__FILE__).'/orderstatus/orderstatus_index.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('settings'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-orderstatus-control', array(
'title' => 'Order statuses',
'url' => array('/admin/shop/orderstatus/add/', '/admin/shop/orderstatus/{key}/'),
'filehtml' => dirname(__FILE__).'/orderstatus/orderstatus_control.html',
'filephp' => dirname(__FILE__).'/orderstatus/orderstatus_control.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('settings'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-orderproductstatus', array(
'url' => '/admin/shop/orderproductstatus/',
'filehtml' => dirname(__FILE__).'/orderproductstatus/orderproductstatus_index.html',
'filephp' => dirname(__FILE__).'/orderproductstatus/orderproductstatus_index.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('settings'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-orderproductstatus-control', array(
'url' => array('/admin/shop/orderproductstatus/add/', '/admin/shop/orderproductstatus/{key}/'),
'filehtml' => dirname(__FILE__).'/orderproductstatus/orderproductstatus_control.html',
'filephp' => dirname(__FILE__).'/orderproductstatus/orderproductstatus_control.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('settings'),
), 'override');



Engine::GetContentDataSource()->registerContent('shop-admin-settings', array(
'title' => 'Settings',
'url' => array('/admin/shop/settings/', '/admin/shop/settings/{tabname}/'),
'filehtml' => dirname(__FILE__).'/settings/settings_index.html',
'filephp' => dirname(__FILE__).'/settings/settings_index.php',
'filejs' => dirname(__FILE__).'/settings/settings_index.js',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('settings'),
), 'override');


Engine::GetContentDataSource()->registerContent('shop-admin-faq', array(
'title' => 'FAQ',
'url' => '/admin/shop/faq/',
'filehtml' => dirname(__FILE__).'/faq/faq_index.html',
'filephp' => dirname(__FILE__).'/faq/faq_index.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('faq'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-faq-control', array(
'title' => 'FAQ',
'url' => array('/admin/shop/faq/add/', '/admin/shop/faq/{id}/'),
'filehtml' => dirname(__FILE__).'/faq/faq_control.html',
'filephp' => dirname(__FILE__).'/faq/faq_control.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('faq'),
), 'override');


Engine::GetContentDataSource()->registerContent('shop-admin-currency', array(
'title' => 'Currencies',
'url' => '/admin/shop/currency/',
'filehtml' => dirname(__FILE__).'/currency/currency_index.html',
'filephp' => dirname(__FILE__).'/currency/currency_index.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('settings'),
), 'override');


Engine::GetContentDataSource()->registerContent('shop-admin-currency-control', array(
'title' => 'Currencies',
'url' => array('/admin/shop/currency/add/', '/admin/shop/currency/{id}/'),
'filehtml' => dirname(__FILE__).'/currency/currency_control.html',
'filephp' => dirname(__FILE__).'/currency/currency_control.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('settings'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-textpages', array(
'title' => 'Pages',
'url' => '/admin/shop/textpages/',
'filehtml' => dirname(__FILE__).'/textpages/textpages_index.html',
'filephp' => dirname(__FILE__).'/textpages/textpages_index.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('pages'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-textpages-control', array(
'url' => array('/admin/shop/textpages/add/', '/admin/shop/textpages/{id}/'),
'filehtml' => dirname(__FILE__).'/textpages/textpages_control.html',
'filephp' => dirname(__FILE__).'/textpages/textpages_control.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('pages'),
), 'override');



Engine::GetContentDataSource()->registerContent('shop-admin-tpl', array(
'filehtml' => dirname(__FILE__).'/admin_shop_tpl.html',
'filephp' => dirname(__FILE__).'/admin_shop_tpl.php',
'filecss' => dirname(__FILE__).'/admin_shop_tpl.css',
'filejs' => dirname(__FILE__).'/admin_shop_tpl.js',
), 'override');



Engine::GetContentDataSource()->registerContent('shop-admin-payment', array(
'title' => 'Payments',
'url' => '/admin/shop/payment/',
'filehtml' => dirname(__FILE__).'/payment/payment_index.html',
'filephp' => dirname(__FILE__).'/payment/payment_index.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('payment'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-payment-control', array(
'title' => 'Payments',
'url' => array('/admin/shop/payment/add/', '/admin/shop/payment/{id}/'),
'filehtml' => dirname(__FILE__).'/payment/payment_control.html',
'filephp' => dirname(__FILE__).'/payment/payment_control.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('payment'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-discount', array(
'title' => 'Discounts',
'url' => '/admin/shop/discount/',
'filehtml' => dirname(__FILE__).'/discount/discount_index.html',
'filephp' => dirname(__FILE__).'/discount/discount_index.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('discount'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-discount-control', array(
'title' => 'Discounts',
'url' => array('/admin/shop/discount/add/', '/admin/shop/discount/{key}/'),
'filehtml' => dirname(__FILE__).'/discount/discount_control.html',
'filephp' => dirname(__FILE__).'/discount/discount_control.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('discount'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-guestbook', array(
'title' => 'Guestbook',
'url' => '/admin/shop/guestbook/',
'filehtml' => dirname(__FILE__).'/guestbook/guestbook_index.html',
'filephp' => dirname(__FILE__).'/guestbook/guestbook_index.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('guestbook'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-guestbook-control', array(
'url' => array('/admin/shop/guestbook/add/', '/admin/shop/guestbook/{id}/'),
'filehtml' => dirname(__FILE__).'/guestbook/guestbook_control.html',
'filephp' => dirname(__FILE__).'/guestbook/guestbook_control.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('guestbook'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-quickedit', array(
'url' => '/admin/shop/quickedit/',
'filehtml' => dirname(__FILE__).'/quickedit/quickedit_index.html',
'filephp' => dirname(__FILE__).'/quickedit/quickedit_index.php',
'level' => '2',
'role' => array('products-edit-quick'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-ticket-support', array(
'title' => 'Support ticket',
'url' => '/admin/shop/ticket/support/',
'filehtml' => dirname(__FILE__).'/ticket/ticket_index.html',
'filephp' => dirname(__FILE__).'/ticket/ticket_index.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('ticket-support'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-support-order', array(
'title' => 'Support order',
'url' => '/admin/shop/support/order/',
'filehtml' => dirname(__FILE__).'/ticket/ticket_order.html',
'filephp' => dirname(__FILE__).'/ticket/ticket_order.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
), 'override');





Engine::GetContentDataSource()->registerContent('shop-admin-ajax-search', array(
    'url' => '/admin/shop/search/ajax/',
    'filephp' => dirname(__FILE__).'/ajax/ajax_admin_search.php',
    'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-ajax-emails-search', array(
    'url' => '/admin/shop/ajax/emails/search/',
    'filephp' => dirname(__FILE__).'/ajax/ajax_admin_emails_search.php',
    'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-ajax-send-email', array(
    'url' => '/admin/shop/sendemail/ajax/',
    'filephp' => dirname(__FILE__).'/ajax/ajax_admin_send_email.php',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-ajax-create-issue', array(
    'url' => '/admin/shop/createissue/ajax/',
    'filephp' => dirname(__FILE__).'/ajax/ajax_admin_create_issue.php',
), 'override');


Engine::GetContentDataSource()->registerContent('shop-admin-ajax-edit-comment', array(
    'url' => '/admin/shop/edit-comment/ajax/',
    'filephp' => dirname(__FILE__).'/ajax/ajax_admin_edit_comment.php',
    'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-ajax-category-manager', array(
'url' => '/admin/shop/ajax/category/manager/',
'filephp' => dirname(__FILE__).'/ajax/ajax_category_manager.php',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-ajax-load-releted-categories', array(
    'url' => '/admin/shop/load/releted/categories/ajax/',
    'filephp' => dirname(__FILE__).'/ajax/ajax_load_releted_categories.php',
), 'override');


Engine::GetContentDataSource()->registerContent('shop-admin-uplodify', array(
'url' => '/admin/shop/uplodify/',
'filephp' => dirname(__FILE__).'/uplodify.php',
), 'override');

Engine::GetContentDataSource()->registerContent('imagecropper', array(
'filehtml' => dirname(__FILE__).'/imagecropper/imagecropper_include.html',
'filephp' => dirname(__FILE__).'/imagecropper/imagecropper_include.php',
'filejs' => dirname(__FILE__).'/imagecropper/imagecropper_include.js',
), 'override');

Engine::GetContentDataSource()->registerContent('imagecropper-image-ajax', array(
'url' => '/imagecropper/upload/ajax/',
'filephp' => dirname(__FILE__).'/imagecropper/imagecropper_upload_ajax.php',
), 'override');




Engine::GetContentDataSource()->registerContent('report-topproducts', array(
'title' => 'Top products',
'url' => '/admin/shop/report/topproducts/',
'filehtml' => dirname(__FILE__).'/report/report_topproducts.html',
'filephp' => dirname(__FILE__).'/report/report_topproducts.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('report_topproducts'),
), 'override');

Engine::GetContentDataSource()->registerContent('report-summary', array(
'title' => 'Summary report',
'url' => '/admin/shop/report/summary/',
'filehtml' => dirname(__FILE__).'/report/report_summary.html',
'filephp' => dirname(__FILE__).'/report/report_summary.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('report_summaryъ'),
), 'override');

Engine::GetContentDataSource()->registerContent('report-clientorders', array(
'title' => 'Client orders',
'url' => '/admin/shop/report/clientorders/',
'filehtml' => dirname(__FILE__).'/report/report_clientorders.html',
'filephp' => dirname(__FILE__).'/report/report_clientorders.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('report_clientorder'),
), 'override');

Engine::GetContentDataSource()->registerContent('report-clientbalance', array(
'title' => 'Client balance',
'url' => '/admin/shop/report/clientbalance/',
'filehtml' => dirname(__FILE__).'/report/report_clientbalance.html',
'filephp' => dirname(__FILE__).'/report/report_clientbalance.php',
'filejs' => dirname(__FILE__).'/report/report_clientbalance.js',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('report_clientbalance'),
), 'override');

Engine::GetContentDataSource()->registerContent('report-sourceorders', array(
'title' => 'Order sources',
'url' => '/admin/shop/report/sourceorders/',
'filehtml' => dirname(__FILE__).'/report/report_sourceorders.html',
'filephp' => dirname(__FILE__).'/report/report_sourceorders.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('report_sourceorders'),
), 'override');


Engine::GetContentDataSource()->registerContent('report-sourceclients', array(
'title' => 'Client sources',
'url' => '/admin/shop/report/sourceclients/',
'filehtml' => dirname(__FILE__).'/report/report_sourceclients.html',
'filephp' => dirname(__FILE__).'/report/report_sourceclients.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('report_sourceclients'),
), 'override');

Engine::GetContentDataSource()->registerContent('report-orderpayment', array(
'title' => 'Order payments',
'url' => '/admin/shop/report/orderpayment/',
'filehtml' => dirname(__FILE__).'/report/report_orderpayment.html',
'filephp' => dirname(__FILE__).'/report/report_orderpayment.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'role' => array('report_orderpayment'),
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('report-probation-order', array(
    'title' => 'Order probation payments',
    'url' => '/admin/shop/report/orderprobation/',
    'filehtml' => dirname(__FILE__).'/report/report_orderprobation.html',
    'filephp' => dirname(__FILE__).'/report/report_orderprobation.php',
    'moveto' => 'shop-admin-tpl',
    'moveas' => 'content',
    'role' => array('report_orderprobation'),
    'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('report-managercompare', array(
'title' => 'Managers compare',
'url' => '/admin/shop/report/managercompare/',
'filehtml' => dirname(__FILE__).'/report/report_managercompare.html',
'filephp' => dirname(__FILE__).'/report/report_managercompare.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('report_managercompare'),
), 'override');

Engine::GetContentDataSource()->registerContent('report-compareorderplan', array(
    'title' => 'Order plan compare',
    'url' => '/admin/shop/report/compareorderplan/',
    'filehtml' => dirname(__FILE__).'/report/report_compareorderplan.html',
    'filephp' => dirname(__FILE__).'/report/report_compareorderplan.php',
    'moveto' => 'shop-admin-tpl',
    'moveas' => 'content',
    'level' => '2',
    'role' => array('report_compareorderplan'),
), 'override');

Engine::GetContentDataSource()->registerContent('report-orderstatus', array(
'title' => 'Orders status',
'url' => '/admin/shop/report/orderstatus/',
'filehtml' => dirname(__FILE__).'/report/report_orderstatus.html',
'filephp' => dirname(__FILE__).'/report/report_orderstatus.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('report_orderstatus'),
), 'override');

Engine::GetContentDataSource()->registerContent('report-notify', array(
'title' => 'Notify report',
'url' => '/admin/shop/report/notify/',
'filehtml' => dirname(__FILE__).'/report/report_notify.html',
'filephp' => dirname(__FILE__).'/report/report_notify.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('report_notify'),
), 'override');

Engine::GetContentDataSource()->registerContent('report-eventdate', array(
'title' => 'Events on date',
'url' => '/admin/shop/report/eventdate/',
'filehtml' => dirname(__FILE__).'/report/report_eventdate.html',
'filephp' => dirname(__FILE__).'/report/report_eventdate.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('report_eventdate'),
), 'override');

Engine::GetContentDataSource()->registerContent('report-event', array(
'title' => 'Events',
'url' => '/admin/shop/report/event/',
'filehtml' => dirname(__FILE__).'/report/report_event.html',
'filephp' => dirname(__FILE__).'/report/report_event.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('report_event'),
), 'override');

Engine::GetContentDataSource()->registerContent('report-eventtree', array(
'title' => 'Events tree',
'url' => '/admin/shop/report/eventtree/',
'filehtml' => dirname(__FILE__).'/report/report_eventtree.html',
'filephp' => dirname(__FILE__).'/report/report_eventtree.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('report_eventtree'),
), 'override');

Engine::GetContentDataSource()->registerContent('report-contacttree', array(
'title' => 'Contact tree',
'url' => '/admin/shop/report/contacttree/',
'filehtml' => dirname(__FILE__).'/report/report_contacttree.html',
'filephp' => dirname(__FILE__).'/report/report_contacttree.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('report_contacttree'),
), 'override');

Engine::GetContentDataSource()->registerContent('event-list-block', array(
'filehtml' => dirname(__FILE__).'/event/event_list_block.html',
'filephp' => dirname(__FILE__).'/event/event_list_block.php',
), 'override');

Engine::GetContentDataSource()->registerContent('event-load', array(
'url' => '/admin/shop/event/load/',
'filehtml' => dirname(__FILE__).'/event/event_load.html',
'filephp' => dirname(__FILE__).'/event/event_load.php',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('event-rating', array(
'url' => '/admin/shop/event/rating/',
'filephp' => dirname(__FILE__).'/event/event_rating.php',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('event-download', array(
'url' => '/admin/shop/event/download/{id}/',
'filephp' => dirname(__FILE__).'/event/event_download.php',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('event-view', array(
'url' => '/admin/shop/event/{id}/',
'filehtml' => dirname(__FILE__).'/event/event_view.html',
'filephp' => dirname(__FILE__).'/event/event_view.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('report-orderdate', array(
'title' => 'Orders on date',
'url' => '/admin/shop/report/orderdate/',
'filehtml' => dirname(__FILE__).'/report/report_orderdate.html',
'filephp' => dirname(__FILE__).'/report/report_orderdate.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('report_orderdate'),
), 'override');

Engine::GetContentDataSource()->registerContent('report-paymentdate', array(
'title' => 'Payments on date',
'url' => '/admin/shop/report/paymentdate/',
'filehtml' => dirname(__FILE__).'/report/report_paymentdate.html',
'filephp' => dirname(__FILE__).'/report/report_paymentdate.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('finance'),
), 'override');

Engine::GetContentDataSource()->registerContent('file-download', array(
'url' => '/admin/shop/file/download/{id}/',
'filephp' => dirname(__FILE__).'/file/file_download.php',
'level' => '2',
), 'override');

// блок фильтров по статусам и workflow'ам
Engine::GetContentDataSource()->registerContent('workflow-filter-block', array(
'filehtml' => dirname(__FILE__).'/workflow/workflow_filter_block.html',
'filephp' => dirname(__FILE__).'/workflow/workflow_filter_block.php',
), 'override');

Engine::GetContentDataSource()->registerContent('workflow-list-ajax', array(
    'url' => '/workflow/list/ajax/',
    'filephp' => dirname(__FILE__).'/workflow/workflow_list_ajax.php',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-workflow', array(
'title' => 'Workflows',
'url' => '/admin/shop/workflow/',
'filehtml' => dirname(__FILE__).'/workflow/workflow_index.html',
'filephp' => dirname(__FILE__).'/workflow/workflow_index.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('settings'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-smarty-workflow-call', array(
    'url' => '/admin/order/smarty/workflow/call/',
    'filehtml' => dirname(__FILE__).'/workflow/smarty/smarty_workflow_call.html',
    'filephp' => dirname(__FILE__).'/workflow/smarty/smarty_workflow_call.php',
    'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-smarty-workflow-email', array(
    'url' => '/admin/order/smarty/workflow/email/',
    'filehtml' => dirname(__FILE__).'/workflow/smarty/smarty_workflow_email.html',
    'filephp' => dirname(__FILE__).'/workflow/smarty/smarty_workflow_email.php',
    'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-smarty-workflow-simple', array(
    'url' => '/admin/order/smarty/workflow/simple/',
    'filehtml' => dirname(__FILE__).'/workflow/smarty/smarty_workflow_simple.html',
    'filephp' => dirname(__FILE__).'/workflow/smarty/smarty_workflow_simple.php',
    'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-workflow-edit', array(
'title' => 'Workflows',
'url' => '/admin/shop/workflow/{id}/',
'filehtml' => dirname(__FILE__).'/workflow/workflow_edit.html',
'filejs' => dirname(__FILE__).'/workflow/workflow_edit.js',
'filephp' => dirname(__FILE__).'/workflow/workflow_edit.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('settings'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-workflow-status-edit', array(
'title' => 'Workflows',
'url' => '/admin/shop/workflowstatus/{id}/',
'filehtml' => dirname(__FILE__).'/workflow/workflow_status_edit.html',
'filejs' => dirname(__FILE__).'/workflow/workflow_status_edit.js',
'filephp' => dirname(__FILE__).'/workflow/workflow_status_edit.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('settings'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-workflow-delete', array(
'title' => 'Workflows',
'url' => '/admin/shop/workflow/{id}/delete/',
'filehtml' => dirname(__FILE__).'/workflow/workflow_delete.html',
'filephp' => dirname(__FILE__).'/workflow/workflow_delete.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('settings'),
), 'override');

Engine::GetContentDataSource()->registerContent('issue-index', array(
'title' => 'Issues',
'url' => '/admin/issue/',
'filehtml' => dirname(__FILE__).'/issue/issue_index.html',
'filephp' => dirname(__FILE__).'/issue/issue_index.php',
'filejs' => dirname(__FILE__).'/issue/issue_index.js',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('issue-smart-closed-ajax', array(
    'url' => '/admin/issue/smart/closed/ajax/',
    'filephp' => dirname(__FILE__).'/issue/issue_smart_closed_ajax.php',
), 'override');

// блок списка задач
Engine::GetContentDataSource()->registerContent('issue-list', array(
'filehtml' => dirname(__FILE__).'/issue/issue_list.html',
'filephp' => dirname(__FILE__).'/issue/issue_list.php',
'filejs' => dirname(__FILE__).'/issue/issue_list.js',
), 'override');

// блок списка задач
Engine::GetContentDataSource()->registerContent('issue-add-quick', array(
'filehtml' => dirname(__FILE__).'/issue/issue_add_quick.html',
'filephp' => dirname(__FILE__).'/issue/issue_add_quick.php',
), 'override');

Engine::GetContentDataSource()->registerContent('issue-add-products-list', array(
    'url' => '/issue/add/products/list/',
    'filehtml' => dirname(__FILE__).'/issue/issue_add_products_list.html',
    'filephp' => dirname(__FILE__).'/issue/issue_add_products_list.php',
), 'override');

Engine::GetContentDataSource()->registerContent('issue-add', array(
'title' => 'Issues',
'url' => '/admin/issue/add/',
'filehtml' => dirname(__FILE__).'/issue/issue_add.html',
'filephp' => dirname(__FILE__).'/issue/issue_add.php',
'filejs' => dirname(__FILE__).'/issue/issue_add.js',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('issue'),
), 'override');

Engine::GetContentDataSource()->registerContent('issue-add-ajax', array(
'url' => '/admin/issue/ajax/add/',
'filephp' => dirname(__FILE__).'/issue/issue_ajax_add.php',
'level' => '2',
'role' => array('issue'),
), 'override');

Engine::GetContentDataSource()->registerContent('issue-add-search-ajax-select2', array(
    'url' => '/admin/issue/searchajax/select2/',
    'filephp' => dirname(__FILE__).'/issue/search_issue_ajax_select2.php',
), 'override');

Engine::GetContentDataSource()->registerContent('issue-add-workflow-preview', array(
'url' => '/admin/issue/workflow-preview/',
'filephp' => dirname(__FILE__).'/issue/issue_add_workflow_preview.php',
), 'override');

Engine::GetContentDataSource()->registerContent('issue-add-workflow-fields', array(
'url' => '/admin/issue/workflow-fields/',
'filephp' => dirname(__FILE__).'/issue/issue_add_workflow_fields.php',
'filehtml' => dirname(__FILE__).'/issue/issue_add_workflow_fields.html',
), 'override');

Engine::GetContentDataSource()->registerContent('issue-checklist-block', array(
'filephp' => dirname(__FILE__).'/issue/issue_checklist_block.php',
'filehtml' => dirname(__FILE__).'/issue/issue_checklist_block.html',
), 'override');

Engine::GetContentDataSource()->registerContent('issue-workflow-preview', array(
'filehtml' => dirname(__FILE__).'/issue/issue_workflow_preview.html',
'filephp' => dirname(__FILE__).'/issue/issue_workflow_preview.php',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-issue-preview', array(
'url' => '/admin/issue/preview/',
'filehtml' => dirname(__FILE__).'/issue/issue_preview.html',
'filephp' => dirname(__FILE__).'/issue/issue_preview.php',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('ignore-index', array(
'title' => 'Ignore',
'url' => '/admin/ignore/',
'filehtml' => dirname(__FILE__).'/ignore/ignore_index.html',
'filephp' => dirname(__FILE__).'/ignore/ignore_index.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('ignore-add', array(
'title' => 'Ignore',
'url' => '/admin/ignore/add/',
'filehtml' => dirname(__FILE__).'/ignore/ignore_add.html',
'filephp' => dirname(__FILE__).'/ignore/ignore_add.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('ignore-control', array(
'title' => 'Ignore',
'url' => '/admin/ignore/{id}/',
'filehtml' => dirname(__FILE__).'/ignore/ignore_control.html',
'filephp' => dirname(__FILE__).'/ignore/ignore_control.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('report_event'),
), 'override');




Engine::GetContentDataSource()->registerContent('project-index', array(
'title' => 'Projects',
'url' => '/admin/projects/',
'filehtml' => dirname(__FILE__).'/projects/project_index.html',
'filejs' => dirname(__FILE__).'/projects/project_index.js',
'filephp' => dirname(__FILE__).'/projects/project_index.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('settings-project-index', array(
'title' => 'Projects',
'url' => '/admin/settings/project/',
'filehtml' => dirname(__FILE__).'/projects/settings_project_index.html',
'filephp' => dirname(__FILE__).'/projects/settings_project_index.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '3',
), 'override');

Engine::GetContentDataSource()->registerContent('settings-project-control', array(
'title' => 'Projects',
'url' => array('/admin/settings/project/add/', '/admin/settings/project/{key}/'),
'filehtml' => dirname(__FILE__).'/projects/settings_project_control.html',
'filephp' => dirname(__FILE__).'/projects/settings_project_control.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '3',
), 'override');

Engine::GetContentDataSource()->registerContent('gantt-index', array(
'filehtml' => dirname(__FILE__).'/gantt/gantt_index.html',
'filephp' => dirname(__FILE__).'/gantt/gantt_index.php',
), 'override');

Engine::GetContentDataSource()->registerContent('funnel-chart-index', array(
    'filehtml' => dirname(__FILE__).'/funnel/funnel_chart_index.html',
    'filephp' => dirname(__FILE__).'/funnel/funnel_chart_index.php',
    'filejs' => dirname(__FILE__).'/funnel/funnel_chart_index.js',
), 'override');

Engine::GetContentDataSource()->registerContent('issue-status-index', array(
    'filehtml' => dirname(__FILE__).'/issue/issue_status_index.html',
    'filephp' => dirname(__FILE__).'/issue/issue_status_index.php',
    'filejs' => dirname(__FILE__).'/issue/issue_status_index.js',
), 'override');

Engine::GetContentDataSource()->registerContent('issue-ajax-add-comment', array(
    'url' => '/admin/issue/ajax/add/comment/',
    'filephp' => dirname(__FILE__).'/issue/issue_ajax_add_comment.php',
    'level' => '2'
), 'override');

Engine::GetContentDataSource()->registerContent('issue-ajax-init-products', array(
    'url' => '/admin/issue/ajax/init/products/',
    'filephp' => dirname(__FILE__).'/issue/issue_ajax_init_products.php',
    'level' => '2'
), 'override');

Engine::GetContentDataSource()->registerContent('gantt-row-block', array(
'filehtml' => dirname(__FILE__).'/gantt/gantt_row_block.html',
'filephp' => dirname(__FILE__).'/gantt/gantt_row_block.php',
), 'override');

Engine::GetContentDataSource()->registerContent('gantt-update', array(
'url' => '/admin/gantt/update/',
'filephp' => dirname(__FILE__).'/gantt/gantt_update.php',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('mind-index', array(
'title' => 'Mind',
'url' => '/admin/mind/{id}/',
'filehtml' => dirname(__FILE__).'/mind/mind_index.html',
'filephp' => dirname(__FILE__).'/mind/mind_index.php',
'filejs' => array(dirname(__FILE__).'/mind/d3.v3.min.js', dirname(__FILE__).'/mind/mind_index.js'),
'filecss' => dirname(__FILE__).'/mind/mind_index.css',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('issue-ajax-add', array(
'url' => '/admin/mind/issue/ajax/add/',
'filephp' => dirname(__FILE__).'/mind/issue_ajax_add.php',
'level' => '2'
), 'override');

Engine::GetContentDataSource()->registerContent('issue-ajax-update', array(
'url' => '/admin/mind/issue/ajax/update/',
'filephp' => dirname(__FILE__).'/mind/issue_ajax_update.php',
'level' => '2'
), 'override');

Engine::GetContentDataSource()->registerContent('issue-ajax-delete', array(
'url' => '/admin/mind/issue/ajax/delete/',
'filephp' => dirname(__FILE__).'/mind/issue_ajax_delete.php',
'level' => '2'
), 'override');

Engine::GetContentDataSource()->registerContent('issue-ajax-get', array(
'url' => '/admin/mind/issue/ajax/get/',
'filephp' => dirname(__FILE__).'/mind/issue_ajax_get.php',
'level' => '2'
), 'override');

Engine::GetContentDataSource()->registerContent('issue-ajax-edit', array(
'url' => '/admin/mind/issue/ajax/edit/',
'filephp' => dirname(__FILE__).'/mind/issue_ajax_edit.php',
'level' => '2'
), 'override');

Engine::GetContentDataSource()->registerContent('funnel-index', array(
'title' => 'Funnel',
'url' => '/admin/funnel/',
'filehtml' => dirname(__FILE__).'/funnel/funnel_index.html',
'filephp' => dirname(__FILE__).'/funnel/funnel_index.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-contact-autocomplete', array(
'url' => '/admin/contact/autocomplete/',
'filephp' => dirname(__FILE__).'/contact/contact_autocomplete.php',
'level' => '2',
), 'override');




Engine::GetContentDataSource()->registerContent('notify-block', array(
'filehtml' => dirname(__FILE__).'/notify/notify_block.html',
'filephp' => dirname(__FILE__).'/notify/notify_block.php',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('structure', array(
'title' => 'Structure',
'url' => '/admin/structure/',
'filehtml' => dirname(__FILE__).'/structure/structure_index.html',
'filejs' => dirname(__FILE__).'/structure/structure_index.js',
'filephp' => dirname(__FILE__).'/structure/structure_index.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('structure-block', array(
'filehtml' => dirname(__FILE__).'/structure/structure_block.html',
'filephp' => dirname(__FILE__).'/structure/structure_block.php',
), 'override');