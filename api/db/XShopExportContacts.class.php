<?php
/**
 * Class XShopExportContacts is ORM to table shopexportcontacts
 * @author SQLObject
 * @package SQLObject
 */
class XShopExportContacts extends SQLObject {

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
     * Get companyname
     * @return string
     */
    public function getCompanyname() { return $this->getField('companyname');}

    /**
     * Set companyname
     * @param string $companyname
     */
    public function setCompanyname($companyname, $update = false) {$this->setField('companyname', $companyname, $update);}

    /**
     * Filter companyname
     * @param string $companyname
     */
    public function filterCompanyname($companyname) {$this->filterField('companyname', $companyname);}

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
        $this->setTablename('shopexportcontacts');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopExportContacts
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopExportContacts
     */
    public static function Get($key) {return self::GetObject("XShopExportContacts", $key);}

}

SQLObject::SetFieldArray('shopexportcontacts', array('id', 'cdate', 'pdate', 'userid', 'companyname', 'comment', 'emails'));
SQLObject::SetPrimaryKey('shopexportcontacts', 'id');
