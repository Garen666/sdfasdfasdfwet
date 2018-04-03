<?php
/**
 * Class XShopProductComment is ORM to table shopproductcomment
 * @author SQLObject
 * @package SQLObject
 */
class XShopProductComment extends SQLObject {

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
     * Get productid
     * @return int
     */
    public function getProductid() { return $this->getField('productid');}

    /**
     * Set productid
     * @param int $productid
     */
    public function setProductid($productid, $update = false) {$this->setField('productid', $productid, $update);}

    /**
     * Filter productid
     * @param int $productid
     */
    public function filterProductid($productid) {$this->filterField('productid', $productid);}

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
     * Get rating
     * @return int
     */
    public function getRating() { return $this->getField('rating');}

    /**
     * Set rating
     * @param int $rating
     */
    public function setRating($rating, $update = false) {$this->setField('rating', $rating, $update);}

    /**
     * Filter rating
     * @param int $rating
     */
    public function filterRating($rating) {$this->filterField('rating', $rating);}

    /**
     * Get plus
     * @return string
     */
    public function getPlus() { return $this->getField('plus');}

    /**
     * Set plus
     * @param string $plus
     */
    public function setPlus($plus, $update = false) {$this->setField('plus', $plus, $update);}

    /**
     * Filter plus
     * @param string $plus
     */
    public function filterPlus($plus) {$this->filterField('plus', $plus);}

    /**
     * Get minus
     * @return string
     */
    public function getMinus() { return $this->getField('minus');}

    /**
     * Set minus
     * @param string $minus
     */
    public function setMinus($minus, $update = false) {$this->setField('minus', $minus, $update);}

    /**
     * Filter minus
     * @param string $minus
     */
    public function filterMinus($minus) {$this->filterField('minus', $minus);}

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
     * Get username
     * @return string
     */
    public function getUsername() { return $this->getField('username');}

    /**
     * Set username
     * @param string $username
     */
    public function setUsername($username, $update = false) {$this->setField('username', $username, $update);}

    /**
     * Filter username
     * @param string $username
     */
    public function filterUsername($username) {$this->filterField('username', $username);}

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopproductcomment');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopProductComment
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopProductComment
     */
    public static function Get($key) {return self::GetObject("XShopProductComment", $key);}

}

SQLObject::SetFieldArray('shopproductcomment', array('id', 'productid', 'userid', 'text', 'cdate', 'rating', 'plus', 'minus', 'image', 'username', 'answer'));
SQLObject::SetPrimaryKey('shopproductcomment', 'id');
