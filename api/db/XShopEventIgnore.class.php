<?php
/**
 * Class XShopEventIgnore is ORM to table shopeventignore
 * @author SQLObject
 * @package SQLObject
 */
class XShopEventIgnore extends SQLObject {

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
     * Get address
     * @return string
     */
    public function getAddress() { return $this->getField('address');}

    /**
     * Set address
     * @param string $address
     */
    public function setAddress($address, $update = false) {$this->setField('address', $address, $update);}

    /**
     * Filter address
     * @param string $address
     */
    public function filterAddress($address) {$this->filterField('address', $address);}

    /**
     * Get spam
     * @return int
     */
    public function getSpam() { return $this->getField('spam');}

    /**
     * Set spam
     * @param int $spam
     */
    public function setSpam($spam, $update = false) {$this->setField('spam', $spam, $update);}

    /**
     * Filter spam
     * @param int $spam
     */
    public function filterSpam($spam) {$this->filterField('spam', $spam);}

    /**
     * Get notify
     * @return int
     */
    public function getNotify() { return $this->getField('notify');}

    /**
     * Set notify
     * @param int $notify
     */
    public function setNotify($notify, $update = false) {$this->setField('notify', $notify, $update);}

    /**
     * Filter notify
     * @param int $notify
     */
    public function filterNotify($notify) {$this->filterField('notify', $notify);}

    /**
     * Get unknown
     * @return int
     */
    public function getUnknown() { return $this->getField('unknown');}

    /**
     * Set unknown
     * @param int $unknown
     */
    public function setUnknown($unknown, $update = false) {$this->setField('unknown', $unknown, $update);}

    /**
     * Filter unknown
     * @param int $unknown
     */
    public function filterUnknown($unknown) {$this->filterField('unknown', $unknown);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopeventignore');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopEventIgnore
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopEventIgnore
     */
    public static function Get($key) {return self::GetObject("XShopEventIgnore", $key);}

}

SQLObject::SetFieldArray('shopeventignore', array('id', 'address', 'spam', 'notify', 'unknown'));
SQLObject::SetPrimaryKey('shopeventignore', 'id');
