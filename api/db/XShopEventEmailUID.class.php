<?php
/**
 * Class XShopEventEmailUID is ORM to table shopeventemailuid
 * @author SQLObject
 * @package SQLObject
 */
class XShopEventEmailUID extends SQLObject {

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
     * Get imap
     * @return string
     */
    public function getImap() { return $this->getField('imap');}

    /**
     * Set imap
     * @param string $imap
     */
    public function setImap($imap, $update = false) {$this->setField('imap', $imap, $update);}

    /**
     * Filter imap
     * @param string $imap
     */
    public function filterImap($imap) {$this->filterField('imap', $imap);}

    /**
     * Get uid
     * @return string
     */
    public function getUid() { return $this->getField('uid');}

    /**
     * Set uid
     * @param string $uid
     */
    public function setUid($uid, $update = false) {$this->setField('uid', $uid, $update);}

    /**
     * Filter uid
     * @param string $uid
     */
    public function filterUid($uid) {$this->filterField('uid', $uid);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopeventemailuid');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopEventEmailUID
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopEventEmailUID
     */
    public static function Get($key) {return self::GetObject("XShopEventEmailUID", $key);}

}

SQLObject::SetFieldArray('shopeventemailuid', array('id', 'imap', 'uid'));
SQLObject::SetPrimaryKey('shopeventemailuid', 'id');
