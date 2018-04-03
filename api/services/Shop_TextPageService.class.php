<?php
/**
 * WebProduction Shop (OneClick)
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Shop_TextPageService extends ServiceUtils_AbstractService {

    /**
     * @return ShopTextPage
     */
    public function getTextPageAll() {
        $x = new ShopTextPage();
        $x->setOrder('sort', 'ASC');
        return $x;
    }

    /**
     * Получить массив всех активных страниц
     *
     * @return array
     */
    public function getTextPageArray() {
        if ($this->_textpageArray === false) {
            // initialization of text pages array
            $this->_textpageArray = array();
            $textpage = $this->getTextPageAll();
            while ($x = $textpage->getNext()) {
                $this->_textpageArray[] = $x;
            }
        }
        return $this->_textpageArray;
    }

    /**
     * @return ShopTextPage
     */
    public function getTextPageByID($id) {
        return $this->getObjectByID($id, 'ShopTextPage');
    }

    /**
     * @return ShopTextPage
     */
    public function getTextPageByParentID($parentid) {
        return $this->getObjectByField('parentid', $parentid, 'ShopTextPage');
    }

    /**
     * @return ShopTextPage
     */
    public function getTextPageByKey($key) {
        $a = $this->getTextPageArray();

        foreach ($a as $x) {
            if ($x->getKey() == $key) {
                return $x;
            }
        }

        throw new ServiceUtils_Exception();
    }

    /**
     * @return ShopTextPage
     */
    public function getTextPageByLogicclass($logicclass) {
        $a = $this->getTextPageArray();

        foreach ($a as $x) {
            if ($x->getLogicclass() == $logicclass) {
                return $x;
            }
        }

        throw new ServiceUtils_Exception();
    }

    /**
     * Найти станицу по URL-префиксу
     *
     * @param string $url
     * @return ShopTextPage
     */
    public function getTextPageByURL($url) {
        $url = trim($url);
        if (!$url) {
            throw new ServiceUtils_Exception();
        }
        return $this->getObjectByField('url', $url, 'ShopTextPage', false);
    }

    private $_textpageArray = false;

}