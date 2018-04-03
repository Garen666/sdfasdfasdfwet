<?php
/**
 * Class MailUtils_XQue is ORM to table mailutils_que
 * @author SQLObject
 * @package SQLObject
 */
class MailUtils_XQue extends SQLObject {

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
     * Get status
     * @return int
     */
    public function getStatus() { return $this->getField('status');}

    /**
     * Set status
     * @param int $status
     */
    public function setStatus($status, $update = false) {$this->setField('status', $status, $update);}

    /**
     * Filter status
     * @param int $status
     */
    public function filterStatus($status) {$this->filterField('status', $status);}

    /**
     * Get sdate
     * @return string
     */
    public function getSdate() { return $this->getField('sdate');}

    /**
     * Set sdate
     * @param string $sdate
     */
    public function setSdate($sdate, $update = false) {$this->setField('sdate', $sdate, $update);}

    /**
     * Filter sdate
     * @param string $sdate
     */
    public function filterSdate($sdate) {$this->filterField('sdate', $sdate);}

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
     * Get ip
     * @return string
     */
    public function getIp() { return $this->getField('ip');}

    /**
     * Set ip
     * @param string $ip
     */
    public function setIp($ip, $update = false) {$this->setField('ip', $ip, $update);}

    /**
     * Filter ip
     * @param string $ip
     */
    public function filterIp($ip) {$this->filterField('ip', $ip);}

    /**
     * Get from
     * @return string
     */
    public function getFrom() { return $this->getField('from');}

    /**
     * Set from
     * @param string $from
     */
    public function setFrom($from, $update = false) {$this->setField('from', $from, $update);}

    /**
     * Filter from
     * @param string $from
     */
    public function filterFrom($from) {$this->filterField('from', $from);}

    /**
     * Get to
     * @return string
     */
    public function getTo() { return $this->getField('to');}

    /**
     * Set to
     * @param string $to
     */
    public function setTo($to, $update = false) {$this->setField('to', $to, $update);}

    /**
     * Filter to
     * @param string $to
     */
    public function filterTo($to) {$this->filterField('to', $to);}

    /**
     * Get subject
     * @return string
     */
    public function getSubject() { return $this->getField('subject');}

    /**
     * Set subject
     * @param string $subject
     */
    public function setSubject($subject, $update = false) {$this->setField('subject', $subject, $update);}

    /**
     * Filter subject
     * @param string $subject
     */
    public function filterSubject($subject) {$this->filterField('subject', $subject);}

    /**
     * Get body
     * @return string
     */
    public function getBody() { return $this->getField('body');}

    /**
     * Set body
     * @param string $body
     */
    public function setBody($body, $update = false) {$this->setField('body', $body, $update);}

    /**
     * Filter body
     * @param string $body
     */
    public function filterBody($body) {$this->filterField('body', $body);}

    /**
     * Get bodytype
     * @return string
     */
    public function getBodytype() { return $this->getField('bodytype');}

    /**
     * Set bodytype
     * @param string $bodytype
     */
    public function setBodytype($bodytype, $update = false) {$this->setField('bodytype', $bodytype, $update);}

    /**
     * Filter bodytype
     * @param string $bodytype
     */
    public function filterBodytype($bodytype) {$this->filterField('bodytype', $bodytype);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('mailutils_que');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return MailUtils_XQue
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return MailUtils_XQue
     */
    public static function Get($key) {return self::GetObject("MailUtils_XQue", $key);}

}

SQLObject::SetFieldArray('mailutils_que', array('id', 'cdate', 'status', 'sdate', 'pdate', 'ip', 'from', 'to', 'subject', 'body', 'bodytype'));
SQLObject::SetPrimaryKey('mailutils_que', 'id');
