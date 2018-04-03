<?php
/**
 * Class XShopDiscount is ORM to table shopdiscount
 * @author SQLObject
 * @package SQLObject
 */
class XShopDiscount extends SQLObject {

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
     * Get name
     * @return string
     */
    public function getName() { return $this->getField('name');}

    /**
     * Set name
     * @param string $name
     */
    public function setName($name, $update = false) {$this->setField('name', $name, $update);}

    /**
     * Filter name
     * @param string $name
     */
    public function filterName($name) {$this->filterField('name', $name);}

    /**
     * Get value
     * @return float
     */
    public function getValue() { return $this->getField('value');}

    /**
     * Set value
     * @param float $value
     */
    public function setValue($value, $update = false) {$this->setField('value', $value, $update);}

    /**
     * Filter value
     * @param float $value
     */
    public function filterValue($value) {$this->filterField('value', $value);}

    /**
     * Get type
     * @return string
     */
    public function getType() { return $this->getField('type');}

    /**
     * Set type
     * @param string $type
     */
    public function setType($type, $update = false) {$this->setField('type', $type, $update);}

    /**
     * Filter type
     * @param string $type
     */
    public function filterType($type) {$this->filterField('type', $type);}

    /**
     * Get minstartsum
     * @return int
     */
    public function getMinstartsum() { return $this->getField('minstartsum');}

    /**
     * Set minstartsum
     * @param int $minstartsum
     */
    public function setMinstartsum($minstartsum, $update = false) {$this->setField('minstartsum', $minstartsum, $update);}

    /**
     * Filter minstartsum
     * @param int $minstartsum
     */
    public function filterMinstartsum($minstartsum) {$this->filterField('minstartsum', $minstartsum);}

    /**
     * Get currencyid
     * @return int
     */
    public function getCurrencyid() { return $this->getField('currencyid');}

    /**
     * Set currencyid
     * @param int $currencyid
     */
    public function setCurrencyid($currencyid, $update = false) {$this->setField('currencyid', $currencyid, $update);}

    /**
     * Filter currencyid
     * @param int $currencyid
     */
    public function filterCurrencyid($currencyid) {$this->filterField('currencyid', $currencyid);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopdiscount');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopDiscount
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopDiscount
     */
    public static function Get($key) {return self::GetObject("XShopDiscount", $key);}

}

SQLObject::SetFieldArray('shopdiscount', array('id', 'name', 'value', 'type', 'minstartsum', 'currencyid'));
SQLObject::SetPrimaryKey('shopdiscount', 'id');
