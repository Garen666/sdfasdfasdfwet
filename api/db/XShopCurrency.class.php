<?php
/**
 * Class XShopCurrency is ORM to table shopcurrency
 * @author SQLObject
 * @package SQLObject
 */
class XShopCurrency extends SQLObject {

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
     * Get symbol
     * @return string
     */
    public function getSymbol() { return $this->getField('symbol');}

    /**
     * Set symbol
     * @param string $symbol
     */
    public function setSymbol($symbol, $update = false) {$this->setField('symbol', $symbol, $update);}

    /**
     * Filter symbol
     * @param string $symbol
     */
    public function filterSymbol($symbol) {$this->filterField('symbol', $symbol);}

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
     * Get default
     * @return int
     */
    public function getDefault() { return $this->getField('default');}

    /**
     * Set default
     * @param int $default
     */
    public function setDefault($default, $update = false) {$this->setField('default', $default, $update);}

    /**
     * Filter default
     * @param int $default
     */
    public function filterDefault($default) {$this->filterField('default', $default);}

    /**
     * Get hidden
     * @return int
     */
    public function getHidden() { return $this->getField('hidden');}

    /**
     * Set hidden
     * @param int $hidden
     */
    public function setHidden($hidden, $update = false) {$this->setField('hidden', $hidden, $update);}

    /**
     * Filter hidden
     * @param int $hidden
     */
    public function filterHidden($hidden) {$this->filterField('hidden', $hidden);}

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
     * Get percent
     * @return float
     */
    public function getPercent() { return $this->getField('percent');}

    /**
     * Set percent
     * @param float $percent
     */
    public function setPercent($percent, $update = false) {$this->setField('percent', $percent, $update);}

    /**
     * Filter percent
     * @param float $percent
     */
    public function filterPercent($percent) {$this->filterField('percent', $percent);}

    /**
     * Get linkkey
     * @return string
     */
    public function getLinkkey() { return $this->getField('linkkey');}

    /**
     * Set linkkey
     * @param string $linkkey
     */
    public function setLinkkey($linkkey, $update = false) {$this->setField('linkkey', $linkkey, $update);}

    /**
     * Filter linkkey
     * @param string $linkkey
     */
    public function filterLinkkey($linkkey) {$this->filterField('linkkey', $linkkey);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopcurrency');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopCurrency
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopCurrency
     */
    public static function Get($key) {return self::GetObject("XShopCurrency", $key);}

}

SQLObject::SetFieldArray('shopcurrency', array('id', 'name', 'symbol', 'rate', 'default', 'hidden', 'sort', 'logicclass', 'percent', 'linkkey'));
SQLObject::SetPrimaryKey('shopcurrency', 'id');
