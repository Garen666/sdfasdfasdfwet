<?php
/**
 * Class XShopProductChange is ORM to table shopproductchange
 * @author SQLObject
 * @package SQLObject
 */
class XShopProductChange extends SQLObject {

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
     * Get productid
     * @return int
     */
    public function getProductid() { return $this->getField('productid');}

    /**
     * Set productid
     * @param int $productid
     */
    public function setProductid($productid, $update = false) {$this->setField('productid', $productid, $update);}

    /**
     * Filter productid
     * @param int $productid
     */
    public function filterProductid($productid) {$this->filterField('productid', $productid);}

    /**
     * Get userid
     * @return int
     */
    public function getUserid() { return $this->getField('userid');}

    /**
     * Set userid
     * @param int $userid
     */
    public function setUserid($userid, $update = false) {$this->setField('userid', $userid, $update);}

    /**
     * Filter userid
     * @param int $userid
     */
    public function filterUserid($userid) {$this->filterField('userid', $userid);}

    /**
     * Get cdate
     * @return string
     */
    public function getCdate() { return $this->getField('cdate');}

    /**
     * Set cdate
     * @param string $cdate
     */
    public function setCdate($cdate, $update = false) {$this->setField('cdate', $cdate, $update);}

    /**
     * Filter cdate
     * @param string $cdate
     */
    public function filterCdate($cdate) {$this->filterField('cdate', $cdate);}

    /**
     * Get key
     * @return string
     */
    public function getKey() { return $this->getField('key');}

    /**
     * Set key
     * @param string $key
     */
    public function setKey($key, $update = false) {$this->setField('key', $key, $update);}

    /**
     * Filter key
     * @param string $key
     */
    public function filterKey($key) {$this->filterField('key', $key);}

    /**
     * Get valueold
     * @return string
     */
    public function getValueold() { return $this->getField('valueold');}

    /**
     * Set valueold
     * @param string $valueold
     */
    public function setValueold($valueold, $update = false) {$this->setField('valueold', $valueold, $update);}

    /**
     * Filter valueold
     * @param string $valueold
     */
    public function filterValueold($valueold) {$this->filterField('valueold', $valueold);}

    /**
     * Get valuenew
     * @return string
     */
    public function getValuenew() { return $this->getField('valuenew');}

    /**
     * Set valuenew
     * @param string $valuenew
     */
    public function setValuenew($valuenew, $update = false) {$this->setField('valuenew', $valuenew, $update);}

    /**
     * Filter valuenew
     * @param string $valuenew
     */
    public function filterValuenew($valuenew) {$this->filterField('valuenew', $valuenew);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopproductchange');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopProductChange
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopProductChange
     */
    public static function Get($key) {return self::GetObject("XShopProductChange", $key);}

}

SQLObject::SetFieldArray('shopproductchange', array('id', 'productid', 'userid', 'cdate', 'key', 'valueold', 'valuenew'));
SQLObject::SetPrimaryKey('shopproductchange', 'id');
