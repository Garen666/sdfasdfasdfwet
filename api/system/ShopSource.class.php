<?php
/**
 * WebProduction Shop (wpshop)
 * @copyright (C) 2011-2014 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @copyright WebProduction
 * @package Shop
 */
class ShopSource extends XShopSource {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopSource
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return ShopSource
     */
    public static function Get($key) {
        return self::GetObject('ShopSource', $key);
    }

    public function makeName() {
        return htmlspecialchars($this->getName());
    }

}