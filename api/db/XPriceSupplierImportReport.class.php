<?php
/**
 * Class XPriceSupplierImportReport is ORM to table pricesupplierimportreport
 * @author SQLObject
 * @package SQLObject
 */
class XPriceSupplierImportReport extends SQLObject {

    /**
     * Get id
     * @return int
     */
    public function getId() { return $this->getField('id');}

    /**
     * Set id
     * @param int $id
     */
    public function setId($id, $update = false) {$this->setField('id', $id, $update);}

    /**
     * Filter id
     * @param int $id
     */
    public function filterId($id) {$this->filterField('id', $id);}

    /**
     * Get dateupdate
     * @return string
     */
    public function getDateupdate() { return $this->getField('dateupdate');}

    /**
     * Set dateupdate
     * @param string $dateupdate
     */
    public function setDateupdate($dateupdate, $update = false) {$this->setField('dateupdate', $dateupdate, $update);}

    /**
     * Filter dateupdate
     * @param string $dateupdate
     */
    public function filterDateupdate($dateupdate) {$this->filterField('dateupdate', $dateupdate);}

    /**
     * Get productname
     * @return string
     */
    public function getProductname() { return $this->getField('productname');}

    /**
     * Set productname
     * @param string $productname
     */
    public function setProductname($productname, $update = false) {$this->setField('productname', $productname, $update);}

    /**
     * Filter productname
     * @param string $productname
     */
    public function filterProductname($productname) {$this->filterField('productname', $productname);}

    /**
     * Get isnew
     * @return int
     */
    public function getIsnew() { return $this->getField('isnew');}

    /**
     * Set isnew
     * @param int $isnew
     */
    public function setIsnew($isnew, $update = false) {$this->setField('isnew', $isnew, $update);}

    /**
     * Filter isnew
     * @param int $isnew
     */
    public function filterIsnew($isnew) {$this->filterField('isnew', $isnew);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('pricesupplierimportreport');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XPriceSupplierImportReport
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XPriceSupplierImportReport
     */
    public static function Get($key) {return self::GetObject("XPriceSupplierImportReport", $key);}

}

SQLObject::SetFieldArray('pricesupplierimportreport', array('id', 'dateupdate', 'productname', 'isnew'));
SQLObject::SetPrimaryKey('pricesupplierimportreport', 'id');
