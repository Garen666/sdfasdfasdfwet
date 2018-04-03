<?php
/**
 * Class XShopReletedCategory is ORM to table shopreletedcategory
 * @author SQLObject
 * @package SQLObject
 */
class XShopReletedCategory extends SQLObject {

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
     * Get reletedcategoryid
     * @return int
     */
    public function getReletedcategoryid() { return $this->getField('reletedcategoryid');}

    /**
     * Set reletedcategoryid
     * @param int $reletedcategoryid
     */
    public function setReletedcategoryid($reletedcategoryid, $update = false) {$this->setField('reletedcategoryid', $reletedcategoryid, $update);}

    /**
     * Filter reletedcategoryid
     * @param int $reletedcategoryid
     */
    public function filterReletedcategoryid($reletedcategoryid) {$this->filterField('reletedcategoryid', $reletedcategoryid);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopreletedcategory');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopReletedCategory
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopReletedCategory
     */
    public static function Get($key) {return self::GetObject("XShopReletedCategory", $key);}

}

SQLObject::SetFieldArray('shopreletedcategory', array('id', 'categoryid', 'reletedcategoryid'));
SQLObject::SetPrimaryKey('shopreletedcategory', 'id');
