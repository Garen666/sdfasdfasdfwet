<?php
/**
 * Class XShopProduct is ORM to table shopproduct
 * @author SQLObject
 * @package SQLObject
 */
class XShopProduct extends SQLObject {

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
     * Get description
     * @return string
     */
    public function getDescription() { return $this->getField('description');}

    /**
     * Set description
     * @param string $description
     */
    public function setDescription($description, $update = false) {$this->setField('description', $description, $update);}

    /**
     * Filter description
     * @param string $description
     */
    public function filterDescription($description) {$this->filterField('description', $description);}

    /**
     * Get tags
     * @return string
     */
    public function getTags() { return $this->getField('tags');}

    /**
     * Set tags
     * @param string $tags
     */
    public function setTags($tags, $update = false) {$this->setField('tags', $tags, $update);}

    /**
     * Filter tags
     * @param string $tags
     */
    public function filterTags($tags) {$this->filterField('tags', $tags);}

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
     * Get deleted
     * @return int
     */
    public function getDeleted() { return $this->getField('deleted');}

    /**
     * Set deleted
     * @param int $deleted
     */
    public function setDeleted($deleted, $update = false) {$this->setField('deleted', $deleted, $update);}

    /**
     * Filter deleted
     * @param int $deleted
     */
    public function filterDeleted($deleted) {$this->filterField('deleted', $deleted);}

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
     * Get descriptionshort
     * @return string
     */
    public function getDescriptionshort() { return $this->getField('descriptionshort');}

    /**
     * Set descriptionshort
     * @param string $descriptionshort
     */
    public function setDescriptionshort($descriptionshort, $update = false) {$this->setField('descriptionshort', $descriptionshort, $update);}

    /**
     * Filter descriptionshort
     * @param string $descriptionshort
     */
    public function filterDescriptionshort($descriptionshort) {$this->filterField('descriptionshort', $descriptionshort);}

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
     * Get udate
     * @return string
     */
    public function getUdate() { return $this->getField('udate');}

    /**
     * Set udate
     * @param string $udate
     */
    public function setUdate($udate, $update = false) {$this->setField('udate', $udate, $update);}

    /**
     * Filter udate
     * @param string $udate
     */
    public function filterUdate($udate) {$this->filterField('udate', $udate);}

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
        $this->setTablename('shopproduct');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopProduct
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopProduct
     */
    public static function Get($key) {return self::GetObject("XShopProduct", $key);}

}

SQLObject::SetFieldArray('shopproduct', array('id', 'name', 'description', 'tags', 'categoryid', 'hidden', 'deleted', 'url', 'descriptionshort', 'seodescription', 'seotitle', 'seoh1', 'seocontent', 'seokeywords', 'udate', 'linkkey'));
SQLObject::SetPrimaryKey('shopproduct', 'id');
