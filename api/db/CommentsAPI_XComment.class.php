<?php
/**
 * Class CommentsAPI_XComment is ORM to table commentsapi_comment
 * @author SQLObject
 * @package SQLObject
 */
class CommentsAPI_XComment extends SQLObject {

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
     * Get id_user
     * @return int
     */
    public function getId_user() { return $this->getField('id_user');}

    /**
     * Set id_user
     * @param int $id_user
     */
    public function setId_user($id_user, $update = false) {$this->setField('id_user', $id_user, $update);}

    /**
     * Filter id_user
     * @param int $id_user
     */
    public function filterId_user($id_user) {$this->filterField('id_user', $id_user);}

    /**
     * Get key
     * @return string
     */
    public function getKey() { return $this->getField('key');}

    /**
     * Set key
     * @param string $key
     */
    public function setKey($key, $update = false) {$this->setField('key', $key, $update);}

    /**
     * Filter key
     * @param string $key
     */
    public function filterKey($key) {$this->filterField('key', $key);}

    /**
     * Get sessionid
     * @return string
     */
    public function getSessionid() { return $this->getField('sessionid');}

    /**
     * Set sessionid
     * @param string $sessionid
     */
    public function setSessionid($sessionid, $update = false) {$this->setField('sessionid', $sessionid, $update);}

    /**
     * Filter sessionid
     * @param string $sessionid
     */
    public function filterSessionid($sessionid) {$this->filterField('sessionid', $sessionid);}

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('commentsapi_comment');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return CommentsAPI_XComment
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return CommentsAPI_XComment
     */
    public static function Get($key) {return self::GetObject("CommentsAPI_XComment", $key);}

}

SQLObject::SetFieldArray('commentsapi_comment', array('id', 'cdate', 'id_user', 'key', 'sessionid', 'ip', 'content'));
SQLObject::SetPrimaryKey('commentsapi_comment', 'id');
