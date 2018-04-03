<?php
/**
 * Class XShopGuestBook is ORM to table shopguestbook
 * @author SQLObject
 * @package SQLObject
 */
class XShopGuestBook extends SQLObject {

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
     * Get image
     * @return string
     */
    public function getImage() { return $this->getField('image');}

    /**
     * Set image
     * @param string $image
     */
    public function setImage($image, $update = false) {$this->setField('image', $image, $update);}

    /**
     * Filter image
     * @param string $image
     */
    public function filterImage($image) {$this->filterField('image', $image);}

    /**
     * Get linkkey
     * @return string
     */
    public function getLinkkey() { return $this->getField('linkkey');}

    /**
     * Set linkkey
     * @param string $linkkey
     */
    public function setLinkkey($linkkey, $update = false) {$this->setField('linkkey', $linkkey, $update);}

    /**
     * Filter linkkey
     * @param string $linkkey
     */
    public function filterLinkkey($linkkey) {$this->filterField('linkkey', $linkkey);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopguestbook');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopGuestBook
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopGuestBook
     */
    public static function Get($key) {return self::GetObject("XShopGuestBook", $key);}

}

SQLObject::SetFieldArray('shopguestbook', array('id', 'userid', 'cdate', 'text', 'done', 'name', 'image', 'linkkey'));
SQLObject::SetPrimaryKey('shopguestbook', 'id');
