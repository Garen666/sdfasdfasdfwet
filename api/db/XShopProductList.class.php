<?php
/**
 * Class XShopProductList is ORM to table shopproductlist
 * @author SQLObject
 * @package SQLObject
 */
class XShopProductList extends SQLObject {

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
     * Get nameshort
     * @return string
     */
    public function getNameshort() { return $this->getField('nameshort');}

    /**
     * Set nameshort
     * @param string $nameshort
     */
    public function setNameshort($nameshort, $update = false) {$this->setField('nameshort', $nameshort, $update);}

    /**
     * Filter nameshort
     * @param string $nameshort
     */
    public function filterNameshort($nameshort) {$this->filterField('nameshort', $nameshort);}

    /**
     * Get showinmain
     * @return int
     */
    public function getShowinmain() { return $this->getField('showinmain');}

    /**
     * Set showinmain
     * @param int $showinmain
     */
    public function setShowinmain($showinmain, $update = false) {$this->setField('showinmain', $showinmain, $update);}

    /**
     * Filter showinmain
     * @param int $showinmain
     */
    public function filterShowinmain($showinmain) {$this->filterField('showinmain', $showinmain);}

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
     * Get showtype
     * @return string
     */
    public function getShowtype() { return $this->getField('showtype');}

    /**
     * Set showtype
     * @param string $showtype
     */
    public function setShowtype($showtype, $update = false) {$this->setField('showtype', $showtype, $update);}

    /**
     * Filter showtype
     * @param string $showtype
     */
    public function filterShowtype($showtype) {$this->filterField('showtype', $showtype);}

    /**
     * Get autoplay
     * @return int
     */
    public function getAutoplay() { return $this->getField('autoplay');}

    /**
     * Set autoplay
     * @param int $autoplay
     */
    public function setAutoplay($autoplay, $update = false) {$this->setField('autoplay', $autoplay, $update);}

    /**
     * Filter autoplay
     * @param int $autoplay
     */
    public function filterAutoplay($autoplay) {$this->filterField('autoplay', $autoplay);}

    /**
     * Get logicclass
     * @return string
     */
    public function getLogicclass() { return $this->getField('logicclass');}

    /**
     * Set logicclass
     * @param string $logicclass
     */
    public function setLogicclass($logicclass, $update = false) {$this->setField('logicclass', $logicclass, $update);}

    /**
     * Filter logicclass
     * @param string $logicclass
     */
    public function filterLogicclass($logicclass) {$this->filterField('logicclass', $logicclass);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopproductlist');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopProductList
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopProductList
     */
    public static function Get($key) {return self::GetObject("XShopProductList", $key);}

}

SQLObject::SetFieldArray('shopproductlist', array('id', 'name', 'nameshort', 'showinmain', 'linkkey', 'hidden', 'showtype', 'autoplay', 'logicclass'));
SQLObject::SetPrimaryKey('shopproductlist', 'id');
