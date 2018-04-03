<?php
/**
 * Class XShopProductFilter is ORM to table shopproductfilter
 * @author SQLObject
 * @package SQLObject
 */
class XShopProductFilter extends SQLObject {

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
     * Get type
     * @return int
     */
    public function getType() { return $this->getField('type');}

    /**
     * Set type
     * @param int $type
     */
    public function setType($type, $update = false) {$this->setField('type', $type, $update);}

    /**
     * Filter type
     * @param int $type
     */
    public function filterType($type) {$this->filterField('type', $type);}

    /**
     * Get sorttype
     * @return int
     */
    public function getSorttype() { return $this->getField('sorttype');}

    /**
     * Set sorttype
     * @param int $sorttype
     */
    public function setSorttype($sorttype, $update = false) {$this->setField('sorttype', $sorttype, $update);}

    /**
     * Filter sorttype
     * @param int $sorttype
     */
    public function filterSorttype($sorttype) {$this->filterField('sorttype', $sorttype);}

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
        $this->setTablename('shopproductfilter');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopProductFilter
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopProductFilter
     */
    public static function Get($key) {return self::GetObject("XShopProductFilter", $key);}

}

SQLObject::SetFieldArray('shopproductfilter', array('id', 'name', 'hidden', 'sort', 'type', 'sorttype', 'linkkey'));
SQLObject::SetPrimaryKey('shopproductfilter', 'id');
