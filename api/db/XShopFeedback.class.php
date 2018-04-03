<?php
/**
 * Class XShopFeedback is ORM to table shopfeedback
 * @author SQLObject
 * @package SQLObject
 */
class XShopFeedback extends SQLObject {

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
     * Get email
     * @return string
     */
    public function getEmail() { return $this->getField('email');}

    /**
     * Set email
     * @param string $email
     */
    public function setEmail($email, $update = false) {$this->setField('email', $email, $update);}

    /**
     * Filter email
     * @param string $email
     */
    public function filterEmail($email) {$this->filterField('email', $email);}

    /**
     * Get message
     * @return string
     */
    public function getMessage() { return $this->getField('message');}

    /**
     * Set message
     * @param string $message
     */
    public function setMessage($message, $update = false) {$this->setField('message', $message, $update);}

    /**
     * Filter message
     * @param string $message
     */
    public function filterMessage($message) {$this->filterField('message', $message);}

    /**
     * Get done
     * @return int
     */
    public function getDone() { return $this->getField('done');}

    /**
     * Set done
     * @param int $done
     */
    public function setDone($done, $update = false) {$this->setField('done', $done, $update);}

    /**
     * Filter done
     * @param int $done
     */
    public function filterDone($done) {$this->filterField('done', $done);}

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
     * Get pageurl
     * @return string
     */
    public function getPageurl() { return $this->getField('pageurl');}

    /**
     * Set pageurl
     * @param string $pageurl
     */
    public function setPageurl($pageurl, $update = false) {$this->setField('pageurl', $pageurl, $update);}

    /**
     * Filter pageurl
     * @param string $pageurl
     */
    public function filterPageurl($pageurl) {$this->filterField('pageurl', $pageurl);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopfeedback');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopFeedback
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopFeedback
     */
    public static function Get($key) {return self::GetObject("XShopFeedback", $key);}

}

SQLObject::SetFieldArray('shopfeedback', array('id', 'name', 'cdate', 'email', 'message', 'done', 'userid', 'pageurl'));
SQLObject::SetPrimaryKey('shopfeedback', 'id');
