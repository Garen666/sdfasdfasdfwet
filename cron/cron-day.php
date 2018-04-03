<?php
/**
 * WebProduction Shop (wpshop)
 * @copyright (C) 2011-2014 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

require(dirname(__FILE__).'/../packages/Engine/include.2.6.php');

Engine::Get()->enableErrorReporting();

$force = isset($argv[1]);
if ($force) {
    PackageLoader::Get()->setMode('debug', true);
}

$pidFile = __FILE__.'.pid';
$pidDate = @file_get_contents($pidFile);
if (!$force) {
    if ($pidDate > DateTime_Object::Now()->addHour(-1)->__toString()) {
        print "\n\nProcess already running...\n\n";
        exit();
    }
}

file_put_contents($pidFile, date('Y-m-d H:i:s'), LOCK_EX);

// генерируем событие
try {
    $event = Events::Get()->generateEvent('afterCronDay');

    if ($force) {
        // показываем что будем запускать
        $a = $event->getObserversArray();
        foreach ($a as $object) {
            print 'Observer '.get_class($object)."\n";
        }
    }

    $event->notify();
} catch (Exception $e) {
    print $e;
}

unlink($pidFile);

print "\n\ndone.\n\n";