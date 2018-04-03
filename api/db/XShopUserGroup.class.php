<?php
/**
 * Class XShopUserGroup is ORM to table shopusergroup
 * @author SQLObject
 * @package SQLObject
 */
class XShopUserGroup extends SQLObject {

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
     * Get group
     * @return string
     */
    public function getGroup() { return $this->getField('group');}

    /**
     * Set group
     * @param string $group
     */
    public function setGroup($group, $update = false) {$this->setField('group', $group, $update);}

    /**
     * Filter group
     * @param string $group
     */
    public function filterGroup($group) {$this->filterField('group', $group);}

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopusergroup');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopUserGroup
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopUserGroup
     */
    public static function Get($key) {return self::GetObject("XShopUserGroup", $key);}

}

SQLObject::SetFieldArray('shopusergroup', array('id', 'name', 'description', 'group', 'sort'));
SQLObject::SetPrimaryKey('shopusergroup', 'id');
