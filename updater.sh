#!/usr/bin/php
<?php
require(dirname(__FILE__).'/packages/PackageLoader/include.php');

PackageLoader::Get()->setMode('debug');
PackageLoader::Get()->setMode('development');

require(dirname(__FILE__).'/packages/Engine/include.2.6.php');

Engine::Get()->enableErrorReporting();

print "\n";
print "Database updated.\n";


file_put_contents(dirname(__FILE__).'/rev.info', date('YmdHis'));

 //$minify = new ShopMinify('/_js/cache/', '/_css/cache/', true);
// $minify->process();

print "\ndone.\n\n";