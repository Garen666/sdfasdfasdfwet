<?php
class issue_add_products_list extends Engine_Class {

    public function process() {

        $name = trim($this->getArgument('name'));
        $categoryId = $this->getArgumentSecure('categoryId');

        $currency = Shop::Get()->getCurrencyService()->getCurrencySystem();
        $sto = array();
        $sup = array();
        $else = array();

        // поиск по серийнику
        if (Shop_ModuleLoader::Get()->isImported('storage') && strlen($name) > 3) {
            $productSerialArray = array();
            $balance = new ShopStorageBalance();
            $balance->addWhere('serial', '%'.$name.'%', 'LIKE');

            while ($x = $balance->getNext()) {
                if ($x->getAmountAvailable() > 0) {
                    $productSerialArray[$x->getProductid()] = $x->getProductid();
                }
            }

            foreach ($productSerialArray as $productId) {
                try{
                    $product = Shop::Get()->getShopService()->getProductByID($productId);

                    $name = str_replace('"', '\"', $product->getName());
                    $name = str_replace('\'', '\"', $name);

                    try{
                        $categoryName = $product->getCategory()->makeName(false);
                    } catch (Exception $e) {
                        $categoryName = false;
                    }

                    $balance = StorageBalanceService::Get()->getBalanceByProduct($product, $this->getUser());
                    $balance->addWhere('serial', '', '<>');
                    while ($bal = $balance->getNext()) {
                        try{
                            if ($bal->getAmountAvailable() > 0) {
                                $balanceProduct = $bal->getProduct();
                                $sto[$bal->getId()] = array(
                                    'id' => $balanceProduct->getId(),
                                    'name' => $balanceProduct->getName(),
                                    'categoryName' => $categoryName,
                                    'url' => $balanceProduct->makeURL(),
                                    'name2' => $name,
                                    'pricebase' => $balanceProduct->getPricebase(),
                                    'price' => $balanceProduct->makePrice($currency),
                                    'storage' => $bal->getAmountAvailable(),
                                    'serial' => $bal->getSerial(),
                                    'pricebaseStorage' => $bal->getPricebase(),
                                    'priceStorage' => $bal->getPrice(),
                                );
                            }
                        } catch (Exception $e) {

                        }

                    }


                } catch (Exception $e) {

                }
            }

        }

        // поиск по имени
        $products = Shop::Get()->getShopService()->searchProducts($name);
        if ($categoryId) {
            $str = '(';
            for ($i=1; $i<=10; $i++) {
                $str .= '`category'.$i.'id` = '.$categoryId;

                if ($i!=10) {
                    $str .= ' OR ';
                }
            }
            $str .= ')';
            $products->addWhereQuery($str);
        }
        $products->setLimitCount(50);
        while ($x = $products->getNext()) {
            try{
                $storage = '';
                $supplierArray = array();
                if (Shop_ModuleLoader::Get()->isImported('storage')) {
                    $balance = StorageBalanceService::Get()->getBalanceByProductForReserve(
                        $x,
                        $this->getUser()
                    )->getNext();

                    $productCount = 0;
                    if ($balance) {
                        $productCount = round($balance->getAmountAvailable(), 3);
                    }
                    if ($productCount > 0) {
                        $storage = 'На складе: '.$productCount;
                    }
                }


                $name = str_replace('"', '\"', $x->getName());
                $name = str_replace('\'', '\"', $name);

                try{
                    $categoryName = $x->getCategory()->makeName(false);
                } catch (Exception $e) {
                    $categoryName = false;
                }

                if ($storage) {
                    $balance = StorageBalanceService::Get()->getBalanceByProduct($x, $this->getUser());
                    while ($bal = $balance->getNext()) {
                        try{
                            if ($bal->getAmountAvailable() > 0) {
                                $balanceProduct = $bal->getProduct();
                                $sto[$bal->getId()] = array(
                                    'id' => $balanceProduct->getId(),
                                    'name' => $balanceProduct->getName(),
                                    'categoryName' => $categoryName,
                                    'url' => $balanceProduct->makeURL(),
                                    'name2' => $name,
                                    'pricebase' => $balanceProduct->getPricebase(),
                                    'price' => $balanceProduct->makePrice($currency),
                                    'storage' => $bal->getAmountAvailable(),
                                    'serial' => $bal->getSerial(),
                                    'pricebaseStorage' => $bal->getPricebase(),
                                    'priceStorage' => $bal->getPrice(),
                                );
                            }
                        } catch (Exception $e) {

                        }

                    }

                } else {

                    $else[] = array(
                        'id' => $x->getId(),
                        'name' => $x->getName(),
                        'categoryName' => $categoryName,
                        'url' => $x->makeURL(),
                        'name2' => $name,
                        'pricebase' => $x->getPricebase(),
                        'price' => $x->makePrice($currency),
                    );

                }

            } catch (Exception $e) {

            }

        }

        $this->setValue('productStorageArray', $sto);
        $this->setValue('productArray', $else);
    }

}