<?php
/**
 * Class XShopProductFilterValue is ORM to table shopproductfiltervalue
 * @author SQLObject
 * @package SQLObject
 */
class XShopProductFilterValue extends SQLObject {

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
     * Get filterid
     * @return int
     */
    public function getFilterid() { return $this->getField('filterid');}

    /**
     * Set filterid
     * @param int $filterid
     */
    public function setFilterid($filterid, $update = false) {$this->setField('filterid', $filterid, $update);}

    /**
     * Filter filterid
     * @param int $filterid
     */
    public function filterFilterid($filterid) {$this->filterField('filterid', $filterid);}

    /**
     * Get filtervalue
     * @return string
     */
    public function getFiltervalue() { return $this->getField('filtervalue');}

    /**
     * Set filtervalue
     * @param string $filtervalue
     */
    public function setFiltervalue($filtervalue, $update = false) {$this->setField('filtervalue', $filtervalue, $update);}

    /**
     * Filter filtervalue
     * @param string $filtervalue
     */
    public function filterFiltervalue($filtervalue) {$this->filterField('filtervalue', $filtervalue);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopproductfiltervalue');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopProductFilterValue
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopProductFilterValue
     */
    public static function Get($key) {return self::GetObject("XShopProductFilterValue", $key);}

}

SQLObject::SetFieldArray('shopproductfiltervalue', array('id', 'productid', 'filterid', 'filtervalue'));
SQLObject::SetPrimaryKey('shopproductfiltervalue', 'id');
