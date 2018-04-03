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
class ShopUserGroup extends XShopUserGroup {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopUserGroup
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return ShopUserGroup
     */
    public static function Get($key) {
        return self::GetObject('ShopUserGroup', $key);
    }

}