<?php
/**
 * Class XShopUserLegal is ORM to table shopuserlegal
 * @author SQLObject
 * @package SQLObject
 */
class XShopUserLegal extends SQLObject {

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
     * Get format
     * @return string
     */
    public function getFormat() { return $this->getField('format');}

    /**
     * Set format
     * @param string $format
     */
    public function setFormat($format, $update = false) {$this->setField('format', $format, $update);}

    /**
     * Filter format
     * @param string $format
     */
    public function filterFormat($format) {$this->filterField('format', $format);}

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopuserlegal');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopUserLegal
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopUserLegal
     */
    public static function Get($key) {return self::GetObject("XShopUserLegal", $key);}

}

SQLObject::SetFieldArray('shopuserlegal', array('id', 'userid', 'format', 'name'));
SQLObject::SetPrimaryKey('shopuserlegal', 'id');
