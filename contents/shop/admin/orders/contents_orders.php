<?php
Engine::GetContentDataSource()->registerContent('shop-admin-orders', array(
'title' => 'Orders',
'url' => '/admin/shop/orders/',
'filehtml' => dirname(__FILE__).'/orders_index.html',
'filephp' => dirname(__FILE__).'/orders_index.php',
'filejs' => dirname(__FILE__).'/orders_index.js',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-orders-add', array(
'title' => 'Add order',
'url' => '/admin/shop/orders/add/',
'filehtml' => dirname(__FILE__).'/orders_add.html',
'filephp' => dirname(__FILE__).'/orders_add.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-orders-report', array(
'title' => 'Orders: products to clients',
'url' => '/admin/shop/orders/report/',
'filehtml' => dirname(__FILE__).'/orders_report.html',
'filephp' => dirname(__FILE__).'/orders_report.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('report_productmatrix'),
), 'override');

// страница полного управления заказом
Engine::GetContentDataSource()->registerContent('shop-admin-orders-control', array(
'title' => 'Orders management',
'url' => array('/admin/shop/orders/{id}/', '/admin/issue/{id}/'),
'filehtml' => dirname(__FILE__).'/orders_control.html',
'filephp' => dirname(__FILE__).'/orders_control.php',
'filejs' => dirname(__FILE__).'/orders_control.js',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-orders-control-block-info', array(
'filehtml' => dirname(__FILE__).'/orders_control_block_info.html',
'filephp' => dirname(__FILE__).'/orders_control_block_info.php',
'filejs' => dirname(__FILE__).'/orders_control_block_info.js',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-orders-control-block-product-list', array(
'filehtml' => dirname(__FILE__).'/orders_control_block_product_list.html',
'filephp' => dirname(__FILE__).'/orders_control_block_product_list.php',
'filejs' => dirname(__FILE__).'/orders_control_block_product_list.js',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-orders-control-block-comment', array(
'filehtml' => dirname(__FILE__).'/orders_control_block_comment.html',
'filephp' => dirname(__FILE__).'/orders_control_block_comment.php',
'filejs' => dirname(__FILE__).'/orders_control_block_comment.js',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-orders-delete', array(
'title' => 'Delete order',
'url' => '/admin/shop/orders/{id}/delete/',
'filehtml' => dirname(__FILE__).'/orders_delete.html',
'filephp' => dirname(__FILE__).'/orders_delete.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-orders-employer', array(
'title' => 'Employer of order',
'url' => array('/admin/shop/orders/{id}/employer/', '/admin/issue/{id}/employer/'),
'filehtml' => dirname(__FILE__).'/orders_employer.html',
'filephp' => dirname(__FILE__).'/orders_employer.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
), 'override');


Engine::GetContentDataSource()->registerContent('shop-admin-order-event', array(
'title' => 'Events of order',
'url' => array('/admin/shop/orders/{id}/event/'),
'filehtml' => dirname(__FILE__).'/order_event.html',
'filephp' => dirname(__FILE__).'/order_event.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-orders-log', array(
'title' => 'Log of order',
'url' => array('/admin/shop/orders/{id}/log/'),
'filehtml' => dirname(__FILE__).'/orders_log.html',
'filephp' => dirname(__FILE__).'/orders_log.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-orders-issue', array(
'title' => 'Issue',
'url' => array('/admin/shop/orders/{id}/issue/'),
'filehtml' => dirname(__FILE__).'/orders_issue.html',
'filephp' => dirname(__FILE__).'/orders_issue.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-order-menu', array(
'filehtml' => dirname(__FILE__).'/order_menu.html',
'filephp' => dirname(__FILE__).'/order_menu.php',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-orders-printing', array(
'title' => 'Printing order',
'url' => '/admin/shop/orders/{id}/printing/',
'filehtml' => dirname(__FILE__).'/orders_printing.html',
'filephp' => dirname(__FILE__).'/orders_printing.php',
'role' => array('orders'),
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-order-barcode', array(
'url' => '/admin/shop/orders/{id}/barcode/',
'filehtml' => dirname(__FILE__).'/order_barcode.html',
'filephp' => dirname(__FILE__).'/order_barcode.php',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-order-workflow-info', array(
'url' => '/admin/order/workflow-info/',
'filehtml' => dirname(__FILE__).'/order_workflow_info.html',
'filephp' => dirname(__FILE__).'/order_workflow_info.php',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-order-workflow-setting-info', array(
'url' => '/admin/order/workflow-setting-info/',
'filehtml' => dirname(__FILE__).'/order_workflow_setting_info.html',
'filephp' => dirname(__FILE__).'/order_workflow_setting_info.php',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-order-json-autocomplete-select2', array(
'url' => '/admin/shop/order/jsonautocomplete/select2/',
'filephp' => dirname(__FILE__).'/orders_json_autocomplete_select2.php',
'level' => '2',
'role' => array('orders'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-orders-contact-json-autocomplete-select2', array(
'url' => '/admin/shop/orders/contact/jsonautocomplete/select2/',
'filephp' => dirname(__FILE__).'/users_json_autocomplete_select2.php',
'level' => '2',
'role' => array('users'),
), 'override');

// Ajax перестановка товаров в заказе
Engine::GetContentDataSource()->registerContent('shop-admin-orders-sort-products-ajax', array(
'url' => '/admin/shop/orders/products/sort/ajax/',
'filephp' => dirname(__FILE__).'/ajax_orders_products_sort.php',
'level' => '2',
), 'override');