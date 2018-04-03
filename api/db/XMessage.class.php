<?php
/**
 * Class XMessage is ORM to table messages
 * @author SQLObject
 * @package SQLObject
 */
class XMessage extends SQLObject {

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
     * Get fromUserId
     * @return int
     */
    public function getFromUserId() { return $this->getField('fromUserId');}

    /**
     * Set fromUserId
     * @param int $fromUserId
     */
    public function setFromUserId($fromUserId, $update = false) {$this->setField('fromUserId', $fromUserId, $update);}

    /**
     * Filter fromUserId
     * @param int $fromUserId
     */
    public function filterFromUserId($fromUserId) {$this->filterField('fromUserId', $fromUserId);}

    /**
     * Get toUserId
     * @return int
     */
    public function getToUserId() { return $this->getField('toUserId');}

    /**
     * Set toUserId
     * @param int $toUserId
     */
    public function setToUserId($toUserId, $update = false) {$this->setField('toUserId', $toUserId, $update);}

    /**
     * Filter toUserId
     * @param int $toUserId
     */
    public function filterToUserId($toUserId) {$this->filterField('toUserId', $toUserId);}

    /**
     * Get text
     * @return string
     */
    public function getText() { return $this->getField('text');}

    /**
     * Set text
     * @param string $text
     */
    public function setText($text, $update = false) {$this->setField('text', $text, $update);}

    /**
     * Filter text
     * @param string $text
     */
    public function filterText($text) {$this->filterField('text', $text);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('messages');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XMessage
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XMessage
     */
    public static function Get($key) {return self::GetObject("XMessage", $key);}

}

SQLObject::SetFieldArray('messages', array('id', 'cdate', 'fromUserId', 'toUserId', 'text'));
SQLObject::SetPrimaryKey('messages', 'id');
