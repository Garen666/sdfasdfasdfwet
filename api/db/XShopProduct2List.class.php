<?php
/**
 * Class XShopProduct2List is ORM to table shopproduct2list
 * @author SQLObject
 * @package SQLObject
 */
class XShopProduct2List extends SQLObject {

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
     * @return string
     */
    public function getProductid() { return $this->getField('productid');}

    /**
     * Set productid
     * @param string $productid
     */
    public function setProductid($productid, $update = false) {$this->setField('productid', $productid, $update);}

    /**
     * Filter productid
     * @param string $productid
     */
    public function filterProductid($productid) {$this->filterField('productid', $productid);}

    /**
     * Get listid
     * @return int
     */
    public function getListid() { return $this->getField('listid');}

    /**
     * Set listid
     * @param int $listid
     */
    public function setListid($listid, $update = false) {$this->setField('listid', $listid, $update);}

    /**
     * Filter listid
     * @param int $listid
     */
    public function filterListid($listid) {$this->filterField('listid', $listid);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopproduct2list');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopProduct2List
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopProduct2List
     */
    public static function Get($key) {return self::GetObject("XShopProduct2List", $key);}

}

SQLObject::SetFieldArray('shopproduct2list', array('id', 'productid', 'listid'));
SQLObject::SetPrimaryKey('shopproduct2list', 'id');
