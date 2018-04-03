<?php
class products_index extends Engine_Class {

    public function process() {
        ini_set('max_input_vars', 10000);

        if (isset($_SESSION['categoryid']) && $this->getArgumentSecure('page') &&
        $_SESSION['categoryid'] != $this->getArgumentSecure('categoryid')) {
            Shop_URLParser::Get()->_replaceUrl('page');
        }
        $_SESSION['categoryid'] = $this->getArgumentSecure('categoryid');

        PackageLoader::Get()->registerJSFile('/_js/jQueryFilter.js');

        $allowEdit = $this->getUser()->isAllowed('products-edit');
        $this->setValue('allowEdit', $allowEdit);

        if ($allowEdit
        && $this->getControlValue('change')) {
            $this->_productsChange();
        }

        // Добавление товаров в новый заказ
        if ($allowEdit
        && $this->getControlValue('createorder')) {
            $this->_addProductsToOrder();
        }

        // Добавление товаров в существующий заказ
        if ($allowEdit
        && $this->getControlValue('addexistorder')) {
            $this->_addProductsExistOrder();
        }


        // массовые операции над товарами
        $massAction =
        $this->getArgumentSecure('hide')
        || $this->getArgumentSecure('delete')
        || $this->getArgumentSecure('avail')
        || $this->getArgumentSecure('changeimage')
        || $this->getArgumentSecure('changedescription')
        || $this->getArgumentSecure('changeaddtags')
        || $this->getArgumentSecure('changeremovetags');

        if ($allowEdit && $massAction) {
            $this->_productsMassActions();
        }

        // Вывод товаров
        $this->_showProductsBlock();

        // категории
        $this->setValue('categoryArray', $this->_makeCategoryArray());

        $query = Engine::GetURLParser()->getGETString();
        if ($query) {
            $this->setValue('query', '?'.$query);
        }

    }

    /**
     * Вывод товаров таблицей или проводником, в зависимости от урл
     */
    private function _showProductsBlock() {
        $datasource = $this->_getDataSource();

        $block = Engine::GetContentDriver()->getContent('shop-admin-products-inlist');
        $block->setValue('arguments', $this->getArguments());
        $block->setValue('datasource', $datasource);
        $this->setValue('block_folders', $block->render());
    }

    /**
     * @return Datasource_Products
     */
    private function _getDataSource() {

        $datasource =  new Datasource_Products($this->getArgumentSecure('categoryid'));

        $this->setControlValue('filter_show_deleted', $this->getArgumentSecure('filter_show_deleted'));
        $this->setControlValue('filter_show_hidden', $this->getArgumentSecure('filter_show_hidden'));
        $this->setControlValue('filter_show_not_sync', $this->getArgumentSecure('filter_show_not_sync'));


        if ( !$this->getArgumentSecure('filter_show_deleted' ) ) {
            $datasource->getSQLObject()->addWhere('deleted','0','=');
        }
        if ( !$this->getArgumentSecure('filter_show_hidden' ) ) {
            $datasource->getSQLObject()->addWhere('hidden','0','=');
        }
        if ( $this->getArgumentSecure('filter_show_not_sync' ) ) {
            $datasource->getSQLObject()->addWhere('unsyncable','0','!=');
        }

        $supplierID = $this->getControlValue('supplierid', 'int');
        if ($supplierID) {
            $a = array();
            for ($i = 1;$i <= 5; $i++) {
                $a[] = "`supplier{$i}id`='$supplierID'";
            }
            $datasource->getSQLObject()->addWhereQuery('('.implode(' OR ', $a).')');
        }
        return $datasource;
    }


    /**
     * Массовые операции над товарами
     */
    private function _productsMassActions() {
        $tagsToAdd = $this->getArgumentSecure('changeaddtags', 'string');
        $tagsToRemove = $this->getArgumentSecure('changeremovetags', 'string');
        $image = $this->getArgumentSecure('changeimage', 'file');
        $description = trim($this->getArgumentSecure('changedescription', 'string'));

        if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
            foreach ($r[1] as $productID) {
                try {
                    $product = Shop::Get()->getShopService()->getProductByID($productID);

                    if ($this->getControlValue('hide') == 'hide') {
                        $product->setHidden(1);
                    } elseif ($this->getControlValue('hide') == 'unhide') {
                        $product->setHidden(0);
                    }

                    if ($this->getControlValue('delete') == 'delete') {
                        try {
                            // пытаемся удалить полностью
                            Shop::Get()->getShopService()->deleteProduct($product);
                        } catch (Exception $deleteEx) {
                            // если не получилось - то помечаем как удаленный
                            $product->setDeleted(1);
                        }
                    } elseif ($this->getControlValue('delete') == 'undelete') {
                        $product->setDeleted(0);

                    }

                    if ($this->getControlValue('avail') == 'setavail') {
                        $product->setAvail(1);
                    } elseif ($this->getControlValue('avail') == 'setunavail') {
                        $product->setAvail(0);
                    }

                    if ($description) {
                        $product->setDescription($description);
                    }

                    $product->update();

                    if ($tagsToAdd) {
                        Shop::Get()->getShopService()->addTagsToProduct($product, $tagsToAdd);
                    }

                    if ($tagsToRemove) {
                        Shop::Get()->getShopService()->deleteTagsFromProduct($product, $tagsToRemove);
                    }

                    if ($image) {
                        Shop::Get()->getShopService()->updateProductImage($product, $image);
                    }
                } catch (Exception $pe) {

                }
            }
        }
    }

    /**
     * Добавление товаров в существующий заказ
     */
    private function _addProductsExistOrder() {
        try {
            $order = Shop::Get()->getShopService()->getOrderByID( $this->getControlValue('orderid') );

            if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {

                foreach ($r[1] as $productID) {
                    try {
                        Shop::Get()->getShopService()->addOrderProduct($order,$productID);
                    } catch (Exception $pe) {

                    }
                }

                $urlRedirect = $order->makeURLEdit();
                $this->setValue('urlredirect', $urlRedirect);

                if ( $this->getControlValue('gotoorder') ) {
                    header('Location: '.$urlRedirect);
                    exit();
                }
                $this->setValue('message', 'ok');

            }
        } catch (Exception $e) {

        }
    }

    /**
     * Добавление товаров в новый заказ
     */
    private function _addProductsToOrder() {
        try {
            if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                $productsArray = array();
                foreach ($r[1] as $productID) {
                    try {
                        $product = Shop::Get()->getShopService()->getProductByID($productID);
                        $productsArray[] = array(
                        'productid' => $product->getId(),
                        'currencyid' => $product->getCurrencyid(),
                        'price' => $product->getPrice(),
                        'taxrate' => $product->getTaxrate(),
                        'amount' => 1, // количество товаров
                        );
                    } catch (Exception $pe) {

                    }
                }
                $user = Shop::Get()->getUserService()->getUser();
                $result = Shop::Get()->getShopService()->makeOrderByProductArray($user,false,false,false,false,$productsArray,true);
                $order = $result['order'];
                $urlRedirect = $order->makeURLEdit();
                $this->setValue('urlredirect', $urlRedirect);

                if ( $this->getControlValue('gotoorder') ) {
                    header('Location: '.$urlRedirect);
                    exit();
                }
                $this->setValue('message', 'ok');

            }
        } catch (Exception $e) {

        }
    }

    /**
     *  Перемещение товаров
     */
    private function _productsChange() {
        try {
            $toCategoryID = $this->getControlValue('movecategory');
            if ($toCategoryID) {
                $toCategory = Shop::Get()->getShopService()->getCategoryByID($toCategoryID);

                if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                    foreach ($r[1] as $productID) {
                        try {
                            $product = Shop::Get()->getShopService()->getProductByID($productID);
                            $product->setCategoryid($toCategoryID);
                            $product->update();

                            Shop::Get()->getShopService()->buildProductCategories($product);
                        } catch (Exception $pe) {

                        }
                    }
                }
            }

        } catch (Exception $e) {

        }

        try {
            $syncID = $this->getControlValue('changesync');
            if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r) && $syncID != 'notTouch') {
                foreach ($r[1] as $productID) {
                    try {
                        $product = Shop::Get()->getShopService()->getProductByID($productID);
                        $product->setUnsyncable($syncID);
                        $product->update();
                    } catch (Exception $pe) {

                    }
                }
            }
        } catch (Exception $e) {

        }

    }

    /**
     * @return array
     */
    private function _makeCategoryArray() {
        // строим массив всех категорий
        $category = Shop::Get()->getShopService()->makeCategoryTree();
        $a = array();
        foreach ($category as $x) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->getName(),
            'selected' => $x->getId() == $this->getArgumentSecure('categoryid'),
            'url' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('categoryid' => $x->getId())),
            'parentid' => $x->getParentid(),
            'level' => $x->getField('level'),
            );
        }
        return $a;
    }

}