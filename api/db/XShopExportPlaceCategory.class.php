<?php
/**
 * Class XShopExportPlaceCategory is ORM to table shopplacecategory
 * @author SQLObject
 * @package SQLObject
 */
class XShopExportPlaceCategory extends SQLObject {

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
     * Get placeid
     * @return int
     */
    public function getPlaceid() { return $this->getField('placeid');}

    /**
     * Set placeid
     * @param int $placeid
     */
    public function setPlaceid($placeid, $update = false) {$this->setField('placeid', $placeid, $update);}

    /**
     * Filter placeid
     * @param int $placeid
     */
    public function filterPlaceid($placeid) {$this->filterField('placeid', $placeid);}

    /**
     * Get categoryid
     * @return int
     */
    public function getCategoryid() { return $this->getField('categoryid');}

    /**
     * Set categoryid
     * @param int $categoryid
     */
    public function setCategoryid($categoryid, $update = false) {$this->setField('categoryid', $categoryid, $update);}

    /**
     * Filter categoryid
     * @param int $categoryid
     */
    public function filterCategoryid($categoryid) {$this->filterField('categoryid', $categoryid);}

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
     * Get disable
     * @return int
     */
    public function getDisable() { return $this->getField('disable');}

    /**
     * Set disable
     * @param int $disable
     */
    public function setDisable($disable, $update = false) {$this->setField('disable', $disable, $update);}

    /**
     * Filter disable
     * @param int $disable
     */
    public function filterDisable($disable) {$this->filterField('disable', $disable);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopplacecategory');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopExportPlaceCategory
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopExportPlaceCategory
     */
    public static function Get($key) {return self::GetObject("XShopExportPlaceCategory", $key);}

}

SQLObject::SetFieldArray('shopplacecategory', array('id', 'placeid', 'categoryid', 'productid', 'disable'));
SQLObject::SetPrimaryKey('shopplacecategory', 'id');
