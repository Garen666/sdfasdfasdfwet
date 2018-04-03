<?php
/**
 * Class XShopOrderLogView is ORM to table shoporderlogview
 * @author SQLObject
 * @package SQLObject
 */
class XShopOrderLogView extends SQLObject {

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
     * Get cdate
     * @return string
     */
    public function getCdate() { return $this->getField('cdate');}

    /**
     * Set cdate
     * @param string $cdate
     */
    public function setCdate($cdate, $update = false) {$this->setField('cdate', $cdate, $update);}

    /**
     * Filter cdate
     * @param string $cdate
     */
    public function filterCdate($cdate) {$this->filterField('cdate', $cdate);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shoporderlogview');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopOrderLogView
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopOrderLogView
     */
    public static function Get($key) {return self::GetObject("XShopOrderLogView", $key);}

}

SQLObject::SetFieldArray('shoporderlogview', array('id', 'orderid', 'userid', 'cdate'));
SQLObject::SetPrimaryKey('shoporderlogview', 'id');
