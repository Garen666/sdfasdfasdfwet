<?php
/**
 * WebProduction Shop (wpshop)
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @copyright WebProduction
 * @package Shop
 */
class Shop_CurrencyService extends ServiceUtils_AbstractService {

    /**
     * Получить все валюты
     *
     * @return ShopCurrency
     */
    public function getCurrencyAll() {
        $x = new ShopCurrency();
        $x->setOrder("`default` DESC,`sort` ASC,`name` ASC", false);
        return $x;
    }

    /**
     * Получить все активные валюты
     *
     * @return ShopCurrency
     */
    public function getCurrencyActive() {
        $x = $this->getCurrencyAll();
        $x->setHidden(0);
        return $x;
    }

    /**
     * @param int $id
     * @return ShopCurrency
     */
    public function getCurrencyByID($id) {
        return $this->getObjectByID($id, 'ShopCurrency');
    }

    /**
     * @param string $name
     * @return ShopCurrency
     */
    public function getCurrencyByName($name) {
        $name = trim($name);
        return $this->getObjectByField('name', $name, 'ShopCurrency');
    }

    /**
     * Получить системную валюту.
     * Валюта по умолчанию может быть только одна.
     *
     * Метод разрешено править только Senior'ам!
     *
     * В системной валюте проводятся все внутренние операции системы,
     * например, оформление заказа и т.д.
     *
     * @return ShopCurrency
     */
    public function getCurrencySystem() {
        if (!$this->_currencySystem) {
            $currency = new ShopCurrency();
            $currency->setDefault(1);
            if (!$currency->select()) {
                // исключительная ситуация - нет системной валюты
                throw new ServiceUtils_Exception();
            }
            $this->_currencySystem = $currency;
        }
        return $this->_currencySystem;
    }

    /**
     * Получить массив валют
     *
     * Метод разрешено править только Senior'ам!
     *
     * @return array
     */
    public function getCurrencyArray() {
        if ($this->_currencyArray) {
            return $this->_currencyArray;
        }
        $a = array();
        $currency = $this->getCurrencyAll();
        while ($x = $currency->getNext()) {
            // Базовая валюта может быть скрыта
            if (!$x->getHidden() || $x->getDefault()) {
                $a[$x->getName()] = $x;
            }
        }
        $this->_currencyArray = $a;
        return $a;
    }

    /**
     * Конвертировать сумму
     *
     * Метод разрешено править только Senior'ам!
     *
     * @param float $sum
     * @param ShopCurrency $currencyFrom
     * @param ShopCurrency $currencyTo
     * @return float
     */
    public function convertCurrency($sum, ShopCurrency $currencyFrom, ShopCurrency $currencyTo) {
        if ($currencyFrom->getId() == $currencyTo->getId()) {
            return $sum;
        }

        return round($sum * $currencyFrom->getRate() / $currencyTo->getRate(), 2);
    }

    /**
     * Обновить валюту
     *
     * @param $currencyID
     * @param $rate
     * @param $symbol
     * @param $select
     * @param $hidden
     * @param $autoupdate
     * @throws Exception
     */
    public function updateCurrency($currencyID, $rate, $symbol, $hidden, $logicclass, $percent, $sort) {
        try {
            SQLObject::TransactionStart();

            $currency = $this->getCurrencyByID($currencyID);

            $rate = trim($rate);
            $rate = str_replace(',', '.', $rate);
            $rate = str_replace(' ', '.', $rate);
            $symbol = trim($symbol);

            $currency->setRate($rate);
            $currency->setHidden($hidden);
            $currency->setLogicclass($logicclass);
            $currency->setPercent($percent);
            $currency->setSort($sort);
            $currency->setSymbol($symbol);
            $currency->update();

            SQLObject::TransactionCommit();
        } catch(Exception $e) {
            SQLObject::TransactionRollback();
            throw $e;
        }
    }

    /**
     * Удаление валюты
     *
     * @param int $currencyID
     */
    public function deleteCurrency($currencyID) {
        try {
            SQLObject::TransactionStart();

            $currency = $this->getCurrencyByID($currencyID);
            if ($this->checkCurrencyUse($currency)) {
                throw new ServiceUtils_Exception('used');
            }

            $currency->delete();

            SQLObject::TransactionCommit();
        } catch(Exception $e) {
            SQLObject::TransactionRollback();
            throw $e;
        }
    }

    /**
     * Проверить, используется ли валюта где-либо в системе?
     * (Необходимо перед удалением)
     *
     * @param ShopCurrency $currency
     * @return bool
     */
    public function checkCurrencyUse(ShopCurrency $currency) {
        try {
            // если хотя-бы один заказ
            $orders = Shop::Get()->getShopService()->getOrdersAll();
            $orders->setCurrencyid($currency->getId());
            if ($orders->select()) {
                return true;
            }

        } catch(Exception $e) {

        }

        // по умолчанию false
        return false;
    }

    /**
     * Обновить курс валюты
     *
     * @param ShopCurrency $currency
     * @param float $rate
     */
    public function updateCurrencyRate(ShopCurrency $currency, $rate) {
        try {
            SQLObject::TransactionStart();

            $rate = str_replace(',', '.', $rate);
            $rate = str_replace(' ', '.', $rate);
            $rate = round($rate, 2);

            if ($rate && $currency->getRate() !== $rate) {
                $currency->setRate($rate);
                $currency->update();
            }

            SQLObject::TransactionCommit();
        } catch(Exception $e) {
            SQLObject::TransactionRollback();
            throw $e;
        }
    }

    /**
     * Автоматически обновить курсы валют
     */
    public function autoupdateCurrencyRates() {
        $currency = $this->getCurrencyAll();
        $currency->setDefault(0);
        $currency->addWhere('logicclass', '', '<>');

        $currencyDefault = $this->getCurrencySystem();

        while ($c = $currency->getNext()) {
            try {
                $class = $c->getLogicclass();
                if (!class_exists($class)) {
                    continue;
                }

                $object = new $class();
                $rate = $object->process($c);

                if ($rate <= 0) {
                    continue;
                }

                $rate *= (100 + $c->getPercent()) / 100;

                Shop::Get()->getCurrencyService()->updateCurrencyRate($c, $rate);

            } catch(Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }
        }
    }

    /**
     * Задать системную валюту.
     * Метод можно использовать как подмену валюты для разных сайтов.
     *
     * @param string $currencyName
     */
    public function setCurrencySystem($currencyName) {
        $curreny = $this->getCurrencyByName($currencyName);
        $this->_currencySystem = $curreny;
    }

    private $_currencySystem = null;

    private $_currencyArray = array();

}