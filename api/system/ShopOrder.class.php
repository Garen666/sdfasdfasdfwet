<?php
/**
 * WebProduction Shop (wpshop)
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class ShopOrder extends XShopOrder {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopOrder
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return ShopOrder
     */
    public static function Get($key) {
        return self::GetObject('ShopOrder', $key);
    }

    /**
     * @return ShopOrderProduct
     */
    public function getOrderProducts() {
        $products = Shop::Get()->getShopService()->getOrderProducts($this);
        $products->setOrder('sortable');

        return $products;
    }

    /**
     * @return string
     */
    public function makeURL() {
        return Engine::GetLinkMaker()->makeURLByContentIDParam(
        'shop-client-orders-view',
        $this->getId()
        );
    }

    /**
     * @return string
     */
    public function makeURLEdit() {
        return Engine::GetLinkMaker()->makeURLByContentIDParam(
        'shop-admin-orders-control',
        $this->getId()
        );
    }

    public function makeDate() {
        return DateTime_Formatter::DateTimePhonetic($this->getCdate());
    }

    /**
     * @return ShopCurrency
     */
    public function getCurrency() {
        // если по какой-то причине нет валюты - то возвращаем системную
        if (!$this->getCurrencyid()) {
            return Shop::Get()->getCurrencyService()->getCurrencySystem();
        }

        // иначе как обычно
        return Shop::Get()->getCurrencyService()->getCurrencyByID(
        $this->getCurrencyid()
        );
    }

    /**
     * Получить клиента
     *
     * @deprecated
     * @see getClient()
     *
     * @return User
     */
    public function getUser() {
        return $this->getClient();
    }

    /**
     * Получить клиента
     *
     * @return User
     */
    public function getClient() {
        return Shop::Get()->getUserService()->getUserByID(
        $this->getUserid()
        );
    }

    /**
     * Получить менеджера
     *
     * @return User
     */
    public function getManager() {
        return Shop::Get()->getUserService()->getUserByID(
        $this->getManagerid()
        );
    }

    /**
     * Получить автора заказа
     *
     * @return User
     */
    public function getAuthor() {
        return Shop::Get()->getUserService()->getUserByID(
        $this->getAuthorid()
        );
    }

    /**
     * Получить менеджера или автора
     *
     * @return User
     */
    public function getManagerOrAuthor() {
        try {
            return $this->getManager();
        } catch (Exception $e) {

        }

        try {
            return $this->getAuthor();
        } catch (Exception $e) {

        }

        throw new ServiceUtils_Exception();
    }

    /**
     * Получить способ оплаты заказа
     *
     * @return ShopPayment
     */
    public function getPayment() {
        return Shop::Get()->getShopService()->getPaymentByID(
        $this->getPaymentid()
        );
    }

    /**
     * Получить статус заказа
     *
     * @return ShopOrderStatus
     */
    public function getStatus() {
        return Shop::Get()->getShopService()->getStatusByID(
        $this->getStatusid()
        );
    }

    /**
     * Get dateto
     * @return string
     */
    public function getDateto() {
        $dateto = parent::getDateto();
        if ($dateto < $this->getCdate()) {
            return $this->getCdate();
        } else {
            return $dateto;
        }
    }

    public function getOrderProductsCount($orderID){
        $allOrderProduct = Shop::Get()->getShopService()->getOrderProductsAll();
        $allOrderProduct->setOrderid($orderID);
        $count = 0;
        while ($x = $allOrderProduct->getNext()){
            $count += $x->getProductcount() + 0;
        }
        return $count;
    }

    /**
     * @return array
     */
    public function makeAssignArrayForDocument() {
        $order = $this;


        $currencyOrder = $order->getCurrency();
        $printWarranty = false;
        $taxSum = 0;
        $orderSum = 0;
        $productsSum = 0;
        $orderSumWithoutTax = 0;
        $priceSum = 0;

        $minFrom = false;
        $maxTo = false;

        // формируем документ
        $productsArray = array();
        $productInfoArray = array();

        $hasWarranty = false;

        $orderproducts = $order->getOrderProducts();
        while ($op = $orderproducts->getNext()) {
            try {
                $priceWithoutTax = Shop::Get()->getShopService()->calculateSum(
                $op->makePrice($currencyOrder),
                $contractorTax,
                0,
                0,
                true,
                false,
                false
                );

                $unit = '';
                try {
                    $unit = $op->getProduct()->getUnit();
                } catch (ServiceUtils_Exception $ue) {

                }

                $productsArray[] = array(
                'productid' => $op->getProductid(),
                'name' => $op->getProductname(),
                'serial' => $op->getSerial(),
                'warranty' => $op->getWarranty(),
                'warrantyDate' => DateTime_Object::FromString($this->getCdate())->addMonth($op->getWarranty())->setFormat('d-m-Y')->__toString(),
                'price' => $priceWithoutTax,
                'productprice' => $op->makePrice($order->getCurrency()),
                'currency' => $currencyOrder->getSymbol(),
                'count' => $op->getProductcount(),
                'sum' => $op->makeSum($currencyOrder),
                'comment' => $op->getComment(),
                'pricenotax' => round($priceWithoutTax, 2),
                'sumnotax' => round($priceWithoutTax * $op->getProductcount(), 2),
                'unit' => $unit,
                'categoryname' => $op->getCategoryname(),
                'from' => $op->getDatefrom(),
                'from_date' => DateTime_Formatter::DateISO8601($op->getDatefrom()),
                'to' => $op->getDateto(),
                'to_date' => DateTime_Formatter::DateISO8601($op->getDateto()),
                );

                if ($op->getWarranty()) {
                    $hasWarranty = true;
                }

                $priceSum += round($op->makePrice($order->getCurrency()), 2);

                // сумма всех товаров
                $productsSum += $op->getProductcount();

                $orderSumWithoutTax += round($priceWithoutTax * $op->getProductcount(), 2);

                if (!$minFrom || $minFrom > $op->getDatefrom()) {
                    $minFrom = $op->getDatefrom();
                }

                if (!$maxTo || $maxTo < $op->getDateto()) {
                    $maxTo = $op->getDateto();
                }
            } catch (Exception $e) {

            }

            // информация о товарах (для перезентационных документах)
            try {
                $product = $op->getProduct();

                $imageArray = array();
                $images = $product->getImages();
                while ($i = $images->getNext()) {
                    $imageArray[] = $i->makeImageThumb(320, 240);
                }

                $productInfoArray[$product->getId()] = array(
                'name' => $product->getName(),
                'categoryname' => $op->getCategoryname(),
                'price' => $product->getPrice(),
                'currency' => $product->getCurrency()->getSymbol(),
                'unit' => $product->getUnit(),
                'description' => $product->getDescription(),
                'image' => $product->getImage() ? $product->makeImageThumb(320, 240) : false,
                'imageArray' => $imageArray,
                );
            } catch (Exception $e) {

            }
        }

        $a = array();
        $a['number'] = $order->getId();
        $a['productsArray'] = $productsArray;
        $a['productsum'] = round($productsSum, 3);

        $a['ordercomment'] = htmlspecialchars($order->makeComment());
        $a['ordersum'] = $order->getSum();
        $a['pricesum'] = $priceSum;
        //текстовая сумма с доставкой сумма заказа с доставкой
        $a['ordersumtext'] = StringUtils_Converter::FloatToMoney($order->getSum(), 'ua');
        $a['ordercurrency'] = $order->getCurrency()->getSymbol();
        $a['clientid'] = $order->getUserid();
        $a['orderid'] = $order->getId();
        $a['orderdate'] = DateTime_Formatter::DateRussianGOST($order->getCdate()); // @todo: in multi-languages
        $a['orderdateto'] = DateTime_Formatter::DateRussianGOST($order->getDateto()); // @todo: in multi-languages
        $a['printwarranty'] = $printWarranty;
        $a['productInfoArray'] = $productInfoArray;
        $a['hasWarranty'] = $hasWarranty;
        if ($minFrom) {
            $a['minFrom'] = DateTime_Formatter::DateISO8601($minFrom);
        }
        if ($maxTo) {
            $a['maxTo'] = DateTime_Formatter::DateISO8601($maxTo);
        }

        try {
            $a['ordercategory'] = $order->getCategory()->getName();
        } catch (Exception $e) {

        }

        $taxSum = $order->makeTaxSum();
        $a['taxsum'] = round($taxSum, 2);

        //к общей сумме с НДС, добавляем стоимость доставки
        $a['ordersumwithtax'] = round($order->getSum(), 2);
        $a['ordersumwithouttax'] = round($orderSumWithoutTax, 2);

        $a['orderBarcode'] = $order->makeBarcode();

        return $a;
    }

    /**
     * Получить штрих-код
     *
     * @return string
     */
    public function makeBarcode() {
        $file = MEDIA_PATH.'/document/order-barcode'.$this->getId().'.png';
        Shop::Get()->getShopService()->createBarcodeImage($file, $this->getId());
        return MEDIA_DIR.'/document/order-barcode'.$this->getId().'.png?'.time();
    }

    /**
     * @return ShopOrderCategory
     * @deprecated
     * @see getWorkflow()
     */
    public function getCategory() {
        return $this->getWorkflow();
    }

    /**
     * @return ShopOrderCategory
     */
    public function getWorkflow() {
        return Shop::Get()->getShopService()->getOrderCategoryByID(
        $this->getCategoryid()
        );
    }

    public function getWorkflowid() {
        return $this->getCategoryid();
    }

    /**
     * @return ShopSource
     */
    public function getSource() {
        return Shop::Get()->getShopService()->getSourceByID(
        $this->getSourceid()
        );
    }

    /**
     * Посчитать сумму оплат по заказу.
     * Возвращает в валюте заказа.
     *
     * @return float
     */
    public function makeSumPaid() {
        if (!Shop_ModuleLoader::Get()->isImported('finance')) {
            return 0;
        }

        return PaymentService::Get()->calculatePaymentSumByOrder($this);
    }

    /**
     * Посчитать сумму заказу и под задачах.
     * Возвращает в валюте заказа.
     *
     * @return float
     */
    public function makeSum() {
        return Shop::Get()->getShopService()->calculateOrderSum($this);
    }

    /**
     * Посчитать баланс заказа.
     * Возвращает в валюте заказа.
     *
     * @return float
     */
    public function makeSumBalance() {
        return round($this->makeSumPaid() - $this->makeSum(), 2);
    }

    public function insert() {
        $this->setUdate(date('Y-m-d H:i:s'));
        $result = parent::insert();

        if (!$this->getNumber()) {
            $this->setNumber($this->getId());
            $this->update();
        }

        return $result;
    }

    public function update($massUpdate = false) {
        $this->setUdate(date('Y-m-d H:i:s'));

        if (!$this->getNumber()) {
            $this->setNumber($this->getId());
            $this->update();
        }

        return parent::update($massUpdate);
    }

    /**
     * Получить номер заказа
     *
     * @return string
     */
    public function getNumber($real = false) {
        if ($real) {
            $x = parent::getNumber();
            if ($x == $this->getId()) {
                return false;
            }
            return $x;
        }

        $x = parent::getNumber();
        if ($x) {
            return $x;
        }
        return $this->getId();
    }

    /**
     * Построить имя заказа
     *
     * @param bool $autoName
     * @return string
     */
    public function makeName($escape = false) {
        $name = '';
        $number = $this->getNumber(true);
        if ($number) {
            $name .= $number;
        } else {
            $name .= '#'.$this->getId();
        }
        if ($this->getName()) {
            $name .= ' - '.$this->getName();
        }
        if ($escape) {
            $name = htmlspecialchars($name);
        }

        return $name;
    }

    /**
     * Посчитать сумму без НДС
     *
     * @return float
     */
    public function makeSumWithoutTax() {
        return round($this->getSum() - $this->makeTaxSum(), 2);
    }

    /**
     * Получить первый комментарий к заказу
     *
     * @return string
     */
    public function makeComment() {
        PackageLoader::Get()->import('CommentsAPI');

        $commentKey = 'shop-order-'.$this->getId();


        $comments = CommentsAPI::Get()->getComments($commentKey);
        $comments->setOrder('cdate', 'ASC');
        $comments->setLimitCount(1);
        if ($x = $comments->getNext()) {
            return $x->getContent();
        }

        return false;
    }

    /**
     * Получить время на выполнение задачи
     *
     * @return float
     */
    public function makeEstimateTime() {
        $x = $this->getEstimate();

        $subIssues = IssueService::Get()->getIssuesAll();
        $subIssues->setParentid($this->getId());
        while ($issue = $subIssues->getNext()) {
            $x += $issue->makeEstimateTime();
        }

        $x = round($x, 2);
        return $x;
    }

    /**
     * Получить деньги на выполнение задачи
     *
     * @return float
     */
    public function makeEstimateMoney() {
        $x = $this->getMoney();

        $subIssues = IssueService::Get()->getIssuesAll();
        $subIssues->setParentid($this->getId());
        while ($issue = $subIssues->getNext()) {
            $x += $issue->makeEstimateMoney();
        }

        $x = round($x, 2);
        return $x;
    }

    /**
     * Считается ли задача закрытой?
     *
     * @return bool
     */
    public function isClosed() {
        return $this->getDateclosed() != '0000-00-00 00:00:00';
    }

    /**
     * Получить родительскую задачу или проект
     *
     * @return ShopOrder
     */
    public function getParent() {
        return Shop::Get()->getShopService()->getOrderByID(
        $this->getParentid()
        );
    }

    /**
     * Посчитать Маржу в системной валюте
     *
     * @return float|int
     */
    public function makeMargin() {
        $orderProduct = $this->getOrderProducts();
        $marginReturn = 0;
        while ($x = $orderProduct->getNext()) {
            $price = Shop::Get()->getCurrencyService()->convertCurrency(
                $x->getProductprice(),
                $x->getCurrency(),
                Shop::Get()->getCurrencyService()->getCurrencySystem()
            );

            $margin = Shop::Get()->getCurrencyService()->convertCurrency(
                $x->getProduct()->getPricebase(),
                $x->getCurrency(),
                Shop::Get()->getCurrencyService()->getCurrencySystem()
            );

            $marginReturn += ($price - $margin) * $x->getProductcount();
        }

        return $marginReturn;
    }

}