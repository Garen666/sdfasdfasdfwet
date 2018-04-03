<?php
/**
 * Class XShopRole is ORM to table shoprole
 * @author SQLObject
 * @package SQLObject
 */
class XShopRole extends SQLObject {

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
     * Get parentid
     * @return int
     */
    public function getParentid() { return $this->getField('parentid');}

    /**
     * Set parentid
     * @param int $parentid
     */
    public function setParentid($parentid, $update = false) {$this->setField('parentid', $parentid, $update);}

    /**
     * Filter parentid
     * @param int $parentid
     */
    public function filterParentid($parentid) {$this->filterField('parentid', $parentid);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shoprole');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopRole
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopRole
     */
    public static function Get($key) {return self::GetObject("XShopRole", $key);}

}

SQLObject::SetFieldArray('shoprole', array('id', 'name', 'description', 'parentid'));
SQLObject::SetPrimaryKey('shoprole', 'id');