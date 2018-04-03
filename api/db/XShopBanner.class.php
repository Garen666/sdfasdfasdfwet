<?php
/**
 * Class XShopBanner is ORM to table shopbanner
 * @author SQLObject
 * @package SQLObject
 */
class XShopBanner extends SQLObject {

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
     * Get hidden
     * @return int
     */
    public function getHidden() { return $this->getField('hidden');}

    /**
     * Set hidden
     * @param int $hidden
     */
    public function setHidden($hidden, $update = false) {$this->setField('hidden', $hidden, $update);}

    /**
     * Filter hidden
     * @param int $hidden
     */
    public function filterHidden($hidden) {$this->filterField('hidden', $hidden);}

    /**
     * Get place
     * @return string
     */
    public function getPlace() { return $this->getField('place');}

    /**
     * Set place
     * @param string $place
     */
    public function setPlace($place, $update = false) {$this->setField('place', $place, $update);}

    /**
     * Filter place
     * @param string $place
     */
    public function filterPlace($place) {$this->filterField('place', $place);}

    /**
     * Get onlyindex
     * @return int
     */
    public function getOnlyindex() { return $this->getField('onlyindex');}

    /**
     * Set onlyindex
     * @param int $onlyindex
     */
    public function setOnlyindex($onlyindex, $update = false) {$this->setField('onlyindex', $onlyindex, $update);}

    /**
     * Filter onlyindex
     * @param int $onlyindex
     */
    public function filterOnlyindex($onlyindex) {$this->filterField('onlyindex', $onlyindex);}

    /**
     * Get sort
     * @return int
     */
    public function getSort() { return $this->getField('sort');}

    /**
     * Set sort
     * @param int $sort
     */
    public function setSort($sort, $update = false) {$this->setField('sort', $sort, $update);}

    /**
     * Filter sort
     * @param int $sort
     */
    public function filterSort($sort) {$this->filterField('sort', $sort);}

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
     * Get categoryid
     * @return int
     */
    public function getCategoryid() { return $this->getField('categoryid');}

    /**
     * Set categoryid
     * @param int $categoryid
     */
    public function setCategoryid($categoryid, $update = false) {$this->setField('categoryid', $categoryid, $update);}

    /**
     * Filter categoryid
     * @param int $categoryid
     */
    public function filterCategoryid($categoryid) {$this->filterField('categoryid', $categoryid);}

    /**
     * Get sdate
     * @return string
     */
    public function getSdate() { return $this->getField('sdate');}

    /**
     * Set sdate
     * @param string $sdate
     */
    public function setSdate($sdate, $update = false) {$this->setField('sdate', $sdate, $update);}

    /**
     * Filter sdate
     * @param string $sdate
     */
    public function filterSdate($sdate) {$this->filterField('sdate', $sdate);}

    /**
     * Get edate
     * @return string
     */
    public function getEdate() { return $this->getField('edate');}

    /**
     * Set edate
     * @param string $edate
     */
    public function setEdate($edate, $update = false) {$this->setField('edate', $edate, $update);}

    /**
     * Filter edate
     * @param string $edate
     */
    public function filterEdate($edate) {$this->filterField('edate', $edate);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopbanner');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopBanner
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopBanner
     */
    public static function Get($key) {return self::GetObject("XShopBanner", $key);}

}

SQLObject::SetFieldArray('shopbanner', array('id', 'name', 'image', 'url', 'hidden', 'place', 'onlyindex', 'sort', 'comment', 'linkkey', 'categoryid', 'sdate', 'edate'));
SQLObject::SetPrimaryKey('shopbanner', 'id');
