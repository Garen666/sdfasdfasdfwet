<?php
/**
 * Class XShopExport is ORM to table shopexport
 * @author SQLObject
 * @package SQLObject
 */
class XShopExport extends SQLObject {

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
     * Get pdate
     * @return string
     */
    public function getPdate() { return $this->getField('pdate');}

    /**
     * Set pdate
     * @param string $pdate
     */
    public function setPdate($pdate, $update = false) {$this->setField('pdate', $pdate, $update);}

    /**
     * Filter pdate
     * @param string $pdate
     */
    public function filterPdate($pdate) {$this->filterField('pdate', $pdate);}

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
     * Get categoryid
     * @return int
     */
    public function getCategoryid() { return $this->getField('categoryid');}

    /**
     * Set categoryid
     * @param int $categoryid
     */
    public function setCategoryid($categoryid, $update = false) {$this->setField('categoryid', $categoryid, $update);}

    /**
     * Filter categoryid
     * @param int $categoryid
     */
    public function filterCategoryid($categoryid) {$this->filterField('categoryid', $categoryid);}

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
     * Get emails
     * @return string
     */
    public function getEmails() { return $this->getField('emails');}

    /**
     * Set emails
     * @param string $emails
     */
    public function setEmails($emails, $update = false) {$this->setField('emails', $emails, $update);}

    /**
     * Filter emails
     * @param string $emails
     */
    public function filterEmails($emails) {$this->filterField('emails', $emails);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopexport');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopExport
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopExport
     */
    public static function Get($key) {return self::GetObject("XShopExport", $key);}

}

SQLObject::SetFieldArray('shopexport', array('id', 'cdate', 'pdate', 'userid', 'categoryid', 'comment', 'emails'));
SQLObject::SetPrimaryKey('shopexport', 'id');
