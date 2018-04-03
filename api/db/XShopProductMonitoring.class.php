<?php
/**
 * Class XShopProductMonitoring is ORM to table shopproductmonitoring
 * @author SQLObject
 * @package SQLObject
 */
class XShopProductMonitoring extends SQLObject {

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopproductmonitoring');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopProductMonitoring
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopProductMonitoring
     */
    public static function Get($key) {return self::GetObject("XShopProductMonitoring", $key);}

}

SQLObject::SetFieldArray('shopproductmonitoring', array('id', 'productid', 'cdate', 'content', 'image'));
SQLObject::SetPrimaryKey('shopproductmonitoring', 'id');
