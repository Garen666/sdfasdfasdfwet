<?php
/**
 * Class XChat is ORM to table chat
 * @author SQLObject
 * @package SQLObject
 */
class XChat extends SQLObject {

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
     * Get chatListId
     * @return int
     */
    public function getChatListId() { return $this->getField('chatListId');}

    /**
     * Set chatListId
     * @param int $chatListId
     */
    public function setChatListId($chatListId, $update = false) {$this->setField('chatListId', $chatListId, $update);}

    /**
     * Filter chatListId
     * @param int $chatListId
     */
    public function filterChatListId($chatListId) {$this->filterField('chatListId', $chatListId);}

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
     * Get toUserName
     * @return string
     */
    public function getToUserName() { return $this->getField('toUserName');}

    /**
     * Set toUserName
     * @param string $toUserName
     */
    public function setToUserName($toUserName, $update = false) {$this->setField('toUserName', $toUserName, $update);}

    /**
     * Filter toUserName
     * @param string $toUserName
     */
    public function filterToUserName($toUserName) {$this->filterField('toUserName', $toUserName);}

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('chat');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XChat
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XChat
     */
    public static function Get($key) {return self::GetObject("XChat", $key);}

}

SQLObject::SetFieldArray('chat', array('id', 'cdate', 'chatListId', 'fromUserName', 'toUserName', 'show', 'message'));
SQLObject::SetPrimaryKey('chat', 'id');
