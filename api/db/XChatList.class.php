<?php
/**
 * Class XChatList is ORM to table chatList
 * @author SQLObject
 * @package SQLObject
 */
class XChatList extends SQLObject {

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
     * Get fromUserName
     * @return string
     */
    public function getFromUserName() { return $this->getField('fromUserName');}

    /**
     * Set fromUserName
     * @param string $fromUserName
     */
    public function setFromUserName($fromUserName, $update = false) {$this->setField('fromUserName', $fromUserName, $update);}

    /**
     * Filter fromUserName
     * @param string $fromUserName
     */
    public function filterFromUserName($fromUserName) {$this->filterField('fromUserName', $fromUserName);}

    /**
     * Get time
     * @return int
     */
    public function getTime() { return $this->getField('time');}

    /**
     * Set time
     * @param int $time
     */
    public function setTime($time, $update = false) {$this->setField('time', $time, $update);}

    /**
     * Filter time
     * @param int $time
     */
    public function filterTime($time) {$this->filterField('time', $time);}

    /**
     * Get show
     * @return int
     */
    public function getShow() { return $this->getField('show');}

    /**
     * Set show
     * @param int $show
     */
    public function setShow($show, $update = false) {$this->setField('show', $show, $update);}

    /**
     * Filter show
     * @param int $show
     */
    public function filterShow($show) {$this->filterField('show', $show);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('chatList');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XChatList
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XChatList
     */
    public static function Get($key) {return self::GetObject("XChatList", $key);}

}

SQLObject::SetFieldArray('chatList', array('id', 'fromUserId', 'toUserId', 'fromUserName', 'time', 'show'));
SQLObject::SetPrimaryKey('chatList', 'id');
