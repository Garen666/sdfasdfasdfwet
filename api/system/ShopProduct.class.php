<?php
/**
 * WebProduction Shop (wpshop)
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class ShopProduct extends XShopProduct {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopProduct
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return ShopProduct
     */
    public static function Get($key) {
        return self::GetObject('ShopProduct', $key);
    }

    /**
     * @return int
     */
    public function getCurrencyid() {
        $currencyID = parent::getCurrencyid();
        if (!$currencyID) {
            return Shop::Get()->getCurrencyService()->getCurrencySystem()->getId();
        }
        return $currencyID;
    }

    /**
     * @todo actual?
     * @deprecated
     *
     * @return ShopProductPassport
     */
    public function getPassportProducts() {
        return Shop::Get()->getShopService()->getProductPassport($this);
    }

    /**
     * Получить значение определенного фильтра
     *
     * @param ShopProductFilter $filter
     * @return mixed
     */
    public function getFilterValue(ShopProductFilter $filter, $actual = false, $use = false) {
        $a = array();
        try {
            $filter_count = Engine::Get()->getConfigField('filter_count');
        } catch (Exception $e) {
            $filter_count = 10;
        }
        for ($j = 1; $j <= $filter_count; $j++) {
            $filterID = $this->getField('filter'.$j.'id');

            if ($filterID == $filter->getId()) {

                if ($actual && !$this->getField('filter'.$j.'actual')) {
                    continue;
                }

                if ($use && !$this->getField('filter'.$j.'use')) {
                    continue;
                }

                $a[] = $this->getField('filter'.$j.'value');
            }
        }

        // если значение одно - возвращаем его
        if (count($a) == 1) {
            return $a[0];
        } elseif (count($a) == 0) {
            return false;
        } else {
            return $a;
        }
    }

    public function setFilterValue(ShopProductFilter $filter, $value, $actual = false, $use = false, $markup = false, $option = false) {
        try {
            $filter_count = Engine::Get()->getConfigField('filter_count');
        } catch (Exception $e) {
            $filter_count = 10;
        }

        $ok = false;

        for ($j = 1; $j <= $filter_count; $j++) {
            $filterID = $this->getField('filter'.$j.'id');

            if ($filterID == $filter->getId()) {
                $this->setField('filter'.$j.'value', $value);
                if ($actual !== false) {
                    $this->setField('filter'.$j.'actual', $actual);
                }
                if ($use !== false) {
                    $this->setField('filter'.$j.'use', $use);
                }
                if ($markup !== false) {
                    $this->setField('filter'.$j.'markup', $markup);
                }
                if ($option !== false) {
                    $this->setField('filter'.$j.'option', $option);
                }
                $this->update();

                $ok = true;
            }
        }

        if ($ok) {
            return;
        }

        // фильтр не найден
        for ($j = 1; $j <= $filter_count; $j++) {
            $filterID = $this->getField('filter'.$j.'id');
            if (!$filterID) {
                $this->setField('filter'.$j.'id', $filter->getId());
                $this->setField('filter'.$j.'value', $value);
                if ($actual !== false) {
                    $this->setField('filter'.$j.'actual', $actual);
                }
                if ($use !== false) {
                    $this->setField('filter'.$j.'use', $use);
                }
                if ($markup !== false) {
                    $this->setField('filter'.$j.'markup', $markup);
                }
                if ($option !== false) {
                    $this->setField('filter'.$j.'option', $option);
                }
                $this->update();

                break;
            }
        }

        return;
    }

    /**
     * Получить категорию товара.
     * Можно указать какую по вложенности.
     *
     * @param int $index
     * @return ShopCategory
     */
    public function getCategory($index = false) {
        $id = $this->getCategoryid();

        if ($index > 0) {
            $id = $this->getField('category'.$index.'id');
        }

        return Shop::Get()->getShopService()->getCategoryByID(
        $id
        );
    }

    /**
     * @return string
     */
    public function makeURL($friendlyURL = true) {
        $fullurl = '';
        if ($friendlyURL) {
            if (@isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
                $h = 'https://';
            } else {
                $h = 'http://';
            }
            $categorySubdomain = $this->getCategorySubdomain();
            if (Engine::Get()->getProjectHost()) {
                $fullurl = $h.($categorySubdomain ? $categorySubdomain.'.' : '').Engine::Get()->getProjectHost();
            }
        }
        if ($friendlyURL && $this->getUrl()) {
            $url = '/'.$this->getUrl();
            return $fullurl.$url;
        } else {
            return $fullurl.Engine::GetLinkMaker()->makeURLByContentIDParam(
            'shop-product',
            $this->getId()
            );
        }
    }

    public function getCategorySubdomain() {
        try {
            return Shop::Get()->getShopService()->getCategorySubdomain($this->getCategory());
        } catch (Exception $e) { }
    }

    /**
     * @return string
     */
    public function makeURLEdit() {
        return Engine::GetLinkMaker()->makeURLByContentIDParam(
        'shop-admin-products-edit',
        $this->getId()
        );
    }

    /**
     * @return string
     */
    public function makeURLBarcode() {
        return Engine::GetLinkMaker()->makeURLByContentIDParam(
        'shop-product-barcode',
        $this->getId()
        );
    }

    /**
     * @return string
     */
    public function makeURLDelete() {
        return Engine::GetLinkMaker()->makeURLByContentIDParam(
        'shop-admin-products-delete',
        $this->getId()
        );
    }

    /**
     * @return ShopCurrency
     */
    public function getCurrency() {
        return Shop::Get()->getCurrencyService()->getCurrencyByID(
        $this->getCurrencyid()
        );
    }

    /**
     * Построить информацию о товаре
     *
     * @return array
     */
    public function makeInfoArray() {
        $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();

        $a = array();
        $a['id'] = $this->getId();
        $a['code'] = $this->makeCode();
        $a['name'] = $this->makeName();
        $a['nameQuick'] = str_replace("'", "\'", $this->makeName());
        $a['description'] = $this->getDescription();
        // #60817 если есть кроп, то берем кроп изображение, а не основное
        // необходимо указывать ширину дабы ImageProcessor смог расчитать положение wotemark
        if ($this->getImagecrop()) {
            $a['image'] = Shop_ImageProcessor::MakeThumbUniversal(MEDIA_PATH.'/shop/'.$this->getImagecrop(), 330, 225, 'prop');
        } else {
            $a['image'] = $this->makeImageThumb(330, 225, 'prop');
        }
        $a['url'] = $this->makeURL();
        $a['price'] = $this->makePriceWithTax($currencyDefault, true);
        $a['unit'] = $this->getUnit();
        $a['currency'] = $currencyDefault->getSymbol();
        $a['rating'] = $this->makeRating();
        $a['viewed'] = $this->getViewed();
        $a['ordered'] = $this->getOrdered();
        $a['avail'] = $this->getAvail();
        $a['availtext'] = $this->getAvailtext();
        return $a;
    }

    /**
     * Построить строку характеристик продукта.
     *
     * @return string
     */
    public function makeCharacteristicsString() {
        try {
            $filter_count = Engine::Get()->getConfigField('filter_count');
        } catch (Exception $e) {
            $filter_count = 10;
        }

        $characteristicsArray = array();

        // характеристики по данному товару
        for ($j = 1; $j <= $filter_count; $j++) {
            try {
                if ($this->getField('filter'.$j.'actual') && $this->getField('filter'.$j.'value')) {
                    $filterID = $this->getField('filter'.$j.'id');
                    $filter = Shop::Get()->getShopService()->getProductFilterByID($filterID);
                    if ($filter->getHidden()) {
                        continue;
                    }

                    $characteristicsArray[] = str_replace('::', ':', $filter->getName().': '.$this->getField('filter'.$j.'value'));
                }
            } catch (Exception $e) {

            }
        }

        return strip_tags(implode(', ', $characteristicsArray));
    }


    /**
     * @todo
     *
     * @return float
     */
    public function makeRating() {
        return round($this->getRating());
    }

    /**
     * проверяем есть в настройках "Использовать на сайте коды 1С" == true
     * то вернем cod1c или id товара
     *
     * @return int|string
     */
    public function makeCode() {
        return $this->getId();
    }

    /**
     * Посчитать цену товара в указанной валюте.
     * $discount - с учетом скидки
     *
     * Метод править разрешено только Senior'ам!
     *
     * @param ShopCurrency $currency
     * @param bool $discount
     * @return float
     */
    public function makePrice(ShopCurrency $currency, $discount = true) {
        $price = $this->getPrice();

        $price = Shop::Get()->getCurrencyService()->convertCurrency(
        $price,
        $this->getCurrency(),
        $currency
        );


        $price = round($price);


        return $price;
    }


    /**
     * Посчитать "Зачеркнутой цены" товара в указанной валюте.
     *
     * Метод править разрешено только Senior'ам!
     *
     * @param ShopCurrency $currency
     * @return float
     */
    public function makePriceOld(ShopCurrency $currency) {
        $price = $this->getPriceold();

        if ( !$this->getDiscount() ) {
            $price = Shop::Get()->getCurrencyService()->convertCurrency(
            $price,
            $this->getCurrency(),
            $currency
            );


                $price = round($price);


            return $price + 0;

        } else {

            return $this->makePriceWithTax($currency, false);

        }
    }

    /**
     * Посчитать цену товара в указанной валюте с учетом НДС и скидки.
     *
     * Если в товаре указан +% НДС - то добавляем его.
     * Иначе возвращаем просто цену.
     *
     * @uses при выводе товаров в магазине, при оформлении заказа
     *
     * @param ShopCurrency $currency
     * @param bool $discount
     * @return float
     */
    public function makePriceWithTax(ShopCurrency $currency, $discount = true) {
        // получаем цену в необходимой валюте
        $price = $this->makePrice($currency, $discount);

        // если есть НДС - то добавляем его к стоимости товара
        if ($this->getTaxrate() > 0) {
            $price = $price + ($price * $this->getTaxrate() / 100);
        }


            $price = round($price);


        return $price;
    }

    /**
     * Проверка, подходит ли количество для товара
     *
     * @param float $count
     * @return boolean
     */
    public function testDivisibility($count) {
        // @todo: to service
        if ($this->getDivisibility() > 0) {
            if (($count / $this->getDivisibility()) != floor($count / $this->getDivisibility())) {
                return false;
            }
        }
        return true;
    }

    /**
     * Округлить количество товара с учетом дробимости
     *
     * @param float $count
     * @return float
     */
    public function getCountWithDivisibility($count) {
        // @todo: to service
        if ($this->getDivisibility() > 0) {
            $count = ceil($count / $this->getDivisibility()) * $this->getDivisibility();
        }
        return $count;
    }


    /**
     * Перегрузка метода, для отображения нужных цен нужным
     *
     * @return float
     */
    public function getPrice() {
        $price = parent::getPrice();

        try {
            // сначала проверка у пользователя
            $level = Shop::Get()->getUserService()->getUser()->getPricelevel();
            if ($level > 0) {
                $x = $this->getField('price'.$level);
                if ($x > 0) {
                    $price = $x;
                }
            } else {
                // проверка прав у группы
                $level = Shop::Get()->getUserService()->getUser()->getUserGroup()->getPricelevel();
                if ($level > 0) {
                    $x = $this->getField('price'.$level);
                    if ($x > 0) {
                        $price = $x;
                    }
                }
            }
        } catch (Exception $e) {

        }

        return $price;
    }

    public function makeName($escape = true) {
        if ($escape) {
            return htmlspecialchars($this->getName());
        } else {
            return $this->getName();
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

    public function makeBarcodeImageInternal() {
        $file = MEDIA_PATH.'/productbarcode/product'.$this->getId().'internal.png';
        $this->createBarcodeImage($file, $this->getId());
        return MEDIA_DIR.'/productbarcode/product'.$this->getId().'internal.png?'.time();
    }

    public function makeBarcodeImageExternal() {
        $barcode = $this->getBarcode();
        if (!$barcode) {
            throw new ServiceUtils_Exception();
        }
        $file = MEDIA_PATH.'/productbarcode/product'.$this->getId().'external.png';
        $this->createBarcodeImage($file, $barcode);
        return MEDIA_DIR.'/productbarcode/product'.$this->getId().'external.png?'.time();
    }

    /**
     * @return array
     */
    public function makeAssignArrayForDocument() {
        $a = array();

        $a['productid'] = $this->getId();
        $a['name'] = mb_substr($this->getName(), 0, 12);

        try {
            $a['barcodeimageexternal'] = $this->makeBarcodeImageExternal();
        } catch (ServiceUtils_Exception $se) {

        }

        $a['barcodeimageinternal'] = $this->makeBarcodeImageInternal();
        return $a;
    }

    /**
     * @return float
     */
    public function getPriceWithDiscount() {

        $price = $this->getPrice();
        $discount = $this->getDiscount();

        if ($price && $discount) {
            $discount = $discount / 100;
            $price = $price - $price * $discount;
        }

        return  number_format($price, 2, '.', '');
    }

    public function update($massUpdate = false) {
        if (!$massUpdate) {
            try {
                Shop::Get()->getShopService()->addProductChange($this);
            } catch (Exception $historyEx) {

            }

            $this->setUdate(date('Y-m-d H:i:s'));
        }

        $updateFVC = false;
        $updateTag = false;
        $a = $this->getValueUpdateArray();
        foreach ($a as $key => $value) {
            if (substr_count($key, 'filter')) {
                $updateFVC = true;
            }
            if ($key == 'tags') {
                $updateTag = true;
            }
        }

        $result = parent::update($massUpdate);

        // обновление данных FVC
        if (!$massUpdate && $updateFVC) {
            Shop::Get()->getShopService()->updateProductFVC($this);
        }

        // обновление тегов
        if (!$massUpdate && $updateTag) {
            Shop::Get()->getShopService()->updateProductTags($this);
        }

        return $result;
    }

    /**
     * Проверить, является ли продукт скрытый каким-либо образом
     *
     * @return bool
     */
    public function isHidden() {
        if ($this->getHidden()) {
            return true;
        }

        if ($this->getDeleted()) {
            return true;
        }

        try {
            if ($this->getCategory()->isHidden()) {
                return true;
            }
        } catch (Exception $e) {
            return true;
        }

        return false;
    }

    // FCV для insert пока не нужно
    /*public function insert() {
        $result = parent::insert();

        // обновление данных FVC
        Shop::Get()->getShopService()->updateProductFVC($this);

        return $result;
    }*/

}