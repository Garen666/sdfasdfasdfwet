<?php
class orders_control_block_product_list extends Engine_Class {

    public function process() {
        try {
            // получаем заказ
            $order = Shop::Get()->getShopService()->getOrderByID(
            $this->getArgument('id')
            );

            // текущий авторизированный пользователь
            $user = $this->getUser();

            $canEdit = Shop::Get()->getShopService()->isOrderChangeAllowed($order, $user);
            $this->setValue('canEdit', $canEdit);

            // когда нажата кнопка Сохранить
            if ($canEdit && $this->getControlValue('ok')) {
                try {
                    SQLObject::TransactionStart();

                    $event = Events::Get()->generateEvent('shopOrderEditBefore');
                    $event->setOrder($order);
                    $event->notify();

                    // добавляем товар в заказ
                    $this->_addOrderProduct($order);

                    // удаляем отмеченные товары из заказа
                    // обновляем цены и содержимое заказа
                    $orderproducts = $order->getOrderProducts();
                    while ($op = $orderproducts->getNext()) {

                        // удаление orderproduct'a
                        if ($this->_deleteOrderProduct($op)) {
                            // дальше продолжать не нужно
                            continue;
                        }

                        // обновляем данные заказа
                        $this->_updateOrderProduct($op);

                        // обновляем способ оплаты
                        Shop::Get()->getShopService()->updateOrderPayment(
                        $order,
                        $this->getControlValue('payment')
                        );
                    }

                    // обновляем скидку
                    try {
                        $discount = Shop::Get()->getShopService()->getDiscountByID(
                        $this->getControlValue('discount')
                        );
                        $order->setDiscountid($discount->getId());
                    } catch (Exception $e) {
                        $order->setDiscountid(0);
                    }

                    // считаем все суммы заказа
                    Shop::Get()->getShopService()->recalculateOrderSums($order);

                    // обновляем заказ
                    $order->update();

                    if ($order->getOutcoming() && ($order->getSum() > 0)) {
                        $order->setSum($order->getSum()*(-1));
                        $order->update();
                    }

                    $event = Events::Get()->generateEvent('shopOrderEditAfter');
                    $event->setOrder($order);
                    $event->notify();

                    SQLObject::TransactionCommit();

                    if (Engine::GetURLParser()->getArgumentSecure('message') != 'error') {
                        Engine::GetURLParser()->setArgument('message', 'ok');
                    }

                } catch (ServiceUtils_Exception $te) {
                    SQLObject::TransactionRollback();

                    if (PackageLoader::Get()->getMode('debug')) {
                        print $te;
                    }

                    Engine::GetURLParser()->setArgument('message', 'error');

                    $this->setValue('message', 'error');
                    $this->setValue('errorsArray', $te->getErrorsArray());

                    $this->setValue('errorText', implode('<br />', Shop_ContentErrorHandler::Get()->getErrorValueArray($te)));
                }
            }

            // получаем все товары в заказе
            $orderproducts = $order->getOrderProducts();

            $a = array();
            $storageSum = 0;
            $serviceSum = 0; // сумма услуг
            $orderLinked = true;
            $clientId = false;
            try {
                $clientId = $order->getUserid();
            } catch (Exception $e) {

            }

            while ($x = $orderproducts->getNext()) {
                // информация о наличии в поставщиках
                try {
                    // productid может быть не действительный,
                    // поэтому заключаем в try-catch

                    $product = $x->getProduct();

                    $productURLEdit = $product->makeURLEdit();
                    $productCount = $product->getCountWithDivisibility($x->getProductcount());
                    $productSource = $product->getSource();
                    $productUnit = $product->getUnit();
                    $showSerial = true;
                    if ($product->getSource() == 'service' || $product->getSource() == 'servicebusy') {
                        $showSerial = false;
                    }


                    if ($product->getSource() == 'service'
                    || $product->getSource() == 'servicebusy') {
                        $priceBase = $product->getPricebase();
                        $priceBase = Shop::Get()->getCurrencyService()->convertCurrency(
                        $priceBase,
                        $product->getCurrency(),
                        $order->getCurrency()
                        );

                        $serviceSum += round($priceBase * $x->getProductcount(), 2);
                    }

                    $storageArray = array();
                    if (Shop_ModuleLoader::Get()->isImported('storage')) {
                        // считаем количество на складе

                        $balance = StorageBalanceService::Get()->getBalanceByProductForReserve(
                        $product,
                        $this->getUser()
                        )->getNext();

                        if ($balance) {
                            try {
                                $storageArray = array(
                                'id' => $balance->getId(),
                                'name' => $balance->getStorageName()->getName(),
                                'count' => round($balance->getAmountAvailable(), 3),
                                'linked' => StorageReserveService::Get()->getProductAmountReserved($this->getUser(), $x)
                                );
                            } catch (Exception $balanceEx) {

                            }
                        }
                    }

                } catch (Exception $e) {
                    $productCount = $x->getProductcount();
                    $productSource = '';
                    $productUnit = '';
                    $productURLEdit = false;
                    $storageArray = array();
                }

                $linkOrderName = false;
                $linkOrderURL = false;
                if (preg_match("/^orderproduct-(\d+)$/ius", $x->getLinkkey(), $r)) {
                    try {
                        $linkOrder = Shop::Get()->getShopService()->getOrderProductById($r[1])->getOrder();

                        $linkOrderName = $linkOrder->makeName();
                        $linkOrderURL = $linkOrder->makeURLEdit();
                    } catch (Exception $e) {

                    }
                }

                try {
                    $sum = $x->makeSum($order->getCurrency());
                } catch (Exception $priceEx) {
                    $sum = 0;
                }

                // запись в тексте, вместо кода товара, код поставщика, если поставщик - клиент
                $codesupplier = 0;

                $image = false;
                try{
                    if ($x->getProduct()->getImage()) {
                        $src = MEDIA_PATH.'/shop/'.$x->getProduct()->getImage();
                        if (file_exists($src)) {
                            $image = $x->getProduct()->makeImageThumb('100','100');
                        }
                    }
                } catch (Exception $e2) {

                }

                // заказы у поставщиков
                $supplierOrders = array();
                $products = new XShopOrderProduct();
                $products->setLinkkey('orderproduct-'.$x->getId());
                while ($p = $products->getNext()) {
                    try{
                        $supplierOrder = Shop::Get()->getShopService()->getOrderByID($p->getOrderid());
                        $supplierOrders[] = array(
                        'id' => $supplierOrder->getId(),
                        'url' => $supplierOrder->makeURLEdit()
                        );
                    } catch (Exception $e) {

                    }
                }

                // товары
                @$a[] = array(
                'id' => $x->getId(),
                'name' => htmlspecialchars($x->getProductname()),
                'productid' => $x->getProductid(),
                'url' => $productURLEdit,
                'count' => (float) $productCount,
                'price' => $x->getProductprice(),
                'sum' => $sum,
                'currencyid' => $x->getCurrencyid(),
                'currencySym' => $x->getCurrency()->getSymbol(),
                'comment' => htmlspecialchars($x->getComment()),
                'statusid' => $x->getStatusid(),
                'supplierArray' => $supplierArray,
                'supplierid' => $x->getSupplierid(),
                'suppliercode' => $codesupplier,
                'categoryname' => htmlspecialchars($x->getCategoryname()),
                'serial' => htmlspecialchars($x->getSerial()),
                'warranty' => htmlspecialchars($x->getWarranty()),
                'source' => $productSource,
                'datefrom' => $this->_formatDate($x->getDatefrom()),
                'dateto' => $this->_formatDate($x->getDateto()),
                'unit' => htmlspecialchars($productUnit),
                'image' => $image,
                'linkOrderName' => $linkOrderName,
                'linkOrderURL' => $linkOrderURL,
                'storageCountArray' => $storageArray,
                'showSerial' => $showSerial,
                'supplierOrders' => $supplierOrders,
                );
            }

            $this->setValue('productsArray', $a);

            $this->setControlValue('ordercurrencyid', $order->getCurrencyid());
            $this->setControlValue('discount', $order->getDiscountid());


                $this->setValue('totalSum', $order->getSum());

            $this->setValue('sum', $order->getSum());
            $this->setValue('currency', $order->getCurrency()->getSymbol());
            $this->setValue('orderid', $order->getId());
            $this->setValue('urlBarcode', Engine::GetLinkMaker()->makeURLByContentIDParam('shop-admin-order-barcode', $order->getId()));

            // информация о ПДВ
            $taxSum = $order->makeTaxSum();
            $this->setValue('taxSum', $taxSum, 2);
            $this->setValue('sumWithoutTax', $order->makeSumWithoutTax());

            $this->setValue('discountSum', $order->getDiscountsum());

            // валюты
            $currency = Shop::Get()->getCurrencyService()->getCurrencyAll();
            $this->setValue('currencyArray', $currency->toArray());

            // если подключен модуль Финансы
            // добавляем счета
            if (Shop_ModuleLoader::Get()->isImported('finance')) {
                $this->setValue('finance', true);

                // сколько оплачено и баланс
                $paymentSum = $order->makeSumPaid();
                $this->setValue('paymentSum', $paymentSum);

                $paymentBalance = $order->makeSumBalance();
                $this->setValue('paymentBalance', $paymentBalance);
            }

            // список скидок
            $discounts = Shop::Get()->getShopService()->getDiscountAll();
            $discountArray = array();
            while ($discount = $discounts->getNext()) {
                try {
                    $discountArray[] = array(
                    'id' => $discount->getId(),
                    'name' => $discount->getName(),
                    'value' => $discount->getValue(),
                    'type' => $discount->getType(),
                    'currency' => $discount->getCurrency()->getName()
                    );
                } catch (ServiceUtils_Exception $se) {

                }
            }
            $this->setValue('discountArray', $discountArray);

            // валюты
            $currencies = Shop::Get()->getCurrencyService()->getCurrencyActive();
            $a = array();
            while ($x = $currencies->getNext()) {
                $a[] = array(
                'id' => $x->getId(),
                'name' => $x->getName(),
                'rate' => $x->getRate(),
                );
            }
            $this->setValue('orderCurrencyArray', $a);

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

    /**
     * Обработчик добавления нового товара в заказ.
     *
     * При добавлении товара в заказ цена товара приводится по правилам:
     * (product.price + product.tax%)
     * и это все конвертируется в валюту заказа.
     *
     * @param ShopOrder $order
     */
    private function _addOrderProduct(ShopOrder $order) {
        if (preg_match_all("/#([\d\w\pL]+)/ius", $this->getArgumentSecure('productlist'), $r)) {
            foreach ($r[1] as $addProductID) {
                if (!$addProductID) {
                    return;
                }

                // проверяем не является ли наш продукт купоном
                try {
                    $product = Shop::Get()->getShopService()->getProductByID($addProductID);
                } catch (Exception $e) {
                    $orderProduct = Shop::Get()->getShopService()->addOrderProduct($order, $addProductID);
                }

            }

        }

        return;

    }

    /**
     * Обработчик удаления товара из заказа
     *
     * @param ShopOrderProduct $op
     */
    private function _deleteOrderProduct(ShopOrderProduct $op) {
        try {
            $deleteID = $this->getArgument('delete'.$op->getId());

            $event = Events::Get()->generateEvent('shopOrderProductDeleteBefore');
            $event->setOrderProduct($op);
            $event->notify();

            $op->delete();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Обработчик обновления товара в заказе
     *
     * @param ShopOrderProduct $op
     */
    private function _updateOrderProduct(ShopOrderProduct $op) {
        try {
            $oldSupplierId = $op->getSupplierid();
            $price = $this->getArgument('price'.$op->getId());
            $price = str_replace(',', '.', $price);

            $supplierID = $this->getArgumentSecure('supplier'.$op->getId());

            $currencyID = $this->getArgument('currency'.$op->getId());

            // проверяем валюту на валидность
            $currency = Shop::Get()->getCurrencyService()->getCurrencyByID($currencyID);

            $count = $this->getArgument('count'.$op->getId());
            $count = str_replace(',', '.', $count);
            $count = (float) trim($count);
            $count = $op->getProduct()->getCountWithDivisibility($count);

            $comment = $this->getArgument('comment'.$op->getId());
            $name = $this->getArgument('name'.$op->getId());
            $serial = $this->getArgumentSecure('serial'.$op->getId());
            $warranty = $this->getArgument('warranty'.$op->getId());
            $categoryName = $this->getArgument('category'.$op->getId());

            $dateFrom = $this->getArgumentSecure('datefrom'.$op->getId(), 'date');
            $dateTo = $this->getArgumentSecure('dateto'.$op->getId(), 'date');

            if ($dateFrom && $dateTo && $op->getProduct()->getSource() == 'servicebusy') {
                // это товар с месячной сеткой занятости
                // (цена - за месяц)

                $term = $op->getProduct()->getTerm();
                if ($term == 'month') {
                    $count = DateTime_Differ::DiffMonth($dateFrom, $dateTo, false);
                } elseif ($term == 'day') {
                    $count = DateTime_Differ::DiffDay($dateTo, $dateFrom) + 1;
                } elseif ($term == 'year') {
                    $count = DateTime_Differ::DiffYear($dateTo, $dateFrom);
                }

            }

            /*
            // нельзя ставить цену ниже себестоимости
            $minProductPrice = $op->getProduct()->getPricebase();
            if ($minProductPrice > 0 && $minProductPrice > $price) {
            $price = $minProductPrice;
            }
            */

            $oldCount = $op->getProductcount();

            // сохраняем цену и валюту как указано
            $op->setProductprice($price);
            $op->setCurrencyid($currencyID);
            $op->setProductname($name);
            $op->setCategoryname($categoryName);
            $op->setSerial($serial);
            $op->setWarranty($warranty);

            $op->setProductcount($count);
            $op->setComment($comment);

            $op->setSupplierid($supplierID);

            $op->setDatefrom($dateFrom);
            $op->setDateto($dateTo);

            $op->update();

            if ($oldCount != $count) {
                $event = Events::Get()->generateEvent('shopOrderProductCountUpdateAfter');
                $event->setOrderProduct($op);
                $event->notify();
            }

            try{
                // проверяем стаус у текущего заказа
                $orderStatus = $op->getOrder()->getStatus();
                if (!$orderStatus->getShipped() && !$orderStatus->getSaled() && !$orderStatus->getClosed() && !$orderStatus->getPayed() && !$orderStatus->getPrepayed()) {
                    // выбрали в поставщиках ---
                    if ($orderStatus->getCreateOrderSupplier() || $orderStatus->getCancelOrderSupplier()) {
                        // если сменили поставщика, или выбрали ---, или перешли в статус отмены заказов
                        if ($orderStatus->getCancelOrderSupplier() || !$supplierID || ($oldSupplierId != $supplierID)) {
                            // убираем товар из заказа поставщику, если он есть
                            $orderProducts = Shop::Get()->getShopService()->getOrderProductsAll();
                            $orderProducts->setLinkkey('orderproduct-'.$op->getId());
                            // проверка статуса заказа
                            $orderProducts->addWhereQuery(
                            "orderid IN (
                                    SELECT id FROM shoporder WHERE statusid IN (
                                    SELECT id FROM shoporderstatus WHERE (payed='0' and saled='0' and prepayed='0' and closed='0' and shipped='0')))"
                                    );

                                    while ($x = $orderProducts->getNext()) {
                                        $orderSupplier = $x->getOrder();
                                        $x->delete();

                                        Shop::Get()->getShopService()->recalculateOrderSums($orderSupplier);
                                    }

                        }

                        if ($orderStatus->getCreateOrderSupplier()) {
                            // выбрали поставщика
                            $this->shopOrderProductSupplierOrder($op);
                        }
                    }

                }

            } catch (Exception $e) {

            }


        } catch (Exception $e) {

        }

    }

    public function shopOrderProductSupplierOrder (ShopOrderProduct $orderProduct) {
        // ищем связанный товар
        $tmp = new ShopOrderProduct();
        $tmp->setProductid($orderProduct->getProductid());
        $tmp->setLinkkey('orderproduct-'.$orderProduct->getId());

        $productFind = false;
        $productCountInClosedOrder = 0;
        $productCountInOpenOrder = 0;

        // ищем связанный товар в заказе с учетом статусов
        while ($x = $tmp->getNext()) {
            try{
                $status = $x->getOrder()->getStatus();
                // проверяем статус
                if ($status->getShipped() || $status->getSaled() || $status->getClosed() || $status->getPayed() || $status->getPrepayed()) {
                    $productCountInClosedOrder += $x->getProductcount();
                } else {
                    $productCountInOpenOrder += $x->getProductcount();
                    $productFind[]= $x;
                }
            } catch (Exception $e) {

            }

        }
        // сколько надо добавить
        $productCount = $orderProduct->getProductcount() - $productCountInClosedOrder - $productCountInOpenOrder;
        if (Shop_ModuleLoader::Get()->isImported('storage')) {
            // считаем сколько есть на складе
            try{
                $balance = StorageBalanceService::Get()->getBalanceByProductForReserve(
                $orderProduct->getProduct(),
                $this->getUser()
                )->getNext();

                if ($balance) {
                    $productCount-= $balance->getAmountAvailable();
                }
            } catch (Exception $e) {

            }

        }

        if ($productFind) {
            // связанный товар найден.
            // обновляем количество
            if ($productCount > 0) {
                // количество увеличиваем
                $product = $productFind[0];
                $product->setProductcount($product->getProductcount() + $productCount);
                $product->update();
                // пересчитать цены
                Shop::Get()->getShopService()->recalculateOrderSums($product->getOrder());
            } elseif ($productCount < 0) {
                // количество уменьшаем
                foreach ($productFind as $product) {
                    $count = $product->getProductcount();
                    $productCount += $count;
                    if ($productCount > 0) {
                        $product->setProductcount($productCount);
                    } else {
                        $product->setProductcount(0);
                    }
                    $product->update();
                    // пересчитать цены
                    Shop::Get()->getShopService()->recalculateOrderSums($product->getOrder());

                    if ($productCount > 0) {
                        break;
                    }

                }

            }

        } elseif ($productCount > 0) {
            // связанный товар не найден.
            $this->_addProducSupplierOrder($orderProduct, $productCount);

        }
    }

    private function _addProducSupplierOrder (ShopOrderProduct $orderProduct, $productCount = false) {
        try{
            // определяем поставщика
            $supplier = $orderProduct->getSupplier();
            if (!$supplier->getWorkflowid()) {
                return false;
            }
            $supplierContact = $supplier->getContact();

            // находим открытый заказ поставщику
            $orderSupplier = new ShopOrder();
            $orderSupplier->setUserid($supplierContact->getId());
            $orderSupplier->addWhereQuery("(linkkey NOT LIKE 'referal-%')");
            $orderSupplier->addWhereQuery("statusid IN (SELECT id FROM shoporderstatus WHERE (payed='0' and saled='0' and prepayed='0' and closed='0' and shipped='0'))");

            if ($orderSupplier = $orderSupplier->getNext()) {
                // открытый заказ найден,
                // дописываем в него
                $this->_addSupplierOrderProduct($orderSupplier, $orderProduct, $productCount);

            } else {
                // заказ не найден
                // нужно создавать новый
                $workFlow = false;
                try{
                    $workFlow = Shop::Get()->getShopService()->getOrderCategoryByID($supplier->getWorkflowid());

                } catch (Exception $e) {

                }

                $orderSupplier = Shop::Get()->getShopService()->makeOrderEmpty();

                $orderSupplier->setClientname($supplierContact->makeName(false, false));
                $orderSupplier->setClientphone($supplierContact->getPhone());
                $orderSupplier->setClientemail($supplierContact->getEmail());
                $orderSupplier->setClientaddress($supplierContact->getAddress());
                $orderSupplier->setUserid($supplierContact->getId());
                $orderSupplier->setOutcoming(1);
                $orderSupplier->setCategoryid($supplier->getWorkflowid());
                $orderSupplier->setStatusid($workFlow ? $workFlow->getStatusDefault()->getId():0);
                $orderSupplier->update();

                // дописываем в него
                $this->_addSupplierOrderProduct($orderSupplier, $orderProduct, $productCount);

            }

        } catch (Exception $e) {

        }

    }

    private function _addSupplierOrderProduct(ShopOrder $orderSupplier, ShopOrderProduct $orderProduct, $productCount = false) {
        // определяем цену и поставщика
        try {
            //$supplierPrice = 0;
            $supplierCode = '';
            //$supplierCurrencyID = Shop::Get()->getCurrencyService()->getCurrencySystem()->getId();

            $product = $orderProduct->getProduct();

            for ($j = 1; $j <= 5; $j++) {
                $supplierID = $product->getField('supplier'.$j.'id');

                if ($supplierID == $orderProduct->getSupplierid()) {
                    //$supplierPrice = $product->getField('supplier'.$j.'price');
                    //$supplierCurrencyID = $product->getField('supplier'.$j.'currencyid');
                    $supplierCode = $product->getField('supplier'.$j.'code');
                    break;
                }
            }

            $tmp = new ShopOrderProduct();
            $tmp->setProductid($orderProduct->getProductid());
            $tmp->setOrderid($orderSupplier->getId());
            $tmp->setProductname($supplierCode.' '.$orderProduct->getProductname());
            $tmp->setProductcount($productCount);
            $tmp->setProductprice($product->getPricebase());
            $tmp->setCurrencyid(Shop::Get()->getCurrencyService()->getCurrencySystem()->getId());
            $tmp->setLinkkey('orderproduct-'.$orderProduct->getId());
            $tmp->insert();

        } catch (Exception $e) {

        }



        // пересчитать цены
        Shop::Get()->getShopService()->recalculateOrderSums($orderSupplier);
    }

    private function _formatDate($date) {
        if (Checker::CheckDate($date)) {
            return DateTime_Formatter::DateISO9075($date);
        }

        return '';
    }

}