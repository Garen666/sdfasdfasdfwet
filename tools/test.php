<?php
/**
 * WebProduction Shop (wpshop)
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

require(dirname(__FILE__).'/../packages/Engine/include.2.6.php');

$products = new ShopProduct();

SQLObject::TransactionStart();
while ($x = $products->getNext()) {
    $x->setF_id($x->getId());
    $x->update();
}
SQLObject::TransactionCommit();
