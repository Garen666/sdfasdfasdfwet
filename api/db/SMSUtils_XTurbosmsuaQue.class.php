<?php
/**
 * Class SMSUtils_XTurbosmsuaQue is ORM to table smsutils_que
 * @author SQLObject
 * @package SQLObject
 */
class SMSUtils_XTurbosmsuaQue extends SQLObject {

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
     * Get sender
     * @return string
     */
    public function getSender() { return $this->getField('sender');}

    /**
     * Set sender
     * @param string $sender
     */
    public function setSender($sender, $update = false) {$this->setField('sender', $sender, $update);}

    /**
     * Filter sender
     * @param string $sender
     */
    public function filterSender($sender) {$this->filterField('sender', $sender);}

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
     * Get content
     * @return string
     */
    public function getContent() { return $this->getField('content');}

    /**
     * Set content
     * @param string $content
     */
    public function setContent($content, $update = false) {$this->setField('content', $content, $update);}

    /**
     * Filter content
     * @param string $content
     */
    public function filterContent($content) {$this->filterField('content', $content);}

    /**
     * Get result
     * @return string
     */
    public function getResult() { return $this->getField('result');}

    /**
     * Set result
     * @param string $result
     */
    public function setResult($result, $update = false) {$this->setField('result', $result, $update);}

    /**
     * Filter result
     * @param string $result
     */
    public function filterResult($result) {$this->filterField('result', $result);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('smsutils_que');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return SMSUtils_XTurbosmsuaQue
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return SMSUtils_XTurbosmsuaQue
     */
    public static function Get($key) {return self::GetObject("SMSUtils_XTurbosmsuaQue", $key);}

}

SQLObject::SetFieldArray('smsutils_que', array('id', 'cdate', 'status', 'pdate', 'sender', 'to', 'content', 'result'));
SQLObject::SetPrimaryKey('smsutils_que', 'id');
