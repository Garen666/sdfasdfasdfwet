<?php
/**
 * Class XShopSEO is ORM to table shopseo
 * @author SQLObject
 * @package SQLObject
 */
class XShopSEO extends SQLObject {

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopseo');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopSEO
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopSEO
     */
    public static function Get($key) {return self::GetObject("XShopSEO", $key);}

}

SQLObject::SetFieldArray('shopseo', array('id', 'url', 'seotitle', 'seoh1', 'seokeywords', 'seodescription', 'seocontent'));
SQLObject::SetPrimaryKey('shopseo', 'id');
