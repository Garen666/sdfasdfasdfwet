<?php
// во всех заказах посчитать сумму в системной валюте
require(dirname(__FILE__).'/../packages/Engine/include.2.6.php');
$currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();

$order = new ShopOrder();
$order->addWhere('sum', '0', '!=');
while ($x = $order->getNext()) {
    $x->setSumbase(Shop::Get()->getCurrencyService()->convertCurrency($x->getSum(), $x->getCurrency(), $currencyDefault));
    $x->update();
    print "order #".$x->getId()."\n";
}

print "\n\ndone\n\n";