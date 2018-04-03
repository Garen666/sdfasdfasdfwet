<?php
/**
 * Class XShopUser2Group is ORM to table shopuser2group
 * @author SQLObject
 * @package SQLObject
 */
class XShopUser2Group extends SQLObject {

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
     * Get groupid
     * @return int
     */
    public function getGroupid() { return $this->getField('groupid');}

    /**
     * Set groupid
     * @param int $groupid
     */
    public function setGroupid($groupid, $update = false) {$this->setField('groupid', $groupid, $update);}

    /**
     * Filter groupid
     * @param int $groupid
     */
    public function filterGroupid($groupid) {$this->filterField('groupid', $groupid);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopuser2group');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopUser2Group
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopUser2Group
     */
    public static function Get($key) {return self::GetObject("XShopUser2Group", $key);}

}

SQLObject::SetFieldArray('shopuser2group', array('id', 'userid', 'groupid'));
SQLObject::SetPrimaryKey('shopuser2group', 'id');
