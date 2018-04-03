<?php
/**
 * Class XShopUserLegalData is ORM to table shopuserlegaldata
 * @author SQLObject
 * @package SQLObject
 */
class XShopUserLegalData extends SQLObject {

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
     * Get legalid
     * @return int
     */
    public function getLegalid() { return $this->getField('legalid');}

    /**
     * Set legalid
     * @param int $legalid
     */
    public function setLegalid($legalid, $update = false) {$this->setField('legalid', $legalid, $update);}

    /**
     * Filter legalid
     * @param int $legalid
     */
    public function filterLegalid($legalid) {$this->filterField('legalid', $legalid);}

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
        $this->setTablename('shopuserlegaldata');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopUserLegalData
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopUserLegalData
     */
    public static function Get($key) {return self::GetObject("XShopUserLegalData", $key);}

}

SQLObject::SetFieldArray('shopuserlegaldata', array('id', 'legalid', 'key', 'name', 'value'));
SQLObject::SetPrimaryKey('shopuserlegaldata', 'id');
