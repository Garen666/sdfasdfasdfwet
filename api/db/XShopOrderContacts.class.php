<?php
/**
 * Class XShopOrderContacts is ORM to table shopordercontacts
 * @author SQLObject
 * @package SQLObject
 */
class XShopOrderContacts extends SQLObject {

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
     * Get orderid
     * @return int
     */
    public function getOrderid() { return $this->getField('orderid');}

    /**
     * Set orderid
     * @param int $orderid
     */
    public function setOrderid($orderid, $update = false) {$this->setField('orderid', $orderid, $update);}

    /**
     * Filter orderid
     * @param int $orderid
     */
    public function filterOrderid($orderid) {$this->filterField('orderid', $orderid);}

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
     * Get comment
     * @return string
     */
    public function getComment() { return $this->getField('comment');}

    /**
     * Set comment
     * @param string $comment
     */
    public function setComment($comment, $update = false) {$this->setField('comment', $comment, $update);}

    /**
     * Filter comment
     * @param string $comment
     */
    public function filterComment($comment) {$this->filterField('comment', $comment);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopordercontacts');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopOrderContacts
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopOrderContacts
     */
    public static function Get($key) {return self::GetObject("XShopOrderContacts", $key);}

}

SQLObject::SetFieldArray('shopordercontacts', array('id', 'orderid', 'userid', 'comment'));
SQLObject::SetPrimaryKey('shopordercontacts', 'id');
