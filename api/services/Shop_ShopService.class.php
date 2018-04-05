<?php
/**
 * WebProduction Shop (OneClick)
 * @copyright (C) 2011-2013 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @copyright WebProduction
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @package Shop
 */
class Shop_ShopService extends ServiceUtils_AbstractService {

    /**
     * Получить идентификатор сесии
     * с проверкой его состояния
     *
     * @return string
     */
    private function _getSessionID() {
        if (!session_id()) {
            @session_start();
        }

        $sid = @session_id();
        if (!$sid) {
            throw new ServiceUtils_Exception('empty SessionID!');
        }
        return $sid;
    }

    /**
     * @return ShopProduct
     */
    public function getProductByID($id) {
        try {
            return $this->getObjectByID($id, 'ShopProduct');
        } catch (Exception $e) {}
        throw new ServiceUtils_Exception('Shop-object by id not found');
    }



    /**
     * Найти товар по артикулу
     *
     * @param ShopSupplier $supplier
     * @param string $code
     * @return ShopProduct
     */
    public function getProductByArticul($articul) {
        $articul = trim($articul);
        if (!$articul) {
            throw new ServiceUtils_Exception();
        }

        $product = new ShopProduct();
        $product->setArticul($articul);
        if ($product->select()) {
            return $product;
        }

        throw new ServiceUtils_Exception();
    }


    /**
     * Найти товар по URL-префиксу
     *
     * @param string $url
     * @return ShopProduct
     */
    public function getProductByURL($url) {
        $url = trim($url);
        if (!$url) {
            throw new ServiceUtils_Exception();
        }
        return $this->getObjectByField('url', $url, 'ShopProduct', false);
    }

    /**
     * Найти тег по URL-префиксу
     *
     * @param string $url
     * @return ShopProductTag
     */
    public function getProductTagByURL($url) {
        throw new ServiceUtils_Exception();
        /*$url = trim($url);
        if (!$url) {
            throw new ServiceUtils_Exception();
        }
        return $this->getObjectByField('url', $url, 'ShopProductTag', false);*/
    }

    /**
     * @return ShopProductTag
     */
    public function getProductTagByID($id) {
        /*try {
            return $this->getObjectByID($id, 'ShopProductTag');
        } catch (Exception $e) {}*/
        throw new ServiceUtils_Exception('Shop-object by id not found');
    }

    /**
     * Добавить теги к товару
     *
     * @param ShopProduct $product
     * @param string $tags
     */
    public function addTagsToProduct(ShopProduct $product, $tags) {
        if ($product->getTags()) {
            $productTagArray = explode(',', $product->getTags());
        } else {
            $productTagArray = array();
        }
        $tmp = explode(',', $tags);
        foreach ($tmp as $x) {
            $x = trim($x);
            if (!$x) {
                continue;
            }

            if (in_array($x, $productTagArray)) {
                continue;
            }

            $productTagArray[] = $x;
        }
        $product->setTags(implode(',', $productTagArray));
        $product->update();
    }

    /**
     * Удалить теги из товара
     *
     * @param ShopProduct $product
     * @param string $tags
     */
    public function deleteTagsFromProduct(ShopProduct $product, $tags) {
        if (!$tags) {
            return false;
        }

        if ($product->getTags()) {
            $productTagArray = explode(',', $product->getTags());
        } else {
            $productTagArray = array();
        }
        $tmp = explode(',', $tags);
        $a = array();
        foreach ($productTagArray as $x) {
            $x = trim($x);
            if (!$x) {
                continue;
            }

            if (in_array($x, $tmp)) {
                continue;
            }

            $a[] = $x;
        }
        $product->setTags(implode(',', $a));
        $product->update();
    }

    /**
     * @return ShopOrderStatus
     * @param int $id
     */
    public function getStatusByID($id) {
        try {
            return $this->getObjectByID($id, 'ShopOrderStatus');
        } catch (Exception $e) {}
        throw new ServiceUtils_Exception('Shop-object by id not found');
    }



    /**
     * @return ShopPayment
     */
    public function getPaymentByID($id) {
        try {
            return $this->getObjectByID($id, 'ShopPayment');
        } catch (Exception $e) {}
        throw new ServiceUtils_Exception('Shop-object by id not found');
    }

    /**
     * @return ShopPayment
     */
    public function getPaymentAll() {
        $x = new ShopPayment();
        $x->setOrder('name', 'ASC');
        return $x;
    }


    /**
     * Получить все статусы заказов
     *
     * @return ShopOrderStatus
     */
    public function getStatusAll() {
        $x = $this->getObjectsAll('ShopOrderStatus');
        $x->setOrder(array('sort', 'name'), 'ASC');
        return $x;
    }

    /**
     * Получить массив статусов заказов,
     * для которых текущему пользователю разрешена операция
     *
     * @param string $operation
     * @return array
     */
    public function getUsersOrderStatusArray($operation) {
        $user = Shop::Get()->getUserService()->getUser();
        $status = $this->getStatusAll();
        $statusArray = array();
        while ($s = $status->getNext()) {
            if ($user->isAllowed('orders-status-'.$s->getId().'-'.$operation)) {
                $statusArray[] = array(
                'id' => $s->getId(),
                'name' => $s->getName(),
                );
            }
        }
        return $statusArray;
    }

    /**
     * @param ShopOrderStatus $storageName
     * @param string $operation
     * @return boolean
     */
    public function isOrderStatusOperationAllowed($orderStatus, $operation) {
        // @todo
        return true;

        /*$user = Shop::Get()->getUserService()->getUser();
        return $user->isAllowed('orderstatus-'.$orderStatus->getId().'-'.$operation);*/
    }

    /**
     * Обновить менеджера заказа
     *
     * @param ShopOrder $order
     * @param User $manager
     */
    public function updateOrderManager(ShopOrder $order, User $manager) {
        $order->setManagerid($manager->getId());
        $order->update();
    }

    /**
     * @return ShopOrderCategory
     */
    public function getOrderCategoryByID($id) {
        try {
            return $this->getObjectByID($id, 'ShopOrderCategory');
        } catch (Exception $e) {}
        throw new ServiceUtils_Exception('Shop-object by id not found');
    }

    /**
     * Получить все категории
     *
     * @return ShopOrderCategory
     */
    public function getOrderCategoryAll() {
        return $this->getWorkflowsAll();
    }

    /**
     * Получить все workflow
     *
     * @return ShopOrderCategory
     */
    public function getWorkflowsAll($user = false, $currentWorkflowID = false) {
        $x = $this->getObjectsAll('ShopOrderCategory');
        $x->setOrder('name', 'ASC');

        if ($user) {
            if ($user->isDenied('orders-category-all-view')) {
                $workflow = $this->getWorkflowsAll();
                $a = array(-1);
                while ($w = $workflow->getNext()) {
                    if ($user->isAllowed('orders-category-'.$w->getId().'-view')) {
                        $a[] = $w->getId();
                    }
                }
                if ($currentWorkflowID) {
                    $a[] = $currentWorkflowID;
                }
                $x->addWhereArray($a);
            }
        }

        return $x;
    }

    /**
     * Получить все активные workflow
     *
     * @return ShopOrderCategory
     */
    public function getWorkflowsActive($user = false) {
        $x = $this->getWorkflowsAll($user);
        $x->setHidden(0);
        return $x;
    }

    /**
     * Обновить настройки статуса
     *
     * @param ShopOrderStatus $status
     * @param string $name
     * @param string $description
     * @param string $term
     * @param unknown_type $period
     * @param string $roleID
     * @param string $colour
     * @param string $smart
     * @param bool $onlyauto
     * @param bool $notify_sms_client
     * @param bool $notify_sms_admin
     * @param bool $notify_sms_manager
     * @param bool $notify_email_client
     * @param bool $notify_email_admin
     * @param bool $notify_email_manager
     * @param bool $need_payment
     * @param bool $need_prepayment
     * @param bool $need_content
     * @param bool $need_document
     * @param bool $closed
     * @param bool $saled
     * @param bool $shipped
     * @param string $autorepeat_period
     * @param int $autorepeat_term
     * @param bool $storage_incoming
     * @param int $storagenameid_incoming
     * @param bool $storage_sale
     * @param bool $storage_reserve
     * @param bool $storage_unreserve
     * @param bool $storage_return
     */
    public function editStatus(ShopOrderStatus $status, $name,
    $description, $term, $period, $roleID, $managerID, $jumpManager,
    $colour, $smart, $onlyauto,
    $onlyIssue, $notify_sms_client, $notify_sms_admin, $notify_sms_manager,
    $notify_email_client, $notify_email_admin, $notify_email_manager,
    $need_payment, $need_prepayment, $need_content, $need_document,
    $closed, $saled, $shipped, $autorepeat_period, $autorepeat_term,
    $storage_incoming, $storagenameid_incoming, $storage_sale,
    $storage_reserve, $storage_unreserve, $storage_return,
    $orderSupplier
    ) {
        try {
            SQLObject::TransactionStart();

            $name = trim(htmlspecialchars($name));
            $description = trim($description);

            $autorepeat_term = (int) $autorepeat_term;

            $status->setName($name);
            $status->setContent($description);
            $status->setTermperiod($period);
            $status->setRoleid($roleID);
            $status->setManagerid($managerID);
            $status->setJumpmanager($jumpManager);
            $status->setColour($colour);
            $status->setSmart($smart);
            $status->setOnlyauto($onlyauto);
            $status->setOnlyissue($onlyIssue);
            $status->setNotifyemailclient($notify_email_client);
            $status->setNotifyemailadmin($notify_email_admin);
            $status->setNotifyemailmanager($notify_email_manager);
            $status->setPayed($need_payment);
            $status->setPrepayed($need_prepayment);
            $status->setNeedcontent($need_content);
            $status->setNeeddocument($need_document);
            $status->setClosed($closed);
            $status->setSaled($saled);
            $status->setShipped($shipped);
            $status->setAutorepeatperiod($autorepeat_period);
            $status->setAutorepeatterm($autorepeat_term);
            $status->setStorage_incoming($storage_incoming);
            $status->setStoragenameid_incoming($storagenameid_incoming);
            $status->setStorage_sale($storage_sale);
            $status->setStorage_reserve($storage_reserve);
            $status->setStorage_unreserve($storage_unreserve);
            $status->setStorage_return($storage_return);
            $status->update();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Получить все источники
     *
     * @return ShopSource
     */
    public function getSourceAll() {
        $x = $this->getObjectsAll('ShopSource');
        $x->setOrder('name', 'ASC');
        return $x;
    }

    /**
     * @return ShopSource
     */
    public function getSourceByID($id) {
        try {
            return $this->getObjectByID($id, 'ShopSource');
        } catch (Exception $e) {}
        throw new ServiceUtils_Exception('Shop-object by id not found');
    }

    /**
     * Получить массив категорий заказов,
     * к которым текущему пользователю есть доступ
     *
     * @return array
     */
    public function getOrderCategoryIDArrayByUser(User $user, $operation) {
        $categories = $this->getOrderCategoryAll();
        $a = array(-1);

        if ($user->isAllowed('order-category-0-'.$operation)) {
            $a[] = 0;
        }

        while ($s = $categories->getNext()) {
            if ($user->isAllowed('order-category-'.$s->getId().'-'.$operation)) {
                $a[] = $s->getId();
            }
        }
        return $a;
    }

    /**
     * Разрешено ли пользователю просматривать заказ
     *
     * @param ShopOrder $order
     * @param User $user
     * @return bool
     */
    public function isOrderViewAllowed(ShopOrder $order, User $user) {
        // свои заказы видно всегда
        if ($order->getUserid() == $user->getId()
        || $order->getAuthorid() == $user->getId()
        || $order->getManagerid() == $user->getId()
        ) {
            return true;
        }

        if ($user->isDenied('orders')) {
            return false;
        }

        if ($user->isAllowed('orders-all-view')) {
            return true;
        }

        $isBox = Engine::Get()->getConfigField('project-box');

        if ($user->isDenied('orders-status-all-view')) {
            if ($user->isDenied('orders-status-'.$order->getStatusid().'-view')) {
                return false;
            }
        }

        // проверка, является ли он участником заказа
        $oes = new XShopOrderEmployer();
        $oes->setOrderid($order->getId());
        $oes->setManagerid($user->getId());
        $isOrderEmployer = $oes->select() > 0;

        if ($user->isDenied('orders-manager-all-view')) {
            if ($user->isDenied('orders-manager-'.$order->getAuthorid().'-view')
            && $user->isDenied('orders-manager-'.$order->getUserid().'-view')
            && $user->isDenied('orders-manager-'.$order->getManagerid().'-view')
            && !$isOrderEmployer
            ) {
                return false;
            }
        }

        if ($user->isDenied('orders-category-all-view')) {
            if ($user->isDenied('orders-category-'.$order->getCategoryid().'-view')) {
                return false;
            }
        }

        return true;
    }

    /**
     * Разрешено ли пользователю управлять заказом
     *
     * @return bool
     * @param ShopOrder $order
     * @param User $user
     */
    public function isOrderChangeAllowed(ShopOrder $order, User $user) {
        // свои заказы видно всегда
        if ($order->getUserid() == $user->getId()
        || $order->getAuthorid() == $user->getId()
        || $order->getManagerid() == $user->getId()
        ) {
            return true;
        }

        if ($user->isDenied('orders')) {
            return false;
        }

        if ($user->isAllowed('orders-all-edit')) {
            return true;
        }

        $isBox = Engine::Get()->getConfigField('project-box');

        if ($user->isDenied('orders-status-all-change')) {
            if ($user->isDenied('orders-status-'.$order->getStatusid().'-change')) {
                return false;
            }
        }

        // проверка, является ли он участником заказа
        $oes = new XShopOrderEmployer();
        $oes->setOrderid($order->getId());
        $oes->setManagerid($user->getId());
        $isOrderEmployer = $oes->select() > 0;

        if ($user->isDenied('orders-manager-all-change')) {
            if ($user->isDenied('orders-manager-'.$order->getAuthorid().'-change')
            && $user->isDenied('orders-manager-'.$order->getUserid().'-change')
            && $user->isDenied('orders-manager-'.$order->getManagerid().'-change')
            && !$isOrderEmployer
            ) {
                return false;
            }
        }

        if ($user->isDenied('orders-category-all-change')) {
            if ($user->isDenied('orders-category-'.$order->getCategoryid().'-change')) {
                return false;
            }
        }

        return true;
    }

    /**
     * Дерево-массив объектов ShopCategory
     *
     * @return array
     * @param int $rootID
     */
    public function makeCategoryTree($rootID = 0) {
        $category = $this->getCategoryAll();
        $a = array();
        while ($x = $category->getNext()) {
            $a[$x->getParentid()][] = $x;
        }

        return $this->_makeCategoryTree($rootID, 0, $a);
    }

    private function _makeCategoryTree($parentID, $level, $categoryArray) {
        $a = array();
        if (empty($categoryArray[$parentID])) {
            return $a;
        }
        foreach ($categoryArray[$parentID] as $x) {
            // хитро дописываем поле level
            $x->setField('level', $level);

            $a[] = $x;
            $childs = $this->_makeCategoryTree($x->getId(), $level + 1, $categoryArray);
            foreach ($childs as $y) {
                $a[] = $y;
            }
        }
        return $a;
    }

    /**
     * @param int $id
     * @return ShopCategory
     */
    public function getCategoryByID($id) {
        return $this->getObjectByID($id, 'ShopCategory');
    }

    /**
     * Найти категорию по URL-префиксу
     *
     * @param string $url
     * @return ShopCategory
     */
    public function getCategoryByURL($url) {
        $url = trim($url);
        if (!$url) {
            throw new ServiceUtils_Exception('Empty url');
        }

        return $this->getObjectByField('url', $url, 'ShopCategory', false);
    }





    /**
     * @return ShopCategory
     */
    public function getCategoryAll() {
        $x = new ShopCategory();
        $x->setOrder(array('sort', 'name'), 'ASC');
        return $x;
    }

    /**
     * @return ShopCategory
     */
    public function getCategoriesByParentID($parentID) {
        $x = $this->getCategoryAll();
        $x->setParentid($parentID);
        return $x;
    }

    /**
     * Получить уровень вложенности категории
     *
     * @param ShopCategory $category
     * @return int
     */
    public function getCategoryLevel(ShopCategory $category) {
        $level = 1; // уровень
        $a = array(); // массив пройденных элементов
        $x = clone $category;
        while (1) {
            try {
                // если элемент уже был
                if (!empty($a[$x->getId()])) {
                    break;
                }
                $a[$x->getId()] = true; // этот элемент уже прошли

                $x = $x->getParent();
                $level++;
            } catch (Exception $e) {
                break;
            }
        }
        return $level;
    }

    /**
     * Получить массив всех родительских категорий
     *
     * @param ShopCategory $category
     * @return array of int
     */
    protected function _getCategoryParentsArray(ShopCategory $category) {
        // если данные есть в кеше - сразу выдаем их
        if (isset($this->_categoryTreeArray[$category->getId()])) {
            return $this->_categoryTreeArray[$category->getId()];
        }

        $a = array(); // массив пройденных элементов
        $x = clone $category;
        while (1) {
            try {
                // если элемент уже был
                if (in_array($x->getId(), $a)) {
                    break;
                }
                $a[] = $x->getId(); // этот элемент уже прошли

                $x = $x->getParent();
            } catch (Exception $e) {
                break;
            }
        }

        $a = array_reverse($a);

        // заносим данные в кеш
        $this->_categoryTreeArray[$category->getId()] = $a;

        return $a;
    }

    /**
     * Обновить товару категорию
     *
     * @param ShopProduct $product
     * @param ShopCategory $category
     */
    public function updateProductCategory(ShopProduct $product, ShopCategory $category) {
        try {
            SQLObject::TransactionStart();

            $product->setCategoryid($category->getId());
            $this->buildProductCategories($product);

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Перестроить кеш 1..10 из категорий для товара $product
     *
     * @param ShopProduct $product
     */
    public function buildProductCategories(ShopProduct $product) {
        try {
            SQLObject::TransactionStart();

            if ($product->getCategoryid()) {
                $a = $this->_getCategoryParentsArray(
                $product->getCategory()
                );
            } else {
                $a = array();
            }

            for ($i = 1; $i <= 10; $i++) {
                @$product->setField('category'.$i.'id', $a[$i-1]);
            }

            $product->update();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }





    public function addProductChange(ShopProduct $product) {

        $tmp = new ShopProduct($product->getId());
        $oldValueArray = $tmp->getValues();

        try {
            $userID = Shop::Get()->getUserService()->getUser()->getId();
        } catch (Exception $e) {
            $userID = 0;
        }

        $date = date('Y-m-d H:i:s');

        foreach ($oldValueArray as $fieldName => $fieldValueOld) {
            if ($fieldName == 'udate') {
                continue;
            }

            if ($fieldName == 'viewed') {
                continue;
            }

            $fieldValueNew = $product->getField($fieldName);

            if ($fieldValueOld == $fieldValueNew) {
                continue;
            }

            if (!$fieldValueOld && !$fieldValueNew) {
                continue;
            }

            $x = new XShopProductChange();
            $x->setProductid($product->getId());
            $x->setUserid($userID);
            $x->setCdate($date);
            $x->setKey($fieldName);
            $x->setValueold($fieldValueOld);
            $x->setValuenew($fieldValueNew);
            $x->insert();
        }
    }



    /**
     * @return ShopProduct
     */
    public function getProductsTop() {
        $x = $this->getProductsAll();
        $x->setTop(1);
        $x->setHidden(0);
        return $x;
    }

    /**
     * @return ShopProduct
     */
    public function getProductsAll() {
        $x = new ShopProduct();
        $x->setOrder('name', 'ASC');
        return $x;
    }

    /**
     * @return ShopProduct
     * @param ShopProduct $products
     */
    public function setProductsDateLifeFilter($products) {
        $dateNow = date('Y-m-d');
        $products->addWhereQuery('(`datelifefrom` = \'0000-00-00\' OR DATE(`datelifefrom`) <= \''.$dateNow.'\' )');
        $products->addWhereQuery('(`datelifeto` = \'0000-00-00\' OR DATE(`datelifeto`) >= \''.$dateNow.'\' )');
        return $products;
    }

    /**
     * @param ShopCategory $category
     * @return ShopProduct
     */
    public function getProductsByCategory(ShopCategory $category) {
        $x = $this->getProductsAll();

        $level = $category->getLevel();
        $x->setField('category'.$level.'id', $category->getId());
        return $x;
    }

    /**
     * Получить продукты по всем доступным категориям
     *
     * @param ShopCategory $category
     * @return ShopProduct
     */
    public function getProductsByCategoryIDArray($categoryIDArray) {
        $x = $this->getProductsAll();

        if (!$categoryIDArray) {
            $categoryIDArray = array(-1);
        }

        $a = array();
        for ($j = 1; $j <= 10; $j++) {
            $a[] = "category{$j}id IN (".implode(',', $categoryIDArray).")";
        }

        $x->addWhereQuery("(".implode(' OR ', $a).")");
        return $x;
    }
    
    /**
     * получить ближайшую категорию с фильтрами по умолчанию
     * @param ShopProduct $product
     * @return ShopCategory $category
     */
    private function _getCategoryWithFilterDefault(ShopProduct $product) {
        for ($i = 10; $i >= 1; $i--) {
            try {
                $categoryId = $product->getField('category' . $i . 'id');
                $category = Shop::Get()->getShopService()->getCategoryByID($categoryId);

                try {
                    $filter_count = Engine::Get()->getConfigField('filter_count');
                } catch (Exception $e) {
                    $filter_count = 10;
                }

                for ($j = 1; $j <= $filter_count; $j++) {

                    $filter = $category->getField('filter' . $j . 'id');
                    if ($filter) {
                        return $category;
                    }
                }
            } catch (Exception $e) {
                
            }
        }
        throw new ServiceUtils_Exception();
    }

    /**
     * Получить товары юзера
     *
     * @param int $userID
     * @return ShopProduct
     */
    public function getProductsUser($userID) {
        $user = Shop::Get()->getUserService()->getUserByID($userID);
        $x = $this->getProductsAll();
        $x->setUserid($user->getId());
        return $x;
    }

    /**
     * Поиск товара по штрих-коду
     *
     * @param string $barcode
     * @return ShopProduct
     */
    public function getProductByBarcode($barcode) {
        $barcode = trim($barcode);

        $product = new ShopProduct();
        $product->addWhere('barcode', $barcode, 'LIKE');
        $product->setLimitCount(1);
        return $product->getNext(true);
    }

    /**
     * Получить максимальную цену товара в текущей валюте
     *
     * @return type
     */
    public function getProductMaxPrice(ShopProduct $product, ShopCurrency $currencyDefault) {
        $product->leftJoinTable($currencyDefault->getTablename(), 'currencyid='.$currencyDefault->getTablename().'.id');
        $product->addFieldQuery(' (price / '.$currencyDefault->getRate().' * '.$currencyDefault->getTablename().'.rate ) as pr');
        $product->setLimitCount(1);
        $product->setOrder(array('`pr` DESC'));
        if ($p = $product->getNext()) {
            return $p->makePriceWithTax($currencyDefault);
        }
        return 0;
    }

    /**
     * Поиск товаров
     *
     * @param string $query
     * @param bool $log
     * @return ShopProduct
     */
    public function searchProducts($query, $log = true) {
        $query = trim($query);
        if (strlen($query) < 3 && !is_numeric($query)) {
            throw new ServiceUtils_Exception();
        }

        $products = $this->getProductsAll();
        $connection = $products->getConnectionDatabase();

        // перестановки всех слов
        $a = array();
        if (preg_match_all("/([\.\d\pL]+)/ius", $query, $r)) {
            foreach ($r[1] as $part) {
                $a[] = $connection->escapeString($part);
            }
        }

        if (!$a) {
            throw new ServiceUtils_Exception();
        }

        $products->setDeleted(0);

        // Если user.level>=2 то искать даже hidden товары
        // issue #17016
        try {
            if (!Shop::Get()->getUserService()->getUser()->isAdmin()) {
                throw new ServiceUtils_Exception();
            }
        } catch (Exception $e) {
            $products->setHidden(0);
        }


        foreach ($a as $part) {
            $w = array();
            $orderBy = array();

            if (is_numeric($part)) {
                $w[] = $products->getTablename().".id = '$part'";
                // если длинна строки == 13 - значит поиск по штрих-коду
                if (strlen($part) == 13) {
                    $w[] = $products->getTablename().".barcode = '$part'";
                }
            }

            $w[] = $products->getTablename().".name LIKE '%$part%'";
            $w[] = $products->getTablename().".seokeywords LIKE '%$part%'";
            $w[] = $products->getTablename().".description LIKE '%$part%'";
            $w[] = $products->getTablename().".tags LIKE '%$part%'";

            $orderBy[] = "(CASE WHEN {$products->getTablename()}.`name` LIKE '%$part%' THEN 2 ELSE 0 END)";

            // превращаем в en транскрипцию
            try {
                $partTr = StringUtils_Transliterate::TransliterateRuToEn($part);

                $partTr = $connection->escapeString($partTr);

                $w[] = $products->getTablename().".name LIKE '%$partTr%'";
                $w[] = $products->getTablename().".seokeywords LIKE '%$partTr%'";
                $w[] = $products->getTablename().".description LIKE '%$partTr%'";

                $orderBy[] = "(CASE WHEN {$products->getTablename()}.`name` LIKE '%$partTr%' THEN 1 ELSE 0 END)";
            } catch (Exception $e) {

            }

            // превращаем ru
            try {
                $partRu = StringUtils_Transliterate::TransliterateCorrectTo('ru', $part);

                $partRu = $connection->escapeString($partRu);

                $w[] = $products->getTablename().".name LIKE '%$partRu%'";
                $w[] = $products->getTablename().".seokeywords LIKE '%$partRu%'";
                $w[] = $products->getTablename().".description LIKE '%$partRu%'";

                $orderBy[] = "(CASE WHEN {$products->getTablename()}.`name` LIKE '%$partRu%' THEN 1 ELSE 0 END)";
            } catch (Exception $e) {

            }

            // превращаем en
            try {
                $partEn = StringUtils_Transliterate::TransliterateCorrectTo('en', $part);

                $partEn = $connection->escapeString($partEn);

                $w[] = $products->getTablename().".name LIKE '%$partEn%'";
                $w[] = $products->getTablename().".seokeywords LIKE '%$partEn%'";
                $w[] = $products->getTablename().".description LIKE '%$partEn%'";

                $orderBy[] = "(CASE WHEN {$products->getTablename()}.`name` LIKE '%$partEn%' THEN 1 ELSE 0 END)";
            } catch (Exception $e) {

            }

            $products->addWhereQuery("(".implode(' OR ', $w).")");
        }

        $products->addFieldQuery(implode('+', $orderBy).' AS relevance');
        $products->setOrder('`relevance`', 'DESC');

        return $products;
    }


    /**
     * @param $query
     * @return array
     */
    public function searchDublicatesByName($query) {
        try {
            $connection = ConnectionManager::Get()->getConnectionDatabase();
            $query = $connection->escapeString($query);
            $query = str_replace(' ', '%', $query);

            $sql = "SELECT id, name, namelast, namemiddle from users where name like '$query%' and namelast = ''";

            $result = array();
            $q = $connection->query($sql);
            while ($x = $connection->fetch($q)) {
                $id = $x['id'];
                $url = false;
                try {
                    $user = Shop::Get()->getUserService()->getUserByID($id);
                    $url = $user->makeURLEdit();
                } catch (Exception $e ){
                    continue;
                }
                $result[] = array(
                'id' => $id,
                'name' => $user->makeName(),
                'url' => $url
                );
            }
            // @todo: sort bug!
            usort($result,create_function('$a,$b','return $a["name"]>$b["name"];'));
            return $result;
        } catch (Exception $e) {
            throw $e;
        }

    }


    /**
     * @param $query
     * @return array
     */
    public function searchDublicatesByEmail($query) {
        try {
            $connection = ConnectionManager::Get()->getConnectionDatabase();
            $query = $connection->escapeString($query);
            $query = trim($query);

            $sql = "SELECT id, email from users where email like '$query%'";

            $result = array();
            $q = $connection->query($sql);
            while ($x = $connection->fetch($q)) {
                $id = $x['id'];
                $mail = $x['email'];
                $url = false;
                try {
                    $user = Shop::Get()->getUserService()->getUserByID($id);
                    $url = $user->makeURLEdit();
                    //используемое поле
                    $user_email = $user->getEmail();
                    $user_email = strtolower($user_email);
                    $query = strtolower($query);

                } catch (Exception $e) {
                    continue;
                }
                $result[] = array(
                    'id' => $id,
                    'email' => $mail,
                    'url' => $url
                );
            }
            // @todo: sort bug!
            //usort($result,create_function('$a,$b','return $a["name"]>$b["name"];'));
            return $result;
        } catch (Exception $e) {
            throw $e;
        }
    }



    public function searchDublicatesByNameSurname($name, $namelast) {
        try {
            $connection = ConnectionManager::Get()->getConnectionDatabase();
            $name = $connection->escapeString($name);
            $name = str_replace(' ', '%', $name);

            $namelast = $connection->escapeString($namelast);
            $namelast = str_replace(' ', '%', $namelast);

            $sql = "SELECT id, name, namelast, namemiddle  from users where name like '$name%' and namelast like '$namelast%'";

            $result = array();
            $q = $connection->query($sql);
            while ($x = $connection->fetch($q)) {
                $id = $x['id'];
                $url = false;
                try {
                    $user = Shop::Get()->getUserService()->getUserByID($id);
                    $url = $user->makeURLEdit();
                } catch (Exception $e ){
                    continue;
                }
                $result[] = array(
                'id' => $id,
                'name' => $user->makeName(),
                'url' => $url
                );
            }
            // @todo: sort bug!
            usort($result,create_function('$a,$b','return $a["name"]>$b["name"];'));
            return $result;

        } catch ( Exception $e ) {
            throw $e;
        }

    }

    /**
     * Отметить товар как +1 к просмотренным
     *
     * @param ShopProduct $product
     */
    public function viewProduct(ShopProduct $product) {
        try {
            SQLObject::TransactionStart();

            $view = new XShopProductView();
            $view->setSessionid($this->_getSessionID());
            $view->setIp(@$_SERVER['REMOTE_ADDR']);
            try {
                $user = Shop::Get()->getUserService()->getUser();
                $view->setUserid($user->getId());
            } catch (Exception $e) {

            }
            $view->setCdate(date('Y-m-d H:i:s'));
            $view->setProductid($product->getId());
            $view->insert();

            $product->setViewed($product->getViewed() + 1);
            $product->update();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }




    /**
     * Оформить заказ.
     * Все суммы заказа фиксируются в системной валюте.
     * То есть, Order и все OrderProduct изначально будут в одной валюте.
     *
     * @param string $name
     * @param string $phone
     * @param string $email
     * @param string $address
     * @param string $contacts
     * @param string $comments
     * @param User $user
     * @param int $deliveryID
     * @param int $paymentID
     * @param boolean $isAdmin
     * @return ShopOrder
     */
    public function makeOrder($name, $phone, $email, $address, $contacts, $comments, $user, $deliveryID, $paymentID, $isAdmin = false, $gift = false) {
        /**
         * Общий алгоритм оформления заказа:
         *
         * 1. При оформлении заказа все суммы товаров и сумма заказа будет
         * в системной валюте.
         * 2. Будет выбрано активное юрлицо по умолчанию - и оно будет выставлено
         * в заказ.
         * 3. Все стоимости товаров будут приведены к полной стоимости включая НДС
         * (если НДС указан в самом товаре). НДС контрактора не будет использоваться.
         *
         * Уже в управлении заказом чтобы посчитать НДС нужно будет от суммы заказа снять
         * процент НДС.
         */

        try {
            SQLObject::TransactionStart();

            $name = trim($name);
            $email = trim($email);
            $address = trim($address);
            $contacts = trim($contacts);
            $comments = trim($comments);

            $ex = new ServiceUtils_Exception();

            if (empty($name)) {
                $ex->addError('name');
            }

            if ($email) {
                if (!Checker::CheckEmail($email)) {
                    $ex->addError('email');
                }
            }

            if (!$email && !$isAdmin) {
                $ex->addError('email');
            }

            // получаем системную валюту, в которой будем оформлять заказ
            $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();

            // поиск категории по умолчанию
            $category = new ShopOrderCategory();
            $category->setDefault(1);
            if ($category->select()) {
                $categoryID = $category->getId();
            } else {
                $categoryID = 0;
            }

            // поиск статуса заказа по умолчанию
            try {
                $statusDefault = new ShopOrderStatus();
                $statusDefault->setDefault(1);
                $statusDefault->setCategoryid($categoryID);
                $statusDefault->select();
            } catch (Exception $e) {

            }


            // оформление заказа
            $order = new ShopOrder();
            $order->setCdate(date('Y-m-d H:i:s'));

            // если указан пользователь - оформляем заказ на него
            if ($user) {
                $order->setUserid($user->getId());
                $user->getEmail() ? false : $user->setEmail($email);
                $user->update();
            }


            $order->setStatusid($statusDefault->getId());
            $order->setCategoryid($categoryID);
            $order->setComments($comments);

            $this->_setOrderUTM($order);

            // кто автор заказа
            try {
                $order->setAuthorid(Shop::Get()->getUserService()->getUser()->getId());
            } catch (Exception $authorEx) {
                // иначе автор - это клиент
                $order->setAuthorid($order->getUserid());
            }

            // кто менеджер заказа
            try {
                $manager = Shop::Get()->getUserService()->getUser();
                if ($manager->isManager()) {
                    $order->setManagerid($manager->getId());
                }
            } catch (Exception $managerEx) {

            }

            // если способ оплаты
            if ($paymentID) {
                try {
                    $payment = $this->getPaymentByID($paymentID);
                    $order->setPaymentid($payment->getId());
                } catch(Exception $ge){

                }
            }

            $needaddress = true;

            // если есть доставка
            $deliveryPrice = 0;
            if ($deliveryID) {
                try {
                    $delivery = Shop::Get()->getDeliveryService()->getDeliveryByID($deliveryID);
                    $deliveryPrice = $delivery->makePrice($currencyDefault);
                    $order->setDeliveryid($delivery->getId());
                    $order->setDeliveryprice($deliveryPrice);

                    $needaddress = ($delivery->getNeedaddress() || $delivery->getNeedcity());
                } catch(Exception $ge) {

                }
            }

            if (!$address && $needaddress && $deliveryID && !$isAdmin) {
                $ex->addError('address');
            }

            if ($ex->getCount()) {
                throw $ex;
            }

            // вставляем заказ
            $order->insert();

            // вставляем историю
            $change = new XShopOrderChange();
            if ($user) {
                $change->setUserid($user->getId());
            }
            $change->setOrderid($order->getId());
            $change->setCdate($order->getCdate());
            $change->setKey('statusid');
            $change->setValue($order->getStatusid());
            $change->insert();

            // сумма заказа
            $sum = 0;
            $baskets = $this->getBasketProducts();
            $count = 0;
            $dateFrom = false;
            $dateTo = false;
            while ($x = $baskets->getNext()) {
                try {
                    $product = $x->getProduct();
                    // приводим стоимость товара к НДС и скидке в самом товаре, к валюте заказа

                    //теперь определяем стоимость товара используя метод корзины
                    //$price = $product->makePriceWithTax($currencyDefault);
                    $price = $x->makePriceWithTax($currencyDefault);

                    // вставляем запись
                    $op = new ShopOrderProduct();
                    $op->setOrderid($order->getId());
                    $op->setProductid($x->getProductid());
                    $op->setDatefrom($x->getDatefrom());
                    $op->setDateto($x->getDateto());

                    if ($x->getDatefrom() < $dateFrom) {
                        $dateFrom = $x->getDatefrom();
                    }

                    if ($x->getDateto() > $dateTo) {
                        $dateTo = $x->getDateto();
                    }


                        $op->setProductname($product->getName());
                    try {
                        $op->setCategoryname($product->getCategory()->makePathName());
                    } catch (Exception $categoryEx) {

                    }
                    $op->setProductprice($price);
                    $op->setCurrencyid($currencyDefault->getId());

                    // устанавливаем комментарий согласно опций заказа
                    $productCommentArray = array();

                    $op->setComment(implode(', ', $productCommentArray));

                    $op->setParams($x->getParams());

                    $op->insert();

                    // считаем сумму заказа.
                    // при подсчете приводим цену к округлению НДС контрактора
                    $priceWithoutTax = $this->calculateSum(
                        $price,
                        $contractorTax,
                        0,
                        0,
                        true, // return sum
                        false, // + vat tax
                        false // without discount
                    );

                    $sum += round($priceWithoutTax * $x->getProductcount(), 2);

                    // увеличиваем счетчик заказа товаров на +1
                    $product->setOrdered($product->getOrdered() + 1);
                    $product->setLastordered(date('Y-m-d H:i:s'));
                    $product->update();

                    $count ++;
                } catch (Exception $e) {

                }

            }

            // если нет строк - нет заказа
            if (!$count) {
                throw new ServiceUtils_Exception('count');
            }


            // увеличиваем стоимость заказа на сумму доставки
            // Внимание! Доставка в сумме заказа уже не фигурирует!
            // $sum += $deliveryPrice;

            // записываем сумму заказа и валюту
            $order->setSum($sum);
            // сумма заказа в системной валюте
            $order->setSumbase($sum);
            $order->setCurrencyid($currencyDefault->getId());

            // формируем записываем Hash заказа
            // для трек-ссылки заказа
            $order->setHash(md5($order->getId().$order->getCdate()));

            /*if ($dateFrom) {
                $order->getCdate($dateFrom);
            }*/
            if ($dateTo) {
                $order->setDateto($dateTo);
            }

            // обновляем заказ
            $order->update();

            // событие после добавления заказа
            $event = Events::Get()->generateEvent('shopOrderAddAfter');
            $event->setOrder($order);
            $event->notify();

            // отправляем сообщения всем
            $this->_orderSendmail($order);


            SQLObject::TransactionCommit();

            return $order;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Добавить товар в заказ.
     * После добавления рекомендуется пересчитать цены методом
     * recalculateOrderSums()
     *
     * @see recalculateOrderSums()
     *
     * @param ShopOrder $order
     * @param int $productID
     * @param float $productCount
     * @return ShopOrderProduct
     */
    public function addOrderProduct(ShopOrder $order, $productID, $productCount = 1) {
        try {
            SQLObject::TransactionStart();

            $product = $this->getProductByID($productID);

            // @todo: need method to normalize string > float
            $productCount = trim($productCount);
            $productCount = str_replace(',', '.', $productCount);
            $productCount = (float) $productCount;
            if ($productCount <= 0) {
                $productCount = 1;
            }

            $op = new ShopOrderProduct();
            $op->setOrderid($order->getId());
            $op->setProductid($product->getId());
            $op->setProductname($product->getName());
            try {
                $op->setCategoryname($product->getCategory()->makePathName());
            } catch (Exception $e) {

            }
            $op->setProductprice($product->makePriceWithTax($order->getCurrency()));
            $op->setCurrencyid($order->getCurrencyid());
            $op->setProductcount($productCount);
            $op->insert();

            SQLObject::TransactionCommit();

            return $op;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }


    /**
     * Посчитать стоимости заказа и обновить его.
     * Метод используется при добавлении OrderProduct-ов внутрь заказа.
     *
     * @param ShopOrder $order
     */
    public function recalculateOrderSums(ShopOrder $order) {
        try {
            SQLObject::TransactionStart();

            // пересчитываем заказ в валюту заказа
            $currencyDefault = $order->getCurrency();

            // полная сумма заказа
            $sum = 0;

            // проходимся по каждому товарару в заказе
            $orderproducts = $order->getOrderProducts();
            while ($op = $orderproducts->getNext()) {

                // цена без ПДВ
                $price = Shop::Get()->getShopService()->calculateSum(
                $op->makePrice($currencyDefault),
                $contractorTax,
                0,
                0,
                true, // return sum
                false, // + vat tax
                false // without discount
                );

                $sum += round($price * $op->getProductcount(), 2);
            }

            // увеличиваем сумму заказа на стоимость доставки
            // Внимание! Доставка в сумме заказа уже не фигурирует!
            // $sum += $order->getDeliveryprice();


            $sum = Shop::Get()->getShopService()->calculateSum(
            $sum,
            0,
            $discountPercent,
            $discountValue,
            true,  // + sum
            true,  // + tax vat
            false  // - discount
            );


            // записываем суммы
            $order->setSum($sum);
            // сумма заказа в системной валюте
            $order->setSumbase(Shop::Get()->getCurrencyService()->convertCurrency($sum, $currencyDefault, Shop::Get()->getCurrencyService()->getCurrencySystem()));
            $order->update();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }


    /**
     * Оплатить заказ.
     * Заказ переходит в статус "Оплачено"
     *
     * @todo а нужен ли метод вообще?
     *
     * @param int $orderID
     * @param float $amount
     */
    public function payOrder($orderID, $amount) {
        try {
            SQLObject::TransactionStart();

            $order = $this->getOrderByID($orderID);
            $payAmount = round($amount, 2);
            $orderAmount = round($order->getSum(), 2);

            // несовпадение сумм
            if ($orderAmount != $payAmount) {
                throw new ServiceUtils_Exception();
            }

            // находим статус "Оплачено"
            $status = new XShopOrderStatus();
            $status->setPayed(1);
            if (!$status->select()) {
                // нет статуса "Оплачено"
                throw new ServiceUtils_Exception();
            }

            $cuser = Shop::Get()->getUserService()->getUser();
            $this->updateOrderStatus($cuser, $order, $status->getId(), true);

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Удалить заказ/задачу.
     * Фактически ставится пометка deleted=1
     *
     * @param ShopOrder $order
     */
    public function deleteOrder(ShopOrder $order, $user = false) {
        try {
            SQLObject::TransactionStart();

            $event = Events::Get()->generateEvent('shopOrderDeleteBefore');
            $event->setOrder($order);
            $event->notify();

            // чистка заказаного товара
            // уже не надо, так как deleted=1
            //$orderproduct = $order->getOrderProducts();
            //$orderproduct->delete(true);

            try {
                if (!$user) {
                    $user = Shop::Get()->getUserService()->getUser();
                }

                CommentsAPI::Get()->addComment(
                'shop-history-order-'.$order->getId(),
                'Удален заказ #'.$order->getId(),
                $user->getId()
                );
            } catch (Exception $e) {

            }

            // удаление подзадач - не нужно, так как ставится пометка deleted=1

            // удаляем заказ
            $order->setDeleted(1);
            $order->update();

            // событие
            $event = Events::Get()->generateEvent('shopOrderDeleteAfter');
            $event->setOrder($order);
            $event->notify();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Удаление бизнес процесса
     * @param ShopOrderCategory $orderCategory
     * @throws Exception
     */
    public function deleteOrderCategory(ShopOrderCategory $orderCategory) {
        try {
            SQLObject::TransactionStart();

            // чистка статусов
            $statuses = $orderCategory->getStatuses();
            $statuses->delete(true);

            // чистка изменений статусов
            $changes = new XShopOrderStatusChange();
            $changes->setCategoryid($orderCategory->getId());
            $changes->delete(true);

            try {
                $user = Shop::Get()->getUserService()->getUser();

                CommentsAPI::Get()->addComment(
                'shop-history-ordercategory-'.$orderCategory->getId(),
                'Удален бизнес процесс #'.$orderCategory->getId(),
                $user->getId()
                );
            } catch (Exception $e) {

            }

            // удаляем процесс
            $orderCategory->delete();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Сменить статус заказу.
     * Последний параметр говорит "проверять ACL или нет"
     *
     * @param User $user
     * @param ShopOrder $order
     * @param int $statusID
     */
    public function updateOrderStatus(User $user, ShopOrder $order, $statusID) {
        PackageLoader::Get()->import('CommentsAPI');

        try {
            SQLObject::TransactionStart();

            $status = $this->getStatusByID($statusID);

            if ($statusID != $order->getStatusid()) {
                // получаем текущий статус с которого уходим
                try {
                    $statusCurrent = $order->getStatus();
                } catch (Exception $statusEx) {

                }

                // issue #63099 - проверка на выполнение подзадач
                if (isset($statusCurrent)) {
                    if ($statusCurrent->getOnlyissue()) {
                        $tmp = IssueService::Get()->getIssuesAll();
                        $tmp->setParentid($order->getId());
                        $tmp->setParentstatusid($statusCurrent->getId());
                        $tmp->setDateclosed('0000-00-00 00:00:00');
                        $tmp->setLimitCount(1);
                        if ($tmp->getNext()) {
                            throw new ServiceUtils_Exception('issue-stop');
                        }
                    }
                }

                // issue #63058 - на кого переключать
                if ($status->getJumpmanager()) {
                    // сначала определяем по сотрудникам
                    $employer = new XShopOrderEmployer();
                    $employer->setOrderid($order->getId());
                    $employer->setStatusid($status->getId());
                    $employer->select();
                    if ($employer->getManagerid()) {
                        $order->setManagerid($employer->getManagerid());
                    }

                    // иначе по workflow
                    try {
                        $workflowManagerID = $status->getWorkflow()->getManagerid();

                        if (!$order->getManagerid() && $workflowManagerID) {
                            $order->setManagerid($workflowManagerID);
                        }
                    } catch (Exception $workflowEx) {

                    }
                }

                $order->setStatusid($status->getId());

                // автоматически ставим менеджера, если менеджера нет
                if (!$order->getManagerid()) {
                    $order->setManagerid($user->getId());
                }

                // записываем статус в историю
                $change = new XShopOrderChange();
                $change->setCdate(date('Y-m-d H:i:s'));
                $change->setOrderid($order->getId());
                $change->setKey('statusid');
                $change->setValue($status->getId());
                $change->setUserid($user->getId());
                $change->insert();

                if ($status->getShipped()) {
                    $order->setDateshipped(date('Y-m-d H:i:s'));
                } else {
                    $order->setDateshipped('0000-00-00 00:00:00');
                }

                if ($status->getClosed()) {
                    $order->setDateclosed(date('Y-m-d H:i:s'));
                } else {
                    $order->setDateclosed('0000-00-00 00:00:00');
                }

                $order->update();

                $updated = true;

                // отправляем почтовое уведомление
                $this->_orderSendmail($order);

                // в историю заказа
                $comment = 'Статус обновлен на: '.$status->getName()."\n";

                // создаем подзадачи
                if (Shop_ModuleLoader::Get()->isImported('box')) {
                    IssueService::Get()->createSubIssues($user, $order, $status);
                }

                try {
                    // записываем комментарий
                    $this->addOrderComment(
                    $order,
                    $user,
                    $comment
                    );
                } catch (Exception $userEx) {

                }

                // генерируем событие
                $event = Events::Get()->generateEvent('shopOrderStatusUpdateAfter');
                $event->setOrder($order);
                $event->notify();
            }

            SQLObject::TransactionCommit();

            if (!empty($updated)) {
                // выгрузка в XML
                $this->_orderXML($order);
                $this->_orderCSV($order);
            }

        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Сменить сопсоб оплаты в заказе
     *
     * @param ShopOrder $order
     * @param int $paymentID
     */
    public function updateOrderPayment(ShopOrder $order, $paymentID) {
        try {
            SQLObject::TransactionStart();

            if (!$paymentID) {
                $order->setPaymentid(0);
            } else {
                Shop::Get()->getShopService()->getPaymentByID($paymentID);
                $order->setPaymentid($paymentID);
            }

            $order->update();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }


    /**
     * @param ShopOrder $order
     * @param unknown_type $tpl
     * @return MailUtils_SmartySender
     */
    protected function _orderSendmailLetter(ShopOrder $order, $tpl) {
        $letter = MailUtils_SmartySender::CreateFromTemplateData($tpl);
        $letter->setEmailFrom(Shop::Get()->getSettingsService()->getSettingValue('reverse-email'));

        // получаем валюту заказа
        $currencyDefault = $order->getCurrency();

        // оплачен ли заказ?
        $canDownload = $order->getStatus()->getDownloadable();

        /**
         * Важно:
         * Фактически, заказ может быть оформлен в гривне,
         * но внутри заказ могут быть строки в разных валютах.
         * В таком случае уведомления нужно высылать в валюте заказа, то есть
         * все конвертируем в гривны.
         */

        $a = array();
        $orderproducts = $order->getOrderProducts();
        while ($op = $orderproducts->getNext()) {

            if ($op->getProductid()) {
                $url = false;
                if ($canDownload) {
                    try {
                        $url = $this->makeProductDownloadURL($op->getProduct());
                        $url = Engine::Get()->getProjectURL().'/'.$url;
                    } catch (Exception $e) {

                    }
                }

                try {
                    $code = $op->getProduct()->makeCode();
                } catch (Exception $e) {
                    $code = $op->getProductid();
                }

                $a[] = array(
                'name' => $op->getProductname(),
                'count' => $op->getProductcount(),
                'price' => $op->makePrice($currencyDefault),
                'productid' => $code,
                'sum' => $op->makeSum($currencyDefault),
                'url' => $url,
                'comment' => $op->getComment(),
                );
            }

        }

        $letter->assign('comments', nl2br(htmlspecialchars($order->getComments())));
        $letter->assign('trackurl', Engine::Get()->getProjectURL().'/order/'.$order->getHash().'/');
        $letter->assign('urledit',Engine::Get()->getProjectURL().$order->makeURLEdit());
        $letter->assign('signature', Shop::Get()->getSettingsService()->getSettingValue('letter-signature'));
        // накладная доставки
        if ($order->getManagerid()) {
            try {
                $manager = $order->getManager();
                $letter->assign('managername', htmlspecialchars($manager->getName()));
                $letter->assign('manageremail', htmlspecialchars($manager->getEmail()));
            } catch (Exception $e) {

            }
        }

        $letter->assign('status', htmlspecialchars($order->getStatus()->getName()));
        $letter->assign('date', DateTime_Formatter::DateTimeRussianGOST($order->getCdate()));
        $letter->assign('projecturl', Engine::Get()->getProjectURL());
        $letter->assign('orderid', $order->getId());
        $letter->assign('shopname', Shop::Get()->getSettingsService()->getSettingValue('shop-name'));

        // сумма и валюта заказа
        $letter->assign('ordersum', $order->getSum()); // c учетом доставки
        $letter->assign('ordercurrency', $currencyDefault->getSymbol());

        return $letter;
    }

    /**
     * Отправить сообщение на email о заказе
     * (о изменении его статуса)
     *
     * @param ShopOrder $order
     */
    protected function _orderSendmail(ShopOrder $order) {
        // отправка обычная (только клиенту)
        $tpl = $order->getStatus()->getMessage();
        if ($tpl && $order->getClientemail()) {
            $letter = $this->_orderSendmailLetter($order, $tpl);

            $letter->addEmail($order->getClientemail());
            $letter->send();
        }

        // отправка менеджеру и администраторам
        $tpl = $order->getStatus()->getMessageadmin();
        if ($tpl) {
            $letter = $this->_orderSendmailLetter($order, $tpl);

            // получаем все емейлы на которые нужно отправить заказ
            $emailToArray = $this->_getNotificationEmailArray();
            foreach ($emailToArray as $e) {
                $letter->addEmail($e);
            }

            $letter->send();
        }
    }

    /**
     * Отправка уведомления о новом комментарии к заказу
     *
     * @param ShopOrder $order
     * @param User $user
     * @param string $comment
     * @param array $notifyUserArray
     */
    public function orderEmailNotification(ShopOrder $order, $user, $comment, $notifyUserArray = false) {
        // формируем список всех, кому нужно это уведомление
        $emailArray = array();
        try {
            $manager = $order->getManager();
            if ($manager->getEmail() && $manager->getLevel() > 0) {
                $emailArray[] = $manager->getEmail();
            }
        } catch (Exception $e) {

        }

        // все менеджеры заказа
        $oes = new XShopOrderEmployer();
        $oes->setOrderid($order->getId());
        while ($oe = $oes->getNext()) {
            try {
                $tmp = Shop::Get()->getUserService()->getUserByID($oe->getManagerid());
                if (!$tmp->getLevel()) {
                    continue;
                }
                $emailArray[] = $tmp->getEmail();
            } catch (Exception $e) {

            }
        }

        // все остальные наблюдатели
        $users = Shop::Get()->getUserService()->getUsersManagers();
        $users->setLevel(2);
        while ($u = $users->getNext()) {
            if ($u->isAllowed('notify-order-category-'.$order->getCategoryid())) {
                $emailArray[] = $u->getEmail();
            }
        }

        // временные юзеры
        if (!$notifyUserArray) {
            $notifyUserArray = array();
        }
        foreach ($notifyUserArray as $u) {
            if (!$u->isManager()) {
                continue;
            }

            if (!$u->getEmail()) {
                continue;
            }

            if (!$u->getLevel()) {
                continue;
            }

            $emailArray[] = $u->getEmail();
        }

        // исключение своего емейла
        if ($user) {
            if ($user->getEmail()) {
                foreach ($emailArray as $key => $value) {
                    if ($value == $user->getEmail()) {
                        unset($emailArray[$key]);
                    }
                }
            }
        }

        // исключение дубликатов
        $emailArray = array_unique($emailArray);

        if (!$emailArray) {
            return;
        }

        $host = Engine::Get()->getProjectURL();

        // форматирование комментария для письма
        $comment = $this->_formatCommentForEmail($comment);

        // письмо в текстовом формате
        $text = '';
        if ($user) {
            $text .= $user->makeName(false, 'lfm').":\n";
        } else {
            $text .= "OneBox:\n";
        }

        $text .= $comment;
        $text .= "\n\n";
        $text .= '----------------------------------------'."\n";
        $text .= $order->makeName()."\n";
        $text .= $host.$order->makeURLEdit()."\n";
        $text .= "\n";
        try {
            $text .= 'Клиент: '.$order->getUser()->makeName(false)."\n";
        } catch (Exception $managerEx) {

        }
        try {
            $text .= 'Менеджер: '.$order->getManager()->makeName(false)."\n";
        } catch (Exception $e) {

        }
        $text .= "Сумма: ".$order->getSum().' '.$order->getCurrency()->getName()."\n";
        try {
            $parent = $order->getParent();
            if ($parent->getParentid() == 0) {
                $text .= 'Проект: '.$parent->makeName()."\n";
            }
        } catch (Exception $e) {

        }
        try {
            $text .= "Бизнес-процесс: ".$order->getCategory()->getName()."\n";
        } catch (Exception $e) {

        }
        try {
            $text .= "Этап: ".$order->getStatus()->getName()."\n";
        } catch (Exception $e) {

        }
        try {
            $text .= "Источник: ".$order->getSource()->getName()."\n";
        } catch (Exception $e) {

        }
        if ($order->getComments()) {
            $text .= "Комментарий:\n".$order->getComments()."\n";
        }

        $subject = '';
        try {
            $subject .= Engine::Get()->getConfigField('project-branding').' ';
        } catch (Exception $nameEx) {

        }
        $subject .= '#'.$order->getId().' '.$order->getNumber(true).' '.$order->getName();
        $subject = str_replace('  ', ' ', $subject);
        $subject = trim($subject);

        $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('box-parser-email');
        if (!$emailFrom) {
            $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('reverse-email');
        }
        foreach ($emailArray as $emailTo) {
            $letter = new MailUtils_Letter($emailFrom, $emailTo, $subject, $text);
            $letter->send();
        }
    }

    /**
     * @param ShopOrder $order
     * @param $tpl
     * @return mixed
     */
    protected function _getMessageByTpl(ShopOrder $order, $tpl ) {
        $tpl = str_replace('[orderid]', $order->getId(), $tpl);

        // получаем валюту заказа
        $currencyDefault = $order->getCurrency();

        if ($order->getManagerid()) {
            try {
                $manager = $order->getManager();

                $tpl = str_replace('[manageremail]', $manager->getEmail(), $tpl);
            } catch (Exception $e) {

            }
        }

        // статус и дата заказа
        $tpl = str_replace('[status]', $order->getStatus()->getName(), $tpl);
        $tpl = str_replace('[date]', DateTime_Formatter::DateTimeRussianGOST($order->getCdate()), $tpl);

        // сумма и валюта заказа
        $tpl = str_replace('[ordersum]', $order->getSum(), $tpl);
        $tpl = str_replace('[ordercurrency]', $currencyDefault->getSymbol(), $tpl);

        return $tpl;
    }

    /**
     * @return ShopOrder
     */
    public function getOrdersAll($user = false) {
        $orders = new ShopOrder();

        $orders->setDeleted(0);
        $orders->setOrder('id', 'DESC');

        if ($user) {
            // накладываем ACL
            if ($user->getLevel() >= 3) {
                return $orders;
            }

            if ($user->isAllowed('orders-all-view')) {
                return $orders;
            }

            $userID = $user->getId();

            $whereArray = array();

            $direction = array(-1);
            if ($user->isAllowed('orders-direction-in')) {
                $direction[] = 0;
            }
            if ($user->isAllowed('orders-direction-out')) {
                $direction[] = 1;
            }
            $whereArray[] ='(issue=1 OR outcoming IN ('.implode(',', $direction).'))';

            // фильтр по менеджеру заказа
            if ($user->isDenied('orders-manager-all-view')) {
                $managers = Shop::Get()->getUserService()->getUsersManagers();
                $managerIDArray = array($userID); // свои заказы видно всегда
                while ($m = $managers->getNext()) {
                    if ($user->isAllowed('orders-manager-'.$m->getId().'-view')) {
                        $managerIDArray[] = $m->getId();
                    }
                }
                $whereArray[] = "(userid IN (".implode(',', $managerIDArray).") OR managerid IN (".implode(',', $managerIDArray).") OR authorid IN (".implode(',', $managerIDArray).") OR EXISTS(SELECT * FROM shoporderemployer WHERE orderid=shoporder.id AND managerid IN (".implode(',', $managerIDArray).")))";
            }

            // фильтр по статусу
            if ($user->isDenied('orders-status-all-view')) {
                $status = Shop::Get()->getShopService()->getStatusAll();
                $statusIDs = array(-1);
                while ($s = $status->getNext()) {
                    if ($user->isAllowed('orders-status-'.$s->getId().'-view')) {
                        $statusIDs[] = $s->getId();
                    }
                }
                $whereArray[] = '(`statusid` IN ('.implode(', ', $statusIDs).'))';
            }

            // фильтр по категории (бизнес-процессу)
            if ($user->isDenied('orders-category-all-view')) {
                $categoryIDArray = array(-1);
                if ($user->isAllowed('orders-category-0-view')) {
                    $categoryIDArray[] = 0;
                }
                $categories = Shop::Get()->getShopService()->getOrderCategoryAll();
                while ($c = $categories->getNext()) {
                    if ($user->isAllowed('orders-category-'.$c->getId().'-view')) {
                        $categoryIDArray[] = $c->getId();
                    }
                }
                $whereArray[] = '(`categoryid` IN ('.implode(', ', $categoryIDArray).'))';
            }

            if ($whereArray) {
                $orders->addWhereQuery("(userid={$user->getId()} OR authorid={$user->getId()} OR managerid={$user->getId()} OR (".implode(' AND ', $whereArray)."))");
            }
        }

        return $orders;
    }

    /**
     * @return ShopOrder
     */
    public function getOrderByID($id) {
        try {
            return $this->getObjectByID($id, 'ShopOrder');
        } catch (Exception $e) {}
        throw new ServiceUtils_Exception('Shop-object by id not found');
    }

    /**
     * Получить заказ по его md5-хешу
     *
     * @return ShopOrder
     */
    public function getOrderByHash($hash) {
        $order = new ShopOrder();
        $order->setHash($hash);
        if ($order->select()) {
            return $order;
        } else {
            throw new ServiceUtils_Exception();
        }
    }

    /**
     * Получить товары в заказе
     *
     * @return ShopOrderProduct
     * @param ShopOrder $order
     */
    public function getOrderProducts(ShopOrder $order) {
        $x = new ShopOrderProduct();
        $x->setOrderid($order->getId());
        return $x;
    }

    /**
     * @return ShopOrderProduct
     * @param int $id
     */
    public function getOrderProductById($id) {
        try {
            return $this->getObjectByID($id, 'ShopOrderProduct');
        } catch (Exception $e) {}
        throw new ServiceUtils_Exception('Shop-object by id not found');
    }

    /**
     * @return ShopOrderProduct
     */
    public function getOrderProductsAll() {
        return $this->getObjectsAll('ShopOrderProduct');
    }

    /**
     * @param ShopOrder $order
     * @return ShopOrderEmployer
     */
    public function getEmployersByOrder(ShopOrder $order) {
        $x = new ShopOrderEmployer();
        $x->setOrderid($order->getId());
        return $x;
    }

    /**
     * @param ShopOrder $order
     * @param User $user
     * @return bool
     */
    public function isEmployer(ShopOrder $order, User $user) {
        $x = new ShopOrderEmployer();
        $x->setOrderid($order->getId());
        $x->setManagerid($user->getId());
        if ($x->select()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param ShopOrder $order
     * @param User $user
     * @return ShopOrderEmployer
     */
    public function addOrderEmployer(ShopOrder $order, User $user) {
        try {
            SQLObject::TransactionStart();

            $x = new ShopOrderEmployer();
            $x->setOrderid($order->getId());
            $x->setManagerid($user->getId());
            if (!$x->select()) {
                $x->insert();
            }

            SQLObject::TransactionCommit();

            return $x;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * @param ShopOrder $order
     * @param User $user
     */
    public function deleteOrderEmployer(ShopOrder $order, User $user) {
        try {
            SQLObject::TransactionStart();

            $x = new ShopOrderEmployer();
            $x->setOrderid($order->getId());
            $x->setManagerid($user->getId());
            $x->delete(true);

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Обновисть товар
     *
     * @param ShopProduct $product
     * @param $name
     * @param $description
     * @param $categoryID
     * @param $brandID
     * @param $model
     * @param $price
     * @param $priceold
     * @param $currencyID
     * @param $unit
     * @param $barcode
     * @param $discount
     * @param $warranty
     * @param $hidden
     * @param $deleted
     * @param $avail
     * @param $availText
     * @param $syncable
     * @param $url
     * @param $image
     * @param $deleteImage
     * @param $collectionID
     * @param $width
     * @param $height
     * @param $length
     * @param $weight
     * @param $unitbox
     * @param $delivery
     * @param $payment
     * @param $divisibility
     * @param $userID
     * @param $denycomments
     * @param $siteURL
     * @param $taxID
     * @param $descriptionshort
     * @param $name1
     * @param $name2
     * @param $code1c
     * @param $codesupplier
     * @param $characteristics
     * @param $share
     * @param $seotitle
     * @param $seodescription
     * @param $seocontent
     * @param $seokeywords
     * @param bool $icon
     * @param bool $downloadFile
     * @param bool $deleteDownloadFile
     * @throws Exception
     */
    public function updateProduct(ShopProduct $product, $name, $description, $categoryID, $brandID, $model,$price, $priceold,$currencyID, $unit, $barcode, $discount,$preorderDiscount, $warranty, $hidden, $deleted, $avail, $availText, $syncable, $url, $image, $deleteImage, $collectionID, $width, $height, $length, $weight, $unitbox, $delivery, $payment, $divisibility, $userID, $denycomments, $siteURL, $taxID, $descriptionshort, $name1, $name2, $code1c, $codesupplier, $characteristics, $share, $seotitle, $seodescription, $seocontent, $seokeywords, $icon = false, $downloadFile = false, $deleteDownloadFile = false, $datelifefrom = false, $datelifeto = false, $articul = false  ) {
        try {
            SQLObject::TransactionStart();

            $event = Events::Get()->generateEvent('shopProductEditBefore');
            $event->setProduct($product);
            $event->notify();

            $name = trim($name);
            $name1 = trim($name1);
            $name2 = trim($name2);
            $price = trim($price);
            $icon = trim($icon);
            $oldprice = trim($priceold);
            $price = str_replace(',', '.', $price);
            $priceold = str_replace(',', '.', $priceold);
            $description = trim($description);
            $url = trim($url);
            $url = strtolower($url);
            $model = trim($model);
            $articul = trim($articul);
            $unit = trim($unit);
            $barcode = trim($barcode);
            $warranty = trim($warranty);
            $descriptionshort = trim($descriptionshort);
            $availText = trim($availText);
            $divisibility = str_replace(',', '.', $divisibility);
            $divisibility = (float) $divisibility;
            $width = trim($width);
            $height = trim($height);
            $length = trim($length);
            $weight = trim($weight);
            $seocontent = trim($seocontent);

            if ($datelifefrom) {
                $datelifefrom = DateTime_Corrector::CorrectDate($datelifefrom);
                if ($datelifefrom == '1970-01-01'){
                    $datelifefrom = '0000-00-00';
                }
            }

            if ($datelifeto) {
                $datelifeto = DateTime_Corrector::CorrectDate($datelifeto);
                if ($datelifeto == '1970-01-01'){
                    $datelifeto = '0000-00-00';
                }
            }


            // только если старая цена больше новой
            // приведение к типу для сравнения
            $priceold_float = (float)$priceold;
            $price_float = (float)$price;
            if ($priceold_float < $price_float) {
                $priceold = 0;
            }

            $ex = new ServiceUtils_Exception();
            if (!$name) {
                $ex->addError('name');
            }

            //url
           $url = preg_replace('/([\-]{2,})/ius', '-', $url);
            if($product->getUrl() && !Checker::CheckURL($url)) {
                $ex->addError('url');
            }
            if (!$url) {
                $url = Shop::Get()->getShopService()->buildURL($name);
            }


            $category = false;
            if ($categoryID) {
                try {
                    $category = $this->getCategoryByID($categoryID);
                } catch (Exception $e) {
                    $ex->addError('category');
                }
            }

            if ($image) {
                if (!Checker::CheckImageFormat($image)) {
                    $ex->addError('image');
                }
            }

            $currency = Shop::Get()->getCurrencyService()->getCurrencyByID($currencyID);

            $taxRate = 0;
            if ($taxID) {
                try{
                    $tax = Shop::Get()->getShopService()->getTaxByID($taxID);
                    $taxRate = $tax->getRate();
                } catch (Exception $e) {

                }

            }

            if ($userID) {
                try {
                    $user = Shop::Get()->getUserService()->getUserByID($userID);
                } catch (Exception $userEx) {
                    $ex->addError('user');
                }
            }

            if ($ex->getCount()) {
                throw $ex;
            }

            // что поменялось
            $diffArray = array();
            if ($product->getName() != $name) {
                $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_changed_the_name_of_the_product_with').$product->getName().Shop::Get()->getTranslateService()->getTranslate('translate_on').$name.'"';
            }
            $product->setName($name);

            if ($product->getName1() != $name1) {
                $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_SEO_has_changed_the_name_of_1').$product->getName1().Shop::Get()->getTranslateService()->getTranslate('translate_on').$name1.'"';
            }
            $product->setName1($name1);

            if ($product->getName2() != $name2) {
                $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_SEO_has_changed_the_name_of_2').$product->getName2().Shop::Get()->getTranslateService()->getTranslate('translate_on').$name2.'"';
            }
            $product->setName2($name2);

            if ($product->getDescription() != $description) {
                $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_changed_the_description_of_the_goods_from_the').$product->getDescription().Shop::Get()->getTranslateService()->getTranslate('translate_on').$description.'"';
            }
            $product->setDescription($description);

            if ($product->getSeotitle() != $seotitle) {
                $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_SEO_has_changed_the_title_to_the_goods').$product->getSeotitle().Shop::Get()->getTranslateService()->getTranslate('translate_on').$seotitle.'"';
            }
            $product->setSeotitle($seotitle);

            if ($product->getSeodescription() != $seodescription) {
                $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_SEO_has_changed_the_description_of_the_goods_from_the').$product->getSeodescription().Shop::Get()->getTranslateService()->getTranslate('translate_on').$seodescription.'"';
            }
            $product->setSeodescription($seodescription);

            $seocontentbuf = strip_tags($seocontent);

            if ( $product->getSeocontent() != $seocontent) {
                $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_SEO_has_changed_the_text_of_the_goods_from_the').$product->getSeocontent().Shop::Get()->getTranslateService()->getTranslate('translate_on').$seocontent.'"';
            }


            if ( empty($seocontent) || !empty($seocontentbuf) ) {
                $product->setSeocontent($seocontent);
            }


            if ($product->getSeokeywords() != $seokeywords) {
                $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_changed_SEO_keywords_goods_from').$product->getSeokeywords().Shop::Get()->getTranslateService()->getTranslate('translate_on').$seokeywords.'"';
            }
            $product->setSeokeywords($seokeywords);

            if ($product->getCharacteristics() != $characteristics) {
                $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_changed_the_characteristics_of_the_product_with').$product->getCharacteristics().Shop::Get()->getTranslateService()->getTranslate('translate_on').$characteristics.'"';
            }
            $product->setCharacteristics($characteristics);

            if ($product->getPayment() != $payment) {
                $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_changed_the_terms_of_payment_for_the_goods_from_the').$product->getPayment().Shop::Get()->getTranslateService()->getTranslate('translate_on').$payment.'"';
            }
            $product->setPayment($payment);

            if ($product->getPrice() != round($price, 2)) {
                $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_changed_the_price_of_the_goods_to').$product->getPrice().Shop::Get()->getTranslateService()->getTranslate('translate_on').$price.'"';
            }
            $product->setPrice($price);

            if ($product->getPriceold() != round($priceold, 2)) {
                $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_changed_the_price_of_the_item_with_a_strikeout').$product->getPriceold().Shop::Get()->getTranslateService()->getTranslate('translate_on').$priceold.'"';
            }
            $product->setPriceold($priceold);



            if ((int) $product->getCurrencyid() != (int) $currencyID) {
                $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_change_currency_goods_on').$currency->getName().'"';
            }
            $product->setCurrencyid($currency->getId());


            if ($unit) {
                $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_set_the_unit_of_measure_of_goods').$unit;
            } else {
                $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_removed_the_unit_of_measure_of_goods');
            }

            $product->setUnit($unit);

            if ($product->getDivisibility() != $divisibility) {
                $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_changed_crushability_goods_from').$product->getDivisibility().Shop::Get()->getTranslateService()->getTranslate('translate_on').$divisibility.'"';
            }
            $product->setDivisibility($divisibility);

            if ($product->getBarcode() != $barcode) {
                if ($barcode) {
                    $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_set_the_bar_code').$barcode;
                } else {
                    $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_removed_barcode');
                }
            }
            $product->setBarcode($barcode);

            if ($product->getWarranty() != $warranty) {
                if ($warranty) {
                    $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_established_a_guarantee').$warranty;
                } else {
                    $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_removed_guarantee');
                }
            }
            $product->setWarranty($warranty);

            if ($product->getUrl() != $url) {
                if ($url) {
                    $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_set_the_URL_prefix').$url;
                }
                if (!Shop::Get()->getShopService()->checkURLUnique($url)) {
                    $url .= '-'.$product->getId();
                }

                // При смене URL автоматически добавлять его в redirect
                if ($product->getUrl() && $url && ($product->getUrl() !== $url)) {
                    $redirect = new XShopRedirect();
                    $redirect->setUrlfrom('/'.$product->getUrl());
                    if (!$redirect->select()) {
                        $redirect->setUrlto('/'.$url);
                        $redirect->setCode(301);
                        $redirect->insert();
                    }
                }
            }
            if ($url) {
                $product->setUrl($url);
            }

            if ((bool) $product->getHidden() != (bool) $hidden) {
                if ($hidden) {
                    $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_concealed_items');
                } else {
                    $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_restored_the_product_of_the_hidden');
                }
            }
            $product->setHidden($hidden);

            if ((bool) $product->getDenycomments() != (bool) $denycomments) {
                if ($denycomments) {
                    $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_it_is_forbidden_to_comment_on_goods');
                } else {
                    $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_resumed_commenting_goods');
                }
            }
            $product->setDenycomments($denycomments);

            if ((bool) $product->getDeleted() != (bool) $deleted) {
                if ($deleted) {
                    $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_delete_article');
                } else {
                    $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_restored_items_from_remote');
                }
            }
            $product->setDeleted($deleted);

            $product->setSync($syncable);
            $product->setUnsyncable(!$syncable);
            $product->setAvail($avail);
            $product->setAvailtext($availText);

            if ($product->getDescriptionshort() != $descriptionshort) {
                $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_changed_with_a_brief_explanation').$product->getDescriptionshort().Shop::Get()->getTranslateService()->getTranslate('translate_on').$descriptionshort.'"';
            }
            $product->setDescriptionshort($descriptionshort);

            if ((int) $product->getCategoryid() != (int) $categoryID) {
                if ($categoryID) {
                    $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_established_product_category').$categoryID.' '.$category->getName();
                } else {
                    $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_removed_product_category');
                }
            }
            $product->setCategoryid($categoryID);

            $this->buildProductCategories($product);

            if ($product->getModel() != $model) {
                if ($model) {
                    $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_established_a_product_model').$model;
                } else {
                    $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_removed_product_model');
                }
            }
            $product->setModel($model);

            if ($product->getArticul() != $articul) {
                if ($articul) {
                    $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_established_a_product_articul').$articul;
                } else {
                    $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_removed_product_articul');
                }
            }
            $product->setArticul($articul);

            if ($deleteImage) {
                $product->setImage('');
                $product->setImagecrop('');

                $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_remove_the_primary_product_image');
            } elseif ($image) {
                // конвертация изображения в необходимый формат
                // и допустимый размер
                $image = Shop::Get()->getShopService()->convertImage($image);

                $file = $this->makeImagesUploadUrl(
                $image,
                '/shop/',
                false,
                'product-'.$name
                );
                copy($image, MEDIA_PATH.'shop/'.$file);
                $product->setImage($file);

                $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_installed_on_the_product_image').$file;
            }

            if ($deleteDownloadFile) {
                $product->setFiledownload('');

                $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_removed_downloadable_file_product');
            } elseif ($downloadFile) {
                $hash = md5_file($downloadFile);

                copy($downloadFile, MEDIA_PATH.'/downloadfile/'.$hash);
                $product->setFiledownload($hash);

                $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_established_a_downloadable_file_product').$hash;
            }

            if ((int) $product->getTaxrate() != (int) $taxRate) {
                $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_changed_the_product_with_VAT').$product->getTaxrate().Shop::Get()->getTranslateService()->getTranslate('translate_on').$taxRate.'"';
            }
            $product->setTaxrate($taxRate);


            if ($product->getWidth() != $width) {
                $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_change_the_width_of_the_goods_from_the').$product->getWidth().Shop::Get()->getTranslateService()->getTranslate('translate_on').$width.'"';
            }
            $product->setWidth($width);

            if ($product->getHeight() != $height) {
                $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_changed_the_height_of_the_product_with').$product->getHeight().Shop::Get()->getTranslateService()->getTranslate('translate_on').$height.'"';
            }
            $product->setHeight($height);

            if ($product->getLength() !=  $length) {
                $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_changed_the_length_of_the_product_with').$product->getLength().Shop::Get()->getTranslateService()->getTranslate('translate_on').$length.'"';
            }
            $product->setLength($length);

            if ($product->getWeight() != $weight) {
                $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_changed_the_weight_of_the_goods_to_the').$product->getWeight().Shop::Get()->getTranslateService()->getTranslate('translate_on').$weight.'"';
            }
            $product->setWeight($weight);

            if ((int) $product->getUnitbox() != (int) $unitbox) {
                $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_changed_the_number_in_the_box_with_the_product').$product->getUnitbox().Shop::Get()->getTranslateService()->getTranslate('translate_on').$unitbox.'"';
            }
            $product->setUnitbox($unitbox);

            if ($product->getSiteurl() != $siteURL) {
                $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_the_reference_to_the_manufacturer_website').$product->getSiteurl().Shop::Get()->getTranslateService()->getTranslate('translate_on').$siteURL.'"';
            }
            $product->setSiteurl($siteURL);

            if ($product->getShare() != $share) {
                $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_changed_the_action_with').$product->getShare().Shop::Get()->getTranslateService()->getTranslate('translate_on').$share.'"';
            }
            $product->setShare($share);

            if ($product->getDatelifefrom() != $datelifefrom) {
                $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_changed_datelifefrom').$product->getDatelifefrom().Shop::Get()->getTranslateService()->getTranslate('translate_on').$datelifefrom.'"';
            }
            $product->setDatelifefrom($datelifefrom);

            if ($product->getDatelifeto() != $datelifeto) {
                $diffArray[] = Shop::Get()->getTranslateService()->getTranslate('translate_changed_datelifeto').$product->getDatelifeto().Shop::Get()->getTranslateService()->getTranslate('translate_on').$datelifeto.'"';
            }
            $product->setDatelifeto($datelifeto);

            // автор/поставщик товара
            $product->setUserid($userID);

            $product->update();

            if ($categoryID){
                $this->updateCategoryProductCount($categoryID);
            }

            if ($diffArray) {
                try {
                    $user = Shop::Get()->getUserService()->getUser();

                    CommentsAPI::Get()->addComment(
                    'shop-history-product-'.$product->getId(),
                    Shop::Get()->getTranslateService()->getTranslate('translate_product')." #{$product->getId()} \"{$product->getName()}\"\n".implode("\n", $diffArray),
                    $user->getId()
                    );
                } catch (Exception $e) {

                }
            }

            $event = Events::Get()->generateEvent('shopProductEditAfter');
            $event->setProduct($product);
            $event->notify();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    public function updateProductImageCrop (ShopProduct $product, $image) {
        if ($image) {
            // конвертация изображения в необходимый формат
            // и допустимый размер
            $image = Shop::Get()->getShopService()->convertImage($image);

            $file = $this->makeImagesUploadUrl(
            $image,
            '/shop/',
            false,
            'product-'.$product->getName().'-cropper-'
            );
            copy($image, MEDIA_PATH.'shop/'.$file);
            $product->setImagecrop($file);
            $product->update();
        }
    }

    /**
     * Обновить аватар/логотип контакта
     *
     * @param User $user
     * @param string $image
     */
    public function updateUserAvatarImage(User $user, $image) {
        if (!$image) {
            throw new ServiceUtils_Exception('image');
        }

        if (!Checker::CheckImageFormat($image)) {
            throw new ServiceUtils_Exception('image');
        }

        // конвертация изображения в необходимый формат
        // и допустимый размер
        $image = Shop::Get()->getShopService()->convertImage($image);

        $file = $this->makeImagesUploadUrl(
        $image,
        '/shop/'
        );

        copy($image, MEDIA_PATH.'shop/'.$file);

        $user->setImage($file);
        $user->update();
    }

    /**
     * Обновить основную картинку товару.
     * Вместо пути можно указывать прямой URL на картинку.
     *
     * Метод актуален для парсеров.
     *
     * @param ShopProduct $product
     * @param string $image
     */
    public function updateProductImage(ShopProduct $product, $image) {
        if (!$image) {
            throw new ServiceUtils_Exception('Empty image');
        }

        $file = $this->makeImagesUploadUrl(
        $image,
        '/shop/',
        false,
        'product-'.$product->getName()
        );
        copy($image, MEDIA_PATH.'shop/'.$file);

        if (file_exists(MEDIA_PATH.'shop/'.$file)) {
            $product->setImage($file);
            $product->update();
        }
    }

    /**
     * Обновить или добавить изображения товара массово.
     *
     * @param ShopProduct $product
     * @param array $imageArray
     * @param bool $deleteOldImages
     */
    public function updateProductImageArray(ShopProduct $product, $imageArray, $deleteOldImages = false) {
        // удаляем старые картинки
        if ($deleteOldImages) {
            try {
                SQLObject::TransactionStart();

                $images = $product->getImages();
                $image->delete(true);

                $product->setImage('');
                $product->update();

                SQLObject::TransactionCommit();
            } catch (Exception $imageEx) {
                SQLObject::TransactionRollback();
            }
        }

        $index = 0;
        foreach ($imageArray as $image) {
            try {
                if ($index == 0) {
                    $this->updateProductImage($product, $image);
                } else {
                    $this->addProductImage($product, $image);
                }

                $index ++;
            } catch (Exception $imageEx) {

            }
        }
    }

    /**
     * Скрыть или открыть всю категорию с товарами (рекурсивно)
     *
     * @param ShopCategory $category
     * @param bool $hidden
     */
    public function updateCategoryHidden(ShopCategory $category, $hidden) {
        try {
            SQLObject::TransactionStart();

            $this->_updateCategoryHidden($category, $hidden);

            $products = $category->getProducts();
            while ($x = $products->getNext()) {
                $x->setHidden($hidden);
                $x->update();
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    protected function _updateCategoryHidden(ShopCategory $category, $hidden) {
        $category->setHiddenold($category->getHidden());
        $category->setHidden($hidden);
        $category->update();

        // идем по всем под-категориям
        $subCategories = $category->getChilds();
        while ($x = $subCategories->getNext()) {
            $this->updateCategoryHidden($x, $hidden);
        }
    }


    /**
     * Создания адреса для записи картинки
     * создаётся 3 папки которые вложены друг в друга
     * Имена папок определяется по md5-hash файла
     *
     * @param $image
     * @param string $folder
     * @param string $fileformat
     * @return string
     */
    public function makeImagesUploadUrl($image, $folder = 'shop/', $fileformat = false, $namePrefix = false) {
        if ($fileformat === false) {
            $sizeArray = @getimagesize($image);
            if ($sizeArray['mime'] == 'image/png') {
                $fileformat = 'png';
            } else {
                $fileformat = 'jpg';
            }
        }

        if ($namePrefix) {
            // превращаем префикс в латинские символы
            // убираем все левое
            $namePrefix = StringUtils_Transliterate::TransliterateRuToEn($namePrefix);
            $namePrefix = preg_replace("/([^0-9a-z\.\-\_])/is", '-', $namePrefix);
            $namePrefix = preg_replace('/([\-]{2,})/ius', '-', $namePrefix);
        }

        $url = MEDIA_PATH.$folder;

        $imagemd5 = md5_file($image);
        $folder1 = substr($imagemd5, 0, 2);
        $folder2 = substr($imagemd5, 2, 2);

        @mkdir($url.$folder1);
        @mkdir($url.$folder1.'/'.$folder2);

        if ($namePrefix) {
            $imagemd5 = $folder1.'/'.$folder2.'/'.$namePrefix.'_'.$imagemd5.'.'.$fileformat;
        } else {
            $imagemd5 = $folder1.'/'.$folder2.'/'.$imagemd5.'.'.$fileformat;
        }

        return $imagemd5;
    }

    /**
     * Отконвертировать изображение в заданный формат хранения.
     * Уменьшить изображение до нужного размера.
     * Вернуть путь на файл.
     *
     * @param string $filepath
     * @return string
     */
    public function convertImage($filepath) {
        // получаем формат
        $format = Shop::Get()->getSettingsService()->getSettingValue('image-format');
        $format = strtolower($format);
        if ($format != 'png' && $format != 'jpg') {
            $format = 'jpg';
        }

        // получаем предельные размеры изображения
        $maxWidth = 1200;
        $maxHeight = 1200;

        // получаем текущий размер изображения
        $imageSize = @getimagesize($filepath);
        if (!$imageSize) {
            return $filepath;
        }
        $width = $imageSize[0];
        $height = $imageSize[1];

        // определяем, до какого размера уменьшать?
        if ($width > $maxWidth) {
            $width = $maxWidth;
        }
        if ($height > $maxHeight) {
            $height = $maxHeight;
        }

        // обработка изображения
        $ip = new ImageProcessor($filepath);
        $ip->addAction(new ImageProcessor_ActionResizeProportional($width, $height));
        if ($format == 'png') {
            $ip->addAction(new ImageProcessor_ActionToPNG($filepath));
        } else {
            $ip->addAction(new ImageProcessor_ActionToJPEG($filepath));
        }

        $ip->process();
        return $filepath;
    }


    /**
     * Создать новый скрытый товар
     *
     * @param string $name
     * @param int $id
     * @return ShopProduct
     */
    public function addProduct($name, $id = false) {
        try {
            SQLObject::TransactionStart();

            // заменяем спец-символы
            $name = str_replace(array("\n", "\r", "\t"), ' ', $name);
            // удаляем дубликаты пробелов
            $name = preg_replace('/(\s+)/ius', ' ', $name);
            $name = trim($name);
            if (!$name) {
                throw new ServiceUtils_Exception('name');
            }

            if ($id) {
                try {
                    $this->getProductByID($id);
                    $found = true;
                } catch (Exception $e) {
                    $found = false;
                }

                if ($found) {
                    throw new ServiceUtils_Exception('id');
                }
            }

            $product = new ShopProduct();
            $product->setName($name);
            $product->setHidden(1);
            $product->setCurrencyid(Shop::Get()->getCurrencyService()->getCurrencySystem()->getId());
            if ($id) {
                $product->setId($id);
            }
            $product->insert();

            try {
                $user = Shop::Get()->getUserService()->getUser();

                CommentsAPI::Get()->addComment(
                'shop-history-product-'.$product->getId(),
                Shop::Get()->getTranslateService()->getTranslate('translate_a_new_product').' #'.$product->getId().Shop::Get()->getTranslateService()->getTranslate('translate_named').$name.'". '.Shop::Get()->getTranslateService()->getTranslate('translate_product_hidden').'.',
                $user->getId()
                );
            } catch (Exception $e) {

            }

            $event = Events::Get()->generateEvent('shopProductAddAfter');
            $event->setProduct($product);
            $event->notify();

            SQLObject::TransactionCommit();

            return $product;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Удалить товар
     *
     * @param ShopProduct $product
     */
    public function deleteProduct(ShopProduct $product) {
        try {
            SQLObject::TransactionStart();

            // генерируем событие
            $event = Events::Get()->generateEvent('shopProductDeleteBefore');
            $event->setProduct($product);
            $event->notify();

            // чистка "товаров в списках"
            $list = new XShopProduct2List();
            $list->setProductid($product->getId());
            $list->delete(true);

            // удаляем картинки
            $images = $product->getImages();
            $images->delete(true);

            // чистка истории просмотров
            $history = new XShopProductView();
            $history->setProductid($product->getId());
            $history->delete(true);

            $categoryID = $product->getCategoryid();

            // удаляем товар
            $product->delete();

            if ($categoryID) {
                $this->updateCategoryProductCount($categoryID);
            }


            try {
                $user = Shop::Get()->getUserService()->getUser();

                CommentsAPI::Get()->addComment(
                'shop-history-product-'.$product->getId(),
                Shop::Get()->getTranslateService()->getTranslate('translate_deleted_items').' #'.$product->getId().' '.$product->getName(),
                $user->getId()
                );
            } catch (Exception $e) {

            }

            $event = Events::Get()->generateEvent('shopProductDeleteAfter');
            $event->setProduct($product);
            $event->notify();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Получить массив подзадач и их подзадач и тд
     *
     * @param ShopOrder $order
     * @return array
     */
    public function getOrderChilds(ShopOrder $order) {
        $a = array();
        $orderId = $order->getId();
        $orders = $this->getOrdersAll();
        $orders->setParentid($orderId);
        while ($x = $orders->getNext()) {
            $a[] = $x;

            $b = $this->getOrderChilds($x);
            if (count($b)) {
                $a = array_merge($a, $b);
            }

        }
        return $a;
    }

    /**
     * Пересчет рейтинга товаров
     */
    public function calculateProductRating() {
        $countArray = array();
        $countRatingArray = array();
        $ratingArray = array();
        $comments = $this->getProductCommentsAll();
        while ($x = $comments->getNext()) {
            @$countArray[$x->getProductid()] ++;
            if ($x->getRating() > 0) {
                @$countRatingArray[$x->getProductid()] ++;
                @$ratingArray[$x->getProductid()] += $x->getRating();
            }
        }

        foreach ($countArray as $productID => $count) {
            try {
                $product = $this->getProductByID($productID);

                if (!empty($countRatingArray[$productID])) {
                    $ratingCount = $countRatingArray[$productID];

                    // пишем рейтинг
                    $product->setRating($ratingArray[$productID] / $ratingCount);
                }

                // сюда пишем количество отзывов
                $product->setRatingcount($count);
                $product->update();
            } catch (Exception $productEx) {

            }
        }

        // для всех товаров у которых рейтинг 0, но их заказывали более 20 раз
        // ставим рейтинг автоматически
        $products = $this->getProductsAll();
        $products->setRatingcount(0);
        $products->addWhere('ordered', 20, '>=');
        while ($x = $products->getNext()) {
            if ($x->getOrdered() >= 20) {
                $x->setRating(5);
            } elseif ($x->getOrdered() >= 10) {
                $x->setRating(4);
            } else {
                $x->setRating(3);
            }
            $x->update();
        }
    }

    /**
     * Построить URL-префикс исходя из текста
     *
     * @param string $text
     * @return string
     */
    public function buildURL($text) {
        $text = trim($text);
        $text = StringUtils_Transliterate::TransliterateRuToEn($text);

        $text = preg_replace("/[^a-z0-9-_\s]/ius", '', $text);
        $text = preg_replace("/\s+/ius", '-', $text);

        $text = strtolower($text);

        if (!$text) {
            throw new ServiceUtils_Exception();
        }

        return $text;
    }

    /**
     * Проверка URL на уникальность.
     * false - если такой URL есть
     * true - если такого URL еще нет
     *
     * @param string $url
     * @return bool
     */
    public function checkURLUnique($url) {
        $url = trim($url);

        if (!$url) {
            return false;
        }

        $tmp = new XShopProduct();
        $tmp->setUrl($url);
        if ($tmp->select()) {
            return false;
        }

        $tmp = new XShopCategory();
        $tmp->setUrl($url);
        if ($tmp->select()) {
            return false;
        }

        $tmp = new XShopTextPage();
        $tmp->setUrl($url);
        if ($tmp->select()) {
            return false;
        }

        return true;
    }

    /**
     * Универсальный калькулятор стоимости.
     * Работает в одной валюте.
     *
     * Умеет учитывать и возвращать сумму и значения скидки, НДС.
     *
     * Метод внутри раскладывает сумму по правилам подсчета:
     * Снимает НДС, снимает скидки.
     *
     * @uses оформление заказа, печать документов, редактирование заказа
     *
     * @param float $sum
     * @param float $tax
     * @param float $discountPercent
     * @param float $discountSum
     * @param bool $resultSum
     * @param bool $resultTax
     * @param bool $resultDiscount
     * @return float
     */
    public function calculateSum($sum, $tax = false, $discountPercent = false, $discountSum = false, $resultSum = true, $resultTax = true, $resultDiscount = true) {
        $sum = round($sum, 2);

        // от суммы сразу отнимаем VAT tax
        if ($tax > 0) {
            $sum_result = round($sum / (1 + $tax / 100), 2);
            $sum_tax = round($sum - $sum_result, 2);
        } else {
            $sum_result = $sum;
            $sum_tax = 0;
        }



        $result = 0;
        if ($resultSum) {
            $result += $sum_result;
        }

        if ($resultTax) {
            $result += $sum_tax;
        }

        return round($result, 2);
    }

    /**
     * Посчитать сумму заказа с учетом всех подзадач
     *
     * @param ShopOrder $order
     * @return float
     */
    public function calculateOrderSum(ShopOrder $order) {
        $sum = $order->getSum();

        $childs = $this->getOrdersAll(false, true);
        $childs->setParentid($order->getId());
        while ($x = $childs->getNext()) {
            $tmp = $this->calculateOrderSum($x);

            $tmp = Shop::Get()->getCurrencyService()->convertCurrency(
            $tmp,
            $x->getCurrency(),
            $order->getCurrency()
            );

            $sum += $tmp;
        }

        return $sum;
    }



    /**
     * Отправить тикет-уведомление
     *
     * @param $name
     * @param $email
     * @param $message
     * @throws ServiceUtils_Exception
     */
    public function sendTicketSupport($name, $email, $message) {
        $ex = new ServiceUtils_Exception();

        if (!$name) {
            $ex->addError('name');
        }

        if (!$message) {
            $ex->addError('message');
        }

        if (!Checker::CheckEmail($email)) {
            $ex->addError('email');
        }

        if ($ex->getCount()) {
            throw $ex;
        }

        // отправка напрямую
        MailUtils_Config::Get()->setSender(new MailUtils_SenderMail());

        $tpl = MEDIA_PATH.'/mail-templates/shop-ticket-support.html';
        $sender = new MailUtils_SmartySender($tpl);
        $sender->setEmailFrom($email);
        $sender->addEmail('support@webproduction.ua');
        $sender->assign('name', $name);
        $sender->assign('message', nl2br($message));
        $sender->assign('email', $email);
        $sender->assign('host', Engine::Get()->getProjectURL());
        $sender->send();
    }


    /**
     * Создание адреса для записи файла
     * создаётся 4 папки которые вложены друг в друга
     * Имена папок определяются по md5-hash файла
     *
     * @param $image
     * @param string $folder
     * @param string $fileformat
     * @return string
     */
    public function makeFileUploadUrl($file, $folder = 'shop/') {
        $url = MEDIA_PATH.$folder;

        $imagemd5 = md5_file($file);
        $folder1 = substr($imagemd5, 0, 2);
        $folder2 = substr($imagemd5, 2, 2);

        @mkdir($url.$folder1);
        @mkdir($url.$folder1.'/'.$folder2);

        $imagemd5 = $folder1.'/'.$folder2.'/'.$imagemd5;

        return $imagemd5;
    }

    /**
     * Проверить такую категорию и добавить ее, если нет.
     * parentID может быть не обязательным.
     *
     * Метод актуален для парсеров.
     *
     * @param string $name
     * @param int $parentID
     */
    public function addCategory($name, $parentID = false) {
        $name = trim($name);
        if (!$name) {
            throw new ServiceUtils_Exception('name');
        }

        try {
            SQLObject::TransactionStart();

            $category = new ShopCategory();
            $category->setName($name);
            if ($parentID !== false) {
                $category->setParentid($parentID);
            }
            if (!$category->select()) {
                $category->insert();
            }

            SQLObject::TransactionCommit();

            return $category;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }


    /**
     * Поиск заказов
     *
     * @return ShopOrder
     * @param string $query
     */
    public function searchOrders($query, $cuser = false) {
        $query = trim($query);
        if (strlen($query) < 3) {
            throw new ServiceUtils_Exception();
        }

        $orders = $this->getOrdersAll($cuser, true);
        $connection = $orders->getConnectionDatabase();

        // перестановки всех слов
        $a = array();
        if (preg_match_all("/([\.\d\pL]+)/ius", $query, $r)) {
            foreach ($r[1] as $part) {
                $a[] = $connection->escapeString($part);
            }
        }

        if (!$a) {
            throw new ServiceUtils_Exception();
        }

        foreach ($a as $part) {
            $w = array();

            $w[] = "id ='$part'";
            $w[] = "number ='$part'";
            $w[] = "name LIKE '%$part%'";

            // превращаем в en транскрипцию
            try {
                $partTr = StringUtils_Transliterate::TransliterateRuToEn($part);

                $partTr = $connection->escapeString($partTr);

                $w[] = "name LIKE '%$partTr%'";
            } catch (Exception $e) {

            }

            // превращаем ru
            try {
                $partRu = StringUtils_Transliterate::TransliterateCorrectTo('ru', $part);

                $partRu = $connection->escapeString($partRu);

                $w[] = "name LIKE '%$partRu%'";
            } catch (Exception $e) {

            }

            // превращаем en
            try {
                $partEn = StringUtils_Transliterate::TransliterateCorrectTo('en', $part);

                $partEn = $connection->escapeString($partEn);

                $w[] = "name LIKE '%$partEn%'";
            } catch (Exception $e) {

            }

            $orders->addWhereQuery("(" . implode(' OR ', $w) . ")");
        }

        return $orders;
    }

    /**
     * Добавить системный к заказу (уведомление)
     * $notifyTerm - это минимальная дата до которой не дублировать уведомление.
     *
     * @param ShopOrder $order
     * @param string $comment
     * @param string $notifyTerm
     */
    public function addOrderNotify(ShopOrder $order, $comment, $notifyTerm = false) {
        PackageLoader::Get()->import('CommentsAPI');
        $commentKey = 'shop-order-'.$order->getId();
        $comment = trim($comment);

        try {
            SQLObject::TransactionStart();

            if ($notifyTerm) {
                $tmp = CommentsAPI::Get()->getComments($commentKey);
                $tmp->addWhere('cdate', $notifyTerm, '>=');
                $tmp->setId_user(-1);
                $tmp->setLimitCount(1);
                if ($tmp->getNext()) {
                    throw new ServiceUtils_Exception('notify-term');
                }
            }

            // добавляем комментарий
            $object = CommentsAPI::Get()->addComment(
            $commentKey,
            $comment,
            -1
            );

            // отправляем его по почте
            Shop::Get()->getShopService()->orderEmailNotification(
            $order,
            null,
            $comment
            );

            // специально чтобы поставить udate
            $order->update();

            SQLObject::TransactionCommit();
            return $object;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Добавить комментарий к заказу
     *
     * @param ShopOrder $order
     * @param User $user
     * @param string $comment
     * @param array $fileArray
     */
    public function addOrderComment(ShopOrder $order, User $user, $comment, $fileArray = false, $addOrderEmployer = true) {
        PackageLoader::Get()->import('CommentsAPI');
        $commentKey = 'shop-order-'.$order->getId();
        try {
            SQLObject::TransactionStart();
            $comment = trim($comment);

            if (!$fileArray) {
                $fileArray = array();
            }

            // прицепляем файлы
            foreach ($fileArray as $x) {
                $path = $x['path'];
                $name = $x['name'];
                $type = $x['type'];

                $md5 = md5(file_get_contents($path));

                $tmp = new ShopFile();
                // @todo: key name standartization
                $tmp->setKey('order-'.$order->getId());
                $tmp->setFile($md5);
                if (!$tmp->select()) {
                    $tmp->setCdate(date('Y-m-d H:i:s'));
                    $tmp->setUserid($user->getId());
                    $tmp->setName($name);
                    $tmp->setContenttype($type);
                    $tmp->insert();

                    copy($path, PackageLoader::Get()->getProjectPath().'media/file/'.$md5);

                    $comment .= "\n";
                    $comment .= '[file]'.$tmp->getId().'[/file]';
                    $comment .= "\n";
                }
            }

            // добавляем того кто пишет комментарий в наблюдатели автоматически
            if ($addOrderEmployer) {
                try {
                    Shop::Get()->getShopService()->addOrderEmployer($order, $user);
                } catch (Exception $watcherEx) {

                }
            }

            // парсим комментарий на предмет юзеров,
            // которым надо отправить временные уведомления
            $tempUserArray = array();
            if (preg_match_all("/\[(?:.+?)\#(\d+)\]/ius", $comment, $r)) {
                foreach ($r[1] as $userID) {
                    try {
                        $tempUserArray[] = Shop::Get()->getUserService()->getUserByID($userID);
                    } catch (Exception $e) {

                    }
                }
            }

            // добавляем комментарий
            $object = CommentsAPI::Get()->addComment(
            $commentKey,
            $comment,
            $user->getId()
            );

            // отправляем его по почте
            Shop::Get()->getShopService()->orderEmailNotification(
            $order,
            $user,
            $comment,
            $tempUserArray
            );

            // специально чтобы поставить udate
            $order->update();

            SQLObject::TransactionCommit();
            return $object;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }




    /**
     * Обновить теги товара
     */
    public function updateProductTags(ShopProduct $product) {
        try {
            SQLObject::TransactionStart();

            // получаем массив всех FCV по данному товару
            /*$tmp = new XShopProduct2Tag();
            $tmp->setProductid($product->getId());
            $tagIDArray = array();
            while ($x = $tmp->getNext()) {
                $tagIDArray[$x->getTagid()] = $x;
            }

            $tags = explode(',', $product->getTags());

            foreach ($tags as $name) {
                $name = trim($name);
                if (!$name) {
                    continue;
                }

                try {
                    $tag = new XShopProductTag();
                    $tag->setName($name);
                    if (!$tag->select()) {
                        $tag->insert();
                    }

                    $tmp = new XShopProduct2Tag();
                    $tmp->setProductid($product->getId());
                    $tmp->setTagid($tag->getId());
                    if (!$tmp->select()) {
                        $tmp->insert();
                    }

                    // если обновили - убираем из массива
                    if (isset($tagIDArray[$tmp->getTagid()])) {
                        unset($tagIDArray[$tmp->getTagid()]);
                    }
                } catch (Exception $e) {

                }
            }

            // удаляем все не актуальные tag
            foreach ($tagIDArray as $object) {
                $object->delete();
            }*/

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Создать штрих-код
     *
     * @param string $file
     * @param string $text
     */
    public function createBarcodeImage($file, $text) {
        if (!file_exists($file)) {
            $fontSize = 60;
            $text = '*'.$text.'*';

            $bbox = imagettfbbox($fontSize, 0, MEDIA_PATH.'/fonts/Code39.TTF', $text);

            $im = imagecreate($bbox[4] - $bbox[6] + 5, $bbox[3] - $bbox[5]);
            $background_color = imagecolorallocate($im, 255, 255, 255);
            $text_color = imagecolorallocate($im, 0, 0, 0);

            imagettftext($im, $fontSize, 0, -$bbox[6], -$bbox[5], $text_color, MEDIA_PATH.'/fonts/Code39.TTF', $text);

            imagepng($im, $file);
            imagedestroy($im);
        }
    }

    /**
     * Получить список notification-емейлов
     *
     * @return array
     */
    protected function _getNotificationEmailArray($emailKey = 'email-orders') {
        $orderEmails = Shop::Get()->getSettingsService()->getSettingValue($emailKey);
        return $this->_extractEmailArray($orderEmails);
    }

    /**
     * Поставить заказу UTM-метки, referal, IP.
     * Внимание! Метод не делает update()!
     *
     * @param ShopOrder $order
     */
    protected function _setOrderUTM(ShopOrder $order) {
        if (!empty($_COOKIE['utm_source'])) {
            $order->setUtm_source($_COOKIE['utm_source']);
        }
        if (!empty($_COOKIE['utm_medium'])) {
            $order->setUtm_medium($_COOKIE['utm_medium']);
        }
        if (!empty($_COOKIE['utm_campaign'])) {
            $order->setUtm_campaign($_COOKIE['utm_campaign']);
        }
        if (!empty($_COOKIE['utm_content'])) {
            $order->setUtm_content($_COOKIE['utm_content']);
        }
        if (!empty($_COOKIE['utm_source'])) {
            $order->setUtm_term($_COOKIE['utm_term']);
        }
        if (!empty($_COOKIE['utm_date'])) {
            $order->setUtm_date($_COOKIE['utm_date']);
        }
        if (!empty($_COOKIE['utm_referrer'])) {
            $order->setUtm_referrer($_COOKIE['utm_referrer']);
        }
        // ip
        $order->setIp(@$_SERVER['REMOTE_ADDR']);
    }

    /**
     * Получить список notification-емейлов
     *
     * @param string $text
     * @return array
     */
    protected function _extractEmailArray($text) {
        $text = str_replace(array("\r", "\n", "\t"), ' ', $text);
        $text = preg_replace("/([\s\,\;]+)/ius", ' ', $text);
        $orderEmailsArray = explode(' ', $text);
        $a = array();
        foreach ($orderEmailsArray as $x) {
            $x = trim($x);
            if (Checker::CheckEmail($x)) {
                $a[] = $x;
            }
        }
        return $a;
    }

    protected function _processBoolValue($value) {
        if (substr_count($value, 'y')
        || substr_count($value, '+')
        || substr_count($value, 'да')
        || substr_count($value, '1')
        ) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * Форматировать текст для письма.
     * Поправка ссылок [file]
     *
     * @param string $content
     * @return string
     */
    protected function _formatCommentForEmail($content) {
        $content = preg_replace("/\[file\](\d+)\[\/file\]/iuse", '$this->_formatCommentFileReplace($1)', $content);

        return $content;
    }

    private function _formatCommentFileReplace($fileID) {
        $tmp = new ShopFile($fileID);
        if (!$tmp->getId()) {
            $fileID;
        }

        $text = '"'.$tmp->getName().'"';
        $text .= ' ';
        $text .= Engine::Get()->getProjectURL();
        $text .= $tmp->makeURL();

        return $text;
    }

    protected function _sortNameASC($a, $b) {
        return $a['name'] > $b['name'];
    }


    /**
     * Кеш логотипов
     *
     * @var array
     */
    private $_logoArray = false;

    /**
     * Временный кеш для дерева категорий.
     * Нужен когда быстро и много вызывается buildProductCategory()
     *
     * @var array
     */
    private $_categoryTreeArray = array();

}