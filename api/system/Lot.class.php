<?php

class Lot extends XLot {


    public function getGame() {
        return Shop::Get()->getGameService()->getGameByID($this->getGameId());
    }

    public function getLotType() {
        return Shop::Get()->getLotTypeService()->getLotTypeByID($this->getLotTypeId());
    }

    public function getFiltersArray () {
        $filterArray = array();
        for ($i = 1; $i<=5; $i++) {
            $filterId = $this->getField('filterId'.$i);
            $filterValue = $this->getField('filterValue'.$i);

            if ($filterId && $filterValue) {
                $filterArray[$filterId] = $filterValue;
            }
        }

        return $filterArray;
    }

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