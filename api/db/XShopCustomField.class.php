<?php
/**
 * Class XShopCustomField is ORM to table shopcustomfield
 * @author SQLObject
 * @package SQLObject
 */
class XShopCustomField extends SQLObject {

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
     * Get objecttype
     * @return string
     */
    public function getObjecttype() { return $this->getField('objecttype');}

    /**
     * Set objecttype
     * @param string $objecttype
     */
    public function setObjecttype($objecttype, $update = false) {$this->setField('objecttype', $objecttype, $update);}

    /**
     * Filter objecttype
     * @param string $objecttype
     */
    public function filterObjecttype($objecttype) {$this->filterField('objecttype', $objecttype);}

    /**
     * Get objectid
     * @return int
     */
    public function getObjectid() { return $this->getField('objectid');}

    /**
     * Set objectid
     * @param int $objectid
     */
    public function setObjectid($objectid, $update = false) {$this->setField('objectid', $objectid, $update);}

    /**
     * Filter objectid
     * @param int $objectid
     */
    public function filterObjectid($objectid) {$this->filterField('objectid', $objectid);}

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
     * Get value
     * @return string
     */
    public function getValue() { return $this->getField('value');}

    /**
     * Set value
     * @param string $value
     */
    public function setValue($value, $update = false) {$this->setField('value', $value, $update);}

    /**
     * Filter value
     * @param string $value
     */
    public function filterValue($value) {$this->filterField('value', $value);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopcustomfield');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopCustomField
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopCustomField
     */
    public static function Get($key) {return self::GetObject("XShopCustomField", $key);}

}

SQLObject::SetFieldArray('shopcustomfield', array('id', 'objecttype', 'objectid', 'key', 'value'));
SQLObject::SetPrimaryKey('shopcustomfield', 'id');
