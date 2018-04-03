<?php
/**
 * Class XShopDelivery is ORM to table shopdelivery
 * @author SQLObject
 * @package SQLObject
 */
class XShopDelivery extends SQLObject {

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
     * Get description
     * @return string
     */
    public function getDescription() { return $this->getField('description');}

    /**
     * Set description
     * @param string $description
     */
    public function setDescription($description, $update = false) {$this->setField('description', $description, $update);}

    /**
     * Filter description
     * @param string $description
     */
    public function filterDescription($description) {$this->filterField('description', $description);}

    /**
     * Get image
     * @return string
     */
    public function getImage() { return $this->getField('image');}

    /**
     * Set image
     * @param string $image
     */
    public function setImage($image, $update = false) {$this->setField('image', $image, $update);}

    /**
     * Filter image
     * @param string $image
     */
    public function filterImage($image) {$this->filterField('image', $image);}

    /**
     * Get price
     * @return float
     */
    public function getPrice() { return $this->getField('price');}

    /**
     * Set price
     * @param float $price
     */
    public function setPrice($price, $update = false) {$this->setField('price', $price, $update);}

    /**
     * Filter price
     * @param float $price
     */
    public function filterPrice($price) {$this->filterField('price', $price);}

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
     * Get sort
     * @return int
     */
    public function getSort() { return $this->getField('sort');}

    /**
     * Set sort
     * @param int $sort
     */
    public function setSort($sort, $update = false) {$this->setField('sort', $sort, $update);}

    /**
     * Filter sort
     * @param int $sort
     */
    public function filterSort($sort) {$this->filterField('sort', $sort);}

    /**
     * Get needcity
     * @return int
     */
    public function getNeedcity() { return $this->getField('needcity');}

    /**
     * Set needcity
     * @param int $needcity
     */
    public function setNeedcity($needcity, $update = false) {$this->setField('needcity', $needcity, $update);}

    /**
     * Filter needcity
     * @param int $needcity
     */
    public function filterNeedcity($needcity) {$this->filterField('needcity', $needcity);}

    /**
     * Get needaddress
     * @return int
     */
    public function getNeedaddress() { return $this->getField('needaddress');}

    /**
     * Set needaddress
     * @param int $needaddress
     */
    public function setNeedaddress($needaddress, $update = false) {$this->setField('needaddress', $needaddress, $update);}

    /**
     * Filter needaddress
     * @param int $needaddress
     */
    public function filterNeedaddress($needaddress) {$this->filterField('needaddress', $needaddress);}

    /**
     * Get needcountry
     * @return int
     */
    public function getNeedcountry() { return $this->getField('needcountry');}

    /**
     * Set needcountry
     * @param int $needcountry
     */
    public function setNeedcountry($needcountry, $update = false) {$this->setField('needcountry', $needcountry, $update);}

    /**
     * Filter needcountry
     * @param int $needcountry
     */
    public function filterNeedcountry($needcountry) {$this->filterField('needcountry', $needcountry);}

    /**
     * Get paydelivery
     * @return int
     */
    public function getPaydelivery() { return $this->getField('paydelivery');}

    /**
     * Set paydelivery
     * @param int $paydelivery
     */
    public function setPaydelivery($paydelivery, $update = false) {$this->setField('paydelivery', $paydelivery, $update);}

    /**
     * Filter paydelivery
     * @param int $paydelivery
     */
    public function filterPaydelivery($paydelivery) {$this->filterField('paydelivery', $paydelivery);}

    /**
     * Get logicclass
     * @return string
     */
    public function getLogicclass() { return $this->getField('logicclass');}

    /**
     * Set logicclass
     * @param string $logicclass
     */
    public function setLogicclass($logicclass, $update = false) {$this->setField('logicclass', $logicclass, $update);}

    /**
     * Filter logicclass
     * @param string $logicclass
     */
    public function filterLogicclass($logicclass) {$this->filterField('logicclass', $logicclass);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopdelivery');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopDelivery
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopDelivery
     */
    public static function Get($key) {return self::GetObject("XShopDelivery", $key);}

}

SQLObject::SetFieldArray('shopdelivery', array('id', 'name', 'description', 'image', 'price', 'currencyid', 'sort', 'needcity', 'needaddress', 'needcountry', 'paydelivery', 'logicclass'));
SQLObject::SetPrimaryKey('shopdelivery', 'id');
