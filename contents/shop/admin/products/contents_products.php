<?php
Engine::GetContentDataSource()->registerContent('shop-admin-products', array(
'title' => 'Products',
'url' => array('/admin/shop/products/', '/admin/shop/products/list-table/'),
'filehtml' => dirname(__FILE__).'/products_index.html',
'filephp' => dirname(__FILE__).'/products_index.php',
'filejs' => dirname(__FILE__).'/products_index.js',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('products'),
), 'override');

# Продукты таблицей
Engine::GetContentDataSource()->registerContent('shop-admin-products-table', array(
    'filehtml' => dirname(__FILE__).'/products_index_table.html',
    'filephp' => dirname(__FILE__).'/products_index_table.php',
), 'override');

# Продукты папками (проводником)
Engine::GetContentDataSource()->registerContent('shop-admin-products-inlist', array(
'filehtml' => dirname(__FILE__).'/products_index_inlist.html',
'filephp' => dirname(__FILE__).'/products_index_inlist.php',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-products-menu', array(
'filehtml' => dirname(__FILE__).'/products_menu.html',
'filephp' => dirname(__FILE__).'/products_menu.php',
'level' => '2',
'role' => array('products'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-products-edit', array(
'title' => 'Edit products',
'url' => '/admin/shop/products/{id}/edit/',
'filehtml' => dirname(__FILE__).'/products_edit.html',
'filephp' => dirname(__FILE__).'/products_edit.php',
'filejs' => dirname(__FILE__).'/products_add.js',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('products'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-products-image-upload-ajax', array(
    'url' => '/admin/shop/products/imageupload/',
    'filephp' => dirname(__FILE__).'/ajax/products_image_upload_ajax.php',
    'level' => '2',
    'role' => array('products'),
), 'override');

Engine::GetContentDataSource()->registerContent('add-new-category-ajax', array(
    'url' => '/admin/add/new/category/ajax/',
    'filephp' => dirname(__FILE__).'/ajax/add_new_category_ajax.php'
), 'override');

Engine::GetContentDataSource()->registerContent('admin-products-json-autocomtlite-ajax', array(
    'url' => '/admin/products/json/autocomtlite/ajax/',
    'filephp' => dirname(__FILE__).'/ajax/products_json_autocomplete_select2.php'
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-products-manage-ajax', array(
    'url' => '/admin/shop/manage/products/ajax/',
    'filephp' => dirname(__FILE__).'/ajax/products_manage_ajax.php',
    'level' => '2',
    'role' => array('products'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-ckeditor-image-upload-ajax', array(
    'url' => '/admin/shop/ckeditor/imageupload/',
    'filephp' => dirname(__FILE__).'/ajax/ckeditor_image_upload_ajax.php',
), 'override');

Engine::GetContentDataSource()->registerContent('rebuild-category-tree-ajax', array(
    'url' => '/admin/shop/rebuild/categorytree/',
    'filephp' => dirname(__FILE__).'/ajax/rebuild_category_tree_ajax.php'
), 'override');

Engine::GetContentDataSource()->registerContent('product-category-tree', array(
    'filephp' => dirname(__FILE__).'/product_category_tree.php',
    'filehtml' => dirname(__FILE__).'/product_category_tree.html'
), 'override');


Engine::GetContentDataSource()->registerContent('shop-admin-products-filters', array(
'title' => 'Filters',
'url' => '/admin/shop/products/{id}/filters/',
'filehtml' => dirname(__FILE__).'/products_filters.html',
'filephp' => dirname(__FILE__).'/products_filters.php',
'filejs' => dirname(__FILE__).'/products_filters.js',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('products', 'products-filters'),
), 'override');


Engine::GetContentDataSource()->registerContent('shop-admin-products-view', array(
'title' => 'Product #{id}',
'url' => '/admin/shop/products/{id}/view/',
'filehtml' => dirname(__FILE__).'/products_view.html',
'filephp' => dirname(__FILE__).'/products_view.php',
'filejs' => dirname(__FILE__).'/products_view.js',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('products', 'products-views'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-products-orders', array(
'title' => 'Orders',
'url' => '/admin/shop/products/{id}/orders/',
'filehtml' => dirname(__FILE__).'/products_orders.html',
'filephp' => dirname(__FILE__).'/products_orders.php',
'filejs' => dirname(__FILE__).'/products_orders.js',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('products', 'products-orders'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-products-history', array(
'title' => 'Views history',
'url' => '/admin/shop/products/{id}/history/',
'filehtml' => dirname(__FILE__).'/products_history.html',
'filephp' => dirname(__FILE__).'/products_history.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('products', 'products-history'),
), 'override');


Engine::GetContentDataSource()->registerContent('shop-admin-products-related', array(
'title' => 'Related',
'url' => '/admin/shop/products/{id}/related/',
'filehtml' => dirname(__FILE__).'/products_related.html',
'filephp' => dirname(__FILE__).'/products_related.php',
'filejs' => dirname(__FILE__).'/products_related.js',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('products', 'products-related'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-products-delete', array(
'title' => 'Delete product',
'url' => '/admin/shop/products/{id}/delete/',
'filehtml' => dirname(__FILE__).'/products_delete.html',
'filephp' => dirname(__FILE__).'/products_delete.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('products', 'products-delete'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-products-comments', array(
'title' => 'Comments',
'url' => '/admin/shop/products/{id}/comments/',
'filehtml' => dirname(__FILE__).'/products_comments.html',
'filephp' => dirname(__FILE__).'/products_comments.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('products', 'products-comments'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-products-comments-control', array(
'title' => 'Comments',
'url' => '/admin/shop/products/comments/{key}/',
'filehtml' => dirname(__FILE__).'/products_comments_control.html',
'filephp' => dirname(__FILE__).'/products_comments_control.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('products'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-products-add', array(
'title' => 'Add product',
'url' => '/admin/shop/products/add/',
'filehtml' => dirname(__FILE__).'/products_add.html',
'filephp' => dirname(__FILE__).'/products_add.php',
'filejs' => dirname(__FILE__).'/products_add.js',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('products', 'products-add'),
), 'override');



Engine::GetContentDataSource()->registerContent('shop-admin-product-nameformula', array(
'url' => '/admin/shop/product/nameformula/',
'filehtml' => dirname(__FILE__).'/products_nameformula.html',
'filephp' => dirname(__FILE__).'/products_nameformula.php',
'level' => '2',
'role' => array('products'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-product-preview', array(
'url' => '/admin/product/preview/',
'filehtml' => dirname(__FILE__).'/product_preview.html',
'filephp' => dirname(__FILE__).'/product_preview.php',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-product-barcode', array(
'url' => '/admin/product/{id}/barcode/',
'filehtml' => dirname(__FILE__).'/product_barcode.html',
'filephp' => dirname(__FILE__).'/product_barcode.php',
'level' => '2',
), 'override');