<?php
/**
 * Class XShopUserVoIPActive is ORM to table shopuservoipactive
 * @author SQLObject
 * @package SQLObject
 */
class XShopUserVoIPActive extends SQLObject {

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
     * Get number
     * @return string
     */
    public function getNumber() { return $this->getField('number');}

    /**
     * Set number
     * @param string $number
     */
    public function setNumber($number, $update = false) {$this->setField('number', $number, $update);}

    /**
     * Filter number
     * @param string $number
     */
    public function filterNumber($number) {$this->filterField('number', $number);}

    /**
     * Get contactid
     * @return int
     */
    public function getContactid() { return $this->getField('contactid');}

    /**
     * Set contactid
     * @param int $contactid
     */
    public function setContactid($contactid, $update = false) {$this->setField('contactid', $contactid, $update);}

    /**
     * Filter contactid
     * @param int $contactid
     */
    public function filterContactid($contactid) {$this->filterField('contactid', $contactid);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopuservoipactive');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopUserVoIPActive
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopUserVoIPActive
     */
    public static function Get($key) {return self::GetObject("XShopUserVoIPActive", $key);}

}

SQLObject::SetFieldArray('shopuservoipactive', array('id', 'number', 'contactid'));
SQLObject::SetPrimaryKey('shopuservoipactive', 'id');
