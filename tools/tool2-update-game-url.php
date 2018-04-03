<?php
require(dirname(__FILE__).'/../packages/Engine/include.2.6.php');

$games = new Game();

while ($x = $games->getNext()) {
    $x->setUrl(Shop::Get()->getShopService()->buildURL(trim($x->getName(). " " . $x->getDescriptionshort())));
    $x->update();
}

$games = new LotType();
while ($x = $games->getNext()) {
    $x->setUrl($x->buildUrl());
    $x->update();
}