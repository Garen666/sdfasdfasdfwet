<?php
/**
 * Class XShopTax is ORM to table shoptax
 * @author SQLObject
 * @package SQLObject
 */
class XShopTax extends SQLObject {

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
     * Get rate
     * @return float
     */
    public function getRate() { return $this->getField('rate');}

    /**
     * Set rate
     * @param float $rate
     */
    public function setRate($rate, $update = false) {$this->setField('rate', $rate, $update);}

    /**
     * Filter rate
     * @param float $rate
     */
    public function filterRate($rate) {$this->filterField('rate', $rate);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shoptax');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopTax
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopTax
     */
    public static function Get($key) {return self::GetObject("XShopTax", $key);}

}

SQLObject::SetFieldArray('shoptax', array('id', 'name', 'rate'));
SQLObject::SetPrimaryKey('shoptax', 'id');
