<?php
/**
 * Class XShopNews is ORM to table shopnews
 * @author SQLObject
 * @package SQLObject
 */
class XShopNews extends SQLObject {

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
     * Get contentpreview
     * @return string
     */
    public function getContentpreview() { return $this->getField('contentpreview');}

    /**
     * Set contentpreview
     * @param string $contentpreview
     */
    public function setContentpreview($contentpreview, $update = false) {$this->setField('contentpreview', $contentpreview, $update);}

    /**
     * Filter contentpreview
     * @param string $contentpreview
     */
    public function filterContentpreview($contentpreview) {$this->filterField('contentpreview', $contentpreview);}

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
     * Get seodescription
     * @return string
     */
    public function getSeodescription() { return $this->getField('seodescription');}

    /**
     * Set seodescription
     * @param string $seodescription
     */
    public function setSeodescription($seodescription, $update = false) {$this->setField('seodescription', $seodescription, $update);}

    /**
     * Filter seodescription
     * @param string $seodescription
     */
    public function filterSeodescription($seodescription) {$this->filterField('seodescription', $seodescription);}

    /**
     * Get seotitle
     * @return string
     */
    public function getSeotitle() { return $this->getField('seotitle');}

    /**
     * Set seotitle
     * @param string $seotitle
     */
    public function setSeotitle($seotitle, $update = false) {$this->setField('seotitle', $seotitle, $update);}

    /**
     * Filter seotitle
     * @param string $seotitle
     */
    public function filterSeotitle($seotitle) {$this->filterField('seotitle', $seotitle);}

    /**
     * Get seoh1
     * @return string
     */
    public function getSeoh1() { return $this->getField('seoh1');}

    /**
     * Set seoh1
     * @param string $seoh1
     */
    public function setSeoh1($seoh1, $update = false) {$this->setField('seoh1', $seoh1, $update);}

    /**
     * Filter seoh1
     * @param string $seoh1
     */
    public function filterSeoh1($seoh1) {$this->filterField('seoh1', $seoh1);}

    /**
     * Get seocontent
     * @return string
     */
    public function getSeocontent() { return $this->getField('seocontent');}

    /**
     * Set seocontent
     * @param string $seocontent
     */
    public function setSeocontent($seocontent, $update = false) {$this->setField('seocontent', $seocontent, $update);}

    /**
     * Filter seocontent
     * @param string $seocontent
     */
    public function filterSeocontent($seocontent) {$this->filterField('seocontent', $seocontent);}

    /**
     * Get seokeywords
     * @return string
     */
    public function getSeokeywords() { return $this->getField('seokeywords');}

    /**
     * Set seokeywords
     * @param string $seokeywords
     */
    public function setSeokeywords($seokeywords, $update = false) {$this->setField('seokeywords', $seokeywords, $update);}

    /**
     * Filter seokeywords
     * @param string $seokeywords
     */
    public function filterSeokeywords($seokeywords) {$this->filterField('seokeywords', $seokeywords);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopnews');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopNews
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopNews
     */
    public static function Get($key) {return self::GetObject("XShopNews", $key);}

}

SQLObject::SetFieldArray('shopnews', array('id', 'cdate', 'hidden', 'name', 'image', 'contentpreview', 'content', 'productid', 'categoryid', 'url', 'seodescription', 'seotitle', 'seoh1', 'seocontent', 'seokeywords'));
SQLObject::SetPrimaryKey('shopnews', 'id');
