<?php
/**
 * WebProduction Shop (wpshop)
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class ShopPayment extends XShopPayment {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopPayment
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return ShopPayment
     */
    public static function Get($key) {
        return self::GetObject('ShopPayment', $key);
    }

    /**
     * @param $width
     * @param $height
     * @param string $method
     * @return string
     */
    public function makeImageThumb($width, $height = false, $method = 'prop') {
        $src = MEDIA_PATH.'/shop/'.$this->getImage();
        if (!file_exists($src) || is_dir($src)) {
            return false;
        }
        return ImageProcessor_Thumber::makeThumbUniversal($src, $width, $height, $method, PROJECT_PATH);
    }

    /**
     * @return string
     */
    public function makeName() {
        return htmlspecialchars($this->getName());
    }

}