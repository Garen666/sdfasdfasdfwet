<?php
class games_index extends Engine_Class {

    public function process() {
        ini_set('max_input_vars', 10000);
        $allowEdit = $this->getUser()->isAllowed('games');
        $this->setValue('allowEdit', $allowEdit);

        PackageLoader::Get()->registerJSFile('/_js/jQueryFilter.js');

        $arguments = $this->getArguments();
        unset($arguments['categoryid']);
        //$products = $this->_getProducts();

        $openGame = $this->_getOpenGame();
        $gameArray = array();
        if (!$openGame) {
            $games = Shop::Get()->getGameService()->getAllGames();
            while ($x = $games->getNext()) {
                $gameArray[] = array(
                    'id' => $x->getId(),
                    'name' => $x->getName(),
                    'url' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('categoryid' => $x->getId())),
                    'hidden' => $x->getHidden()
                );
            }

            $this->setValue('categoryArrayForFolders', $gameArray);
        }

        //$this->setValue('productsArray', $this->_getProductsArray($products));


        ////////////////////////////////////////////////////////////////////

        if (isset($_SESSION['categoryid']) && $this->getArgumentSecure('page') &&
            $_SESSION['categoryid'] != $this->getArgumentSecure('categoryid')) {
            Shop_URLParser::Get()->_replaceUrl('page');
        }
        $_SESSION['categoryid'] = $this->getArgumentSecure('categoryid');


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

        $query = Engine::GetURLParser()->getGETString();
        if ($query) {
            $this->setValue('query', '?'.$query);
        }

    }

    /**
     * @return ShopGame
     */
    private function _getOpenGame() {
        $openCategory = false;
        $categoryid = $this->getArgumentSecure('categoryid');
        if ($categoryid === '0') { // товары без категории
            return 0;
        } else if ( $categoryid ) {
            $this->setValue('openCategoryId',$categoryid);
            $openCategory = Shop::Get()->getGameService()->getGameByID($categoryid);

            $this->setValue('openCategory', array(
                'parentid' => '',
                'name'=> $openCategory->makeName(),
                'url'=> Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('categoryid' => '')),
            ));
        }
        return $openCategory;
    }

    /**
     * ƒелаем массив категорий дл€ папок и устанавливаем продуктам категорию
     * @param ShopProduct $product
     * @param array $arguments
     * @return array
     */
    private function _makeCategoryArrayForFolders(ShopProduct $product, $arguments = array()) {

        // ≈сли нет категории и фильтров, выводим категории верхнего уровн€
        if ( !$openCategory && empty($arguments)) {
            $product->setCategoryid(0);
            // — категори€ми
            if ($openCategory !== 0) {
                $category = Shop::Get()->getShopService()->getCategoryAll();
                $category->setParentid(0);

                while ($x = $category->getNext()) {
                    $a[$x->getId()] = array(
                        'id' => $x->getId(),
                        'name' => $x->getName(),
                        'url' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('categoryid' => $x->getId())),
                        'hidden' => $x->getHidden()
                    );
                }
            }
        } else if ($openCategory || !empty($arguments)) { // ≈сли есть категори€, или фильтры
            $orArr = array();
            $level = 1;
            $openCategoryId = false;
            if ($openCategory === 0) {
                $openCategoryId = 0;
            } else if (is_object($openCategory)) {
                $level = $openCategory->getLevel();
                $openCategoryId = $openCategory->getId();
            }

            try {
                // выбрана категори€
                if ($openCategoryId != false) {
                    $parentCategory = $openCategory->getParent();
                    $this->setValue('openCategory', array(
                        'parentid' => $parentCategory->getId(),
                        'name'=> $parentCategory->getName(),
                        'url'=>Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('categoryid' => $parentCategory->getId())),
                    ));
                }
            } catch ( Exception $e ) {
                $this->setValue('openCategory', array(
                    'parentid' => '',
                    'name'=> '',
                    'url'=>Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('categoryid' => '')),
                ));
            }
            if ($openCategoryId) {
                // »щим продукты во всех вложенных категори€х
                for ($i = $level; $i <= 10; $i++ ) {
                    $orArr[] = "category{$i}id = {$openCategoryId}";
                }
                $product->addWhereQuery("(" . implode(' OR ', $orArr) . ")");
            }

            // ќпредел€ем категории в которые вход€т найденные продукты
            while ($p = $product->getNext()) {
                try {
                    $category = $p->getCategory();
                    // если выбрана категори€ и она не верхн€€
                    if ($openCategoryId !== false && $category->getParentid() != $openCategoryId) {
                        $category = $this->_getTopParentCategory($category, $level + 1); //  атегори€ на уровень ниже
                    } else if ($openCategoryId === false) { // ≈сли не выбрана категори€
                        $category = $this->_getTopParentCategory($category);
                    }

                    $a[$category->getId()] = array(
                        'id' => $category->getId(),
                        'name' => $category->getName(),
                        'url' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('categoryid' => $category->getId())),
                        'hidden' => $category->getHidden(),
                        'level' => $category->getLevel()
                    );
                } catch (Exception $e) {

                }
            }

            unset($a[$openCategoryId]); // удал€ем текущую категорию с вывода
            $product->setCategoryid($openCategoryId); // выводим товары только текущей категории
        }

        return  $a;
    }

    /**
     * @return array|int
     */
    private function _getProductsArray(ShopGame $game) {

        $gamesArray = array();
        while ($x = $game->getNext()) {
            $gamesArray[] = array(
                'id' => $x->getId(),
                'name' => $x->getName(),
                'url' => $x->makeURLEdit(),
                'image' => $x->makeImageThumb(200,200),
                'hidden' => $x->getHidden()
            );
        }

        return $gamesArray;
    }

    /**
     * @return Datasource_Products
     */
    private function _getDataSource() {

        $datasource =  new Datasource_Products($this->getArgumentSecure('categoryid'));

        $this->setControlValue('filter_show_deleted', $this->getArgumentSecure('filter_show_deleted'));
        $this->setControlValue('filter_show_hidden', $this->getArgumentSecure('filter_show_hidden'));


        if ( !$this->getArgumentSecure('filter_show_deleted' ) ) {
            $datasource->getSQLObject()->addWhere('deleted','0','=');
        }
        if ( !$this->getArgumentSecure('filter_show_hidden' ) ) {
            $datasource->getSQLObject()->addWhere('hidden','0','=');
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
     * ћассовые операции над товарами
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
                            // пытаемс€ удалить полностью
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
     * ƒобавление товаров в существующий заказ
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
     * ƒобавление товаров в новый заказ
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
     *  ѕеремещение товаров
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
}