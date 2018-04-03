<?php
/**
 * Class XShopUserLink is ORM to table shopuserlink
 * @author SQLObject
 * @package SQLObject
 */
class XShopUserLink extends SQLObject {

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
     * Get user1id
     * @return int
     */
    public function getUser1id() { return $this->getField('user1id');}

    /**
     * Set user1id
     * @param int $user1id
     */
    public function setUser1id($user1id, $update = false) {$this->setField('user1id', $user1id, $update);}

    /**
     * Filter user1id
     * @param int $user1id
     */
    public function filterUser1id($user1id) {$this->filterField('user1id', $user1id);}

    /**
     * Get user2id
     * @return int
     */
    public function getUser2id() { return $this->getField('user2id');}

    /**
     * Set user2id
     * @param int $user2id
     */
    public function setUser2id($user2id, $update = false) {$this->setField('user2id', $user2id, $update);}

    /**
     * Filter user2id
     * @param int $user2id
     */
    public function filterUser2id($user2id) {$this->filterField('user2id', $user2id);}

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopuserlink');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopUserLink
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopUserLink
     */
    public static function Get($key) {return self::GetObject("XShopUserLink", $key);}

}

SQLObject::SetFieldArray('shopuserlink', array('id', 'user1id', 'user2id', 'comment'));
SQLObject::SetPrimaryKey('shopuserlink', 'id');
