<?php
/**
 * Class XShopProductRival is ORM to table shopproductrival
 * @author SQLObject
 * @package SQLObject
 */
class XShopProductRival extends SQLObject {

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
     * Get pricemin
     * @return float
     */
    public function getPricemin() { return $this->getField('pricemin');}

    /**
     * Set pricemin
     * @param float $pricemin
     */
    public function setPricemin($pricemin, $update = false) {$this->setField('pricemin', $pricemin, $update);}

    /**
     * Filter pricemin
     * @param float $pricemin
     */
    public function filterPricemin($pricemin) {$this->filterField('pricemin', $pricemin);}

    /**
     * Get pricemax
     * @return float
     */
    public function getPricemax() { return $this->getField('pricemax');}

    /**
     * Set pricemax
     * @param float $pricemax
     */
    public function setPricemax($pricemax, $update = false) {$this->setField('pricemax', $pricemax, $update);}

    /**
     * Filter pricemax
     * @param float $pricemax
     */
    public function filterPricemax($pricemax) {$this->filterField('pricemax', $pricemax);}

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
     * Get frequency
     * @return int
     */
    public function getFrequency() { return $this->getField('frequency');}

    /**
     * Set frequency
     * @param int $frequency
     */
    public function setFrequency($frequency, $update = false) {$this->setField('frequency', $frequency, $update);}

    /**
     * Filter frequency
     * @param int $frequency
     */
    public function filterFrequency($frequency) {$this->filterField('frequency', $frequency);}

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
     * Get status
     * @return string
     */
    public function getStatus() { return $this->getField('status');}

    /**
     * Set status
     * @param string $status
     */
    public function setStatus($status, $update = false) {$this->setField('status', $status, $update);}

    /**
     * Filter status
     * @param string $status
     */
    public function filterStatus($status) {$this->filterField('status', $status);}

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopproductrival');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopProductRival
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopProductRival
     */
    public static function Get($key) {return self::GetObject("XShopProductRival", $key);}

}

SQLObject::SetFieldArray('shopproductrival', array('id', 'url', 'pricemin', 'pricemax', 'productid', 'frequency', 'hidden', 'status', 'udate'));
SQLObject::SetPrimaryKey('shopproductrival', 'id');
