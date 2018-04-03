<?php
/**
 * Class XShopCallBack is ORM to table shopcallback
 * @author SQLObject
 * @package SQLObject
 */
class XShopCallBack extends SQLObject {

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
     * Get phone
     * @return string
     */
    public function getPhone() { return $this->getField('phone');}

    /**
     * Set phone
     * @param string $phone
     */
    public function setPhone($phone, $update = false) {$this->setField('phone', $phone, $update);}

    /**
     * Filter phone
     * @param string $phone
     */
    public function filterPhone($phone) {$this->filterField('phone', $phone);}

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
     * Get answer
     * @return string
     */
    public function getAnswer() { return $this->getField('answer');}

    /**
     * Set answer
     * @param string $answer
     */
    public function setAnswer($answer, $update = false) {$this->setField('answer', $answer, $update);}

    /**
     * Filter answer
     * @param string $answer
     */
    public function filterAnswer($answer) {$this->filterField('answer', $answer);}

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
     * Get url
     * @return string
     */
    public function getUrl() { return $this->getField('url');}

    /**
     * Set url
     * @param string $url
     */
    public function setUrl($url, $update = false) {$this->setField('url', $url, $update);}

    /**
     * Filter url
     * @param string $url
     */
    public function filterUrl($url) {$this->filterField('url', $url);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopcallback');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopCallBack
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopCallBack
     */
    public static function Get($key) {return self::GetObject("XShopCallBack", $key);}

}

SQLObject::SetFieldArray('shopcallback', array('id', 'name', 'phone', 'cdate', 'answer', 'done', 'userid', 'comment', 'url'));
SQLObject::SetPrimaryKey('shopcallback', 'id');
