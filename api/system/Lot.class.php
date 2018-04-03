<?php

class Lot extends XLot {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return Lot
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return Lot
     */
    public static function Get($key) {
        return self::GetObject('Lot', $key);
    }

}