<?php
Engine::GetContentDataSource()->registerContent('shop-admin-users', array(
'title' => 'Users',
'url' => '/admin/shop/users/',
'filehtml' => dirname(__FILE__).'/users_index.html',
'filephp' => dirname(__FILE__).'/users_index.php',
'filejs' => dirname(__FILE__).'/users_index.js',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('users'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-users-mass-mailing', array(
'title' => 'Direct mail',
'url' => '/admin/shop/users/mailing/',
'filehtml' => dirname(__FILE__).'/users_mailing.html',
'filephp' => dirname(__FILE__).'/users_mailing.php',
'filejs' => dirname(__FILE__).'/users_mailing.js',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('users-mass-mailing'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-users-mass-sms-mailing', array(
'title' => 'Direct sms',
'url' => '/admin/shop/users/smsmailing/',
'filehtml' => dirname(__FILE__).'/users_sms_mailing.html',
'filephp' => dirname(__FILE__).'/users_sms_mailing.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('users-mass-sms-mailing'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-users-autocomplete', array(
'url' => '/admin/shop/users/autocomplete/',
'filehtml' => dirname(__FILE__).'/users_autocomplete.html',
'filephp' => dirname(__FILE__).'/users_autocomplete.php',
'level' => '2',
'role' => array('users'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-users-json-autocomplete', array(
'url' => '/admin/shop/users/jsonautocomplete/',
'filephp' => dirname(__FILE__).'/users_json_autocomplete.php',
'level' => '2',
'role' => array('users'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-users-json-autocomplete-select2', array(
'url' => '/admin/shop/users/jsonautocomplete/select2/',
'filephp' => dirname(__FILE__).'/users_json_autocomplete_select2.php',
'level' => '2',
'role' => array('users'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-users-ajax-autocomplete-select2', array(
    'url' => '/admin/shop/users/ajax/autocomplete/select2/',
    'filephp' => dirname(__FILE__).'/users_ajax_autocomplete_select2.php',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-users-phone-ajax-autocomplete-select2', array(
    'url' => '/admin/shop/users/phone/ajax/autocomplete/select2/',
    'filephp' => dirname(__FILE__).'/users_phone_ajax_autocomplete_select2.php',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-users-add', array(
'title' => 'Add user',
'url' => '/admin/shop/users/add/',
'filehtml' => dirname(__FILE__).'/users_add.html',
'filephp' => dirname(__FILE__).'/users_add.php',
'filejs' => dirname(__FILE__).'/users_add.js',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('users'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-users-addto', array(
'title' => 'Add to user',
'url' => '/admin/shop/users/addto/',
'filehtml' => dirname(__FILE__).'/users_addto.html',
'filephp' => dirname(__FILE__).'/users_addto.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('users'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-users-control', array(
'title' => 'User #{id}',
'url' => '/admin/shop/users/{id}/',
'filehtml' => dirname(__FILE__).'/users_control.html',
'filephp' => dirname(__FILE__).'/users_control.php',
'filejs' => dirname(__FILE__).'/users_control.js',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('users'),
), 'override');

// блок статистики в юзере
Engine::GetContentDataSource()->registerContent('user-block-statistic', array(
'filehtml' => dirname(__FILE__).'/user_block_statistic.html',
'filephp' => dirname(__FILE__).'/user_block_statistic.php',
), 'override');

// блок графиков в юзере
Engine::GetContentDataSource()->registerContent('user-block-charts', array(
'filehtml' => dirname(__FILE__).'/user_block_charts.html',
'filephp' => dirname(__FILE__).'/user_block_charts.php',
'filejs' => dirname(__FILE__).'/user_block_charts.js',
), 'override');

// блок workflow
Engine::GetContentDataSource()->registerContent('user-block-workflow', array(
'filehtml' => dirname(__FILE__).'/user_block_workflow.html',
'filephp' => dirname(__FILE__).'/user_block_workflow.php',
), 'override');

// блок списка сотрудников в компании
Engine::GetContentDataSource()->registerContent('user-block-company', array(
'filehtml' => dirname(__FILE__).'/user_block_company.html',
'filephp' => dirname(__FILE__).'/user_block_company.php',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-users-permissions', array(
'title' => 'Permissions',
'url' => '/admin/shop/users/permissions/{id}/',
'filehtml' => dirname(__FILE__).'/users_permissions.html',
'filephp' => dirname(__FILE__).'/users_permissions.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '3',
'role' => array('users'),
), 'override');


Engine::GetContentDataSource()->registerContent('shop-admin-users-event', array(
'title' => 'Events of contact',
'url' => '/admin/shop/users/{id}/event/',
'filehtml' => dirname(__FILE__).'/user_event.html',
'filephp' => dirname(__FILE__).'/user_event.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('users'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-users-issue', array(
'title' => 'Issues',
'url' => '/admin/shop/users/{id}/issue/',
'filehtml' => dirname(__FILE__).'/users_issue.html',
'filephp' => dirname(__FILE__).'/users_issue.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('users'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-users-graphics', array(
'title' => 'Graphics',
'url' => '/admin/shop/users/{id}/graphics/',
'filehtml' => dirname(__FILE__).'/users_graphics.html',
'filephp' => dirname(__FILE__).'/users_graphics.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('users'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-users-groups', array(
'title' => 'Groups',
'url' => '/admin/shop/usergroups/',
'filehtml' => dirname(__FILE__).'/users_groups_index.html',
'filephp' => dirname(__FILE__).'/users_groups_index.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('users', 'users-groups'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-users-groups-control', array(
'title' => 'Groups edit',
'url' => array('/admin/shop/usergroups/add/', '/admin/shop/usergroups/{key}/'),
'filehtml' => dirname(__FILE__).'/users_groups_control.html',
'filephp' => dirname(__FILE__).'/users_groups_control.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('users', 'users-groups'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-users-menu', array(
'filehtml' => dirname(__FILE__).'/users_menu.html',
'filephp' => dirname(__FILE__).'/users_menu.php',
'level' => '2',
'role' => array('users'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-users-ajax-info', array(
'url' => '/admin/shop/users/ajax/info/',
'filehtml' => dirname(__FILE__).'/users_ajax_info.html',
'filephp' => dirname(__FILE__).'/users_ajax_info.php',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-users-search-dublicates-name', array(
'url' => '/admin/shop/users/search/dublicates/name/',
'filephp' => dirname(__FILE__).'/users_ajax_search_dublicates_name.php',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-users-search-dublicates-namesurname', array(
'url' => '/admin/shop/users/search/dublicates/namesurname/',
'filephp' => dirname(__FILE__).'/users_ajax_search_dublicates_namesurname.php',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-users-search-dublicates-email', array(
'url' => '/admin/shop/users/search/dublicates/email/',
'filephp' => dirname(__FILE__).'/users_ajax_search_dublicates_email.php',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-users-search-dublicates-phone', array(
'url' => '/admin/shop/users/search/dublicates/phone/',
'filephp' => dirname(__FILE__).'/users_ajax_search_dublicates_phone.php',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-users-delete', array(
'title' => 'Delete user',
'url' => '/admin/shop/users/{id}/delete/',
'filehtml' => dirname(__FILE__).'/users_delete.html',
'filephp' => dirname(__FILE__).'/users_delete.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('users'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-contact-preview', array(
'url' => '/admin/contact/preview/',
'filehtml' => dirname(__FILE__).'/user_contact_preview.html',
'filephp' => dirname(__FILE__).'/user_contact_preview.php',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-user-tile', array(
    'filehtml' => dirname(__FILE__).'/user_tile.html',
    'filephp' => dirname(__FILE__).'/user_tile.php',
    'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('user-permission-json', array(
'url' => '/user/permission/json/',
'filephp' => dirname(__FILE__).'/user_permission_json.php',
'level' => '3',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-users-ajax-post-autocomplete', array(
'url' => '/admin/shop/users/ajax/post/autocomplete/',
'filephp' => dirname(__FILE__).'/users_ajax_post_autocomplete.php',
), 'override');