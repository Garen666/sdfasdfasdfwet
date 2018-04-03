<?php
/**
 * Class XShopOrderCategory is ORM to table shopordercategory
 * @author SQLObject
 * @package SQLObject
 */
class XShopOrderCategory extends SQLObject {

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopordercategory');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopOrderCategory
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopOrderCategory
     */
    public static function Get($key) {return self::GetObject("XShopOrderCategory", $key);}

}

SQLObject::SetFieldArray('shopordercategory', array('id', 'name', 'default', 'hidden'));
SQLObject::SetPrimaryKey('shopordercategory', 'id');
