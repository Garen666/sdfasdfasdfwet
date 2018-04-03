<?php
// всем пользователям, у которых level>=2 проставить employer=1
require(dirname(__FILE__).'/../packages/Engine/include.2.6.php');

$users = Shop::Get()->getUserService()->getUsersAll();
$users->setEmployer(0);
$users->addWhere('level', '1', '>');
while ($x = $users->getNext()) {
    $x->setEmployer(1);
    $x->update();
    print "set employer #".$x->getId()."\n";
}

print "\n\ndone.\n\n";