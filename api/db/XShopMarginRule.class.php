<?php
/**
 * Class XShopMarginRule is ORM to table shopmarginrule
 * @author SQLObject
 * @package SQLObject
 */
class XShopMarginRule extends SQLObject {

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
     * Get pricefrom
     * @return float
     */
    public function getPricefrom() { return $this->getField('pricefrom');}

    /**
     * Set pricefrom
     * @param float $pricefrom
     */
    public function setPricefrom($pricefrom, $update = false) {$this->setField('pricefrom', $pricefrom, $update);}

    /**
     * Filter pricefrom
     * @param float $pricefrom
     */
    public function filterPricefrom($pricefrom) {$this->filterField('pricefrom', $pricefrom);}

    /**
     * Get priceto
     * @return float
     */
    public function getPriceto() { return $this->getField('priceto');}

    /**
     * Set priceto
     * @param float $priceto
     */
    public function setPriceto($priceto, $update = false) {$this->setField('priceto', $priceto, $update);}

    /**
     * Filter priceto
     * @param float $priceto
     */
    public function filterPriceto($priceto) {$this->filterField('priceto', $priceto);}

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
     * Get supplierid
     * @return int
     */
    public function getSupplierid() { return $this->getField('supplierid');}

    /**
     * Set supplierid
     * @param int $supplierid
     */
    public function setSupplierid($supplierid, $update = false) {$this->setField('supplierid', $supplierid, $update);}

    /**
     * Filter supplierid
     * @param int $supplierid
     */
    public function filterSupplierid($supplierid) {$this->filterField('supplierid', $supplierid);}

    /**
     * Get priority
     * @return int
     */
    public function getPriority() { return $this->getField('priority');}

    /**
     * Set priority
     * @param int $priority
     */
    public function setPriority($priority, $update = false) {$this->setField('priority', $priority, $update);}

    /**
     * Filter priority
     * @param int $priority
     */
    public function filterPriority($priority) {$this->filterField('priority', $priority);}

    /**
     * Get brandid
     * @return int
     */
    public function getBrandid() { return $this->getField('brandid');}

    /**
     * Set brandid
     * @param int $brandid
     */
    public function setBrandid($brandid, $update = false) {$this->setField('brandid', $brandid, $update);}

    /**
     * Filter brandid
     * @param int $brandid
     */
    public function filterBrandid($brandid) {$this->filterField('brandid', $brandid);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopmarginrule');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopMarginRule
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopMarginRule
     */
    public static function Get($key) {return self::GetObject("XShopMarginRule", $key);}

}

SQLObject::SetFieldArray('shopmarginrule', array('id', 'name', 'pricefrom', 'priceto', 'value', 'type', 'currencyid', 'supplierid', 'priority', 'brandid'));
SQLObject::SetPrimaryKey('shopmarginrule', 'id');
