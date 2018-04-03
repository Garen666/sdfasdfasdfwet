<?php
/**
 * Class XShopHistory is ORM to table shophistory
 * @author SQLObject
 * @package SQLObject
 */
class XShopHistory extends SQLObject {

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
     * Get post
     * @return string
     */
    public function getPost() { return $this->getField('post');}

    /**
     * Set post
     * @param string $post
     */
    public function setPost($post, $update = false) {$this->setField('post', $post, $update);}

    /**
     * Filter post
     * @param string $post
     */
    public function filterPost($post) {$this->filterField('post', $post);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shophistory');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopHistory
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopHistory
     */
    public static function Get($key) {return self::GetObject("XShopHistory", $key);}

}

SQLObject::SetFieldArray('shophistory', array('id', 'userid', 'cdate', 'url', 'post'));
SQLObject::SetPrimaryKey('shophistory', 'id');
