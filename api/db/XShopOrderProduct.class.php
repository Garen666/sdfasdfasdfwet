<?php
/**
 * Class XShopOrderProduct is ORM to table shoporderproduct
 * @author SQLObject
 * @package SQLObject
 */
class XShopOrderProduct extends SQLObject {

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
     * Get orderid
     * @return int
     */
    public function getOrderid() { return $this->getField('orderid');}

    /**
     * Set orderid
     * @param int $orderid
     */
    public function setOrderid($orderid, $update = false) {$this->setField('orderid', $orderid, $update);}

    /**
     * Filter orderid
     * @param int $orderid
     */
    public function filterOrderid($orderid) {$this->filterField('orderid', $orderid);}

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
     * Get productcount
     * @return float
     */
    public function getProductcount() { return $this->getField('productcount');}

    /**
     * Set productcount
     * @param float $productcount
     */
    public function setProductcount($productcount, $update = false) {$this->setField('productcount', $productcount, $update);}

    /**
     * Filter productcount
     * @param float $productcount
     */
    public function filterProductcount($productcount) {$this->filterField('productcount', $productcount);}

    /**
     * Get productname
     * @return string
     */
    public function getProductname() { return $this->getField('productname');}

    /**
     * Set productname
     * @param string $productname
     */
    public function setProductname($productname, $update = false) {$this->setField('productname', $productname, $update);}

    /**
     * Filter productname
     * @param string $productname
     */
    public function filterProductname($productname) {$this->filterField('productname', $productname);}

    /**
     * Get productprice
     * @return float
     */
    public function getProductprice() { return $this->getField('productprice');}

    /**
     * Set productprice
     * @param float $productprice
     */
    public function setProductprice($productprice, $update = false) {$this->setField('productprice', $productprice, $update);}

    /**
     * Filter productprice
     * @param float $productprice
     */
    public function filterProductprice($productprice) {$this->filterField('productprice', $productprice);}

    /**
     * Get currencyid
     * @return int
     */
    public function getCurrencyid() { return $this->getField('currencyid');}

    /**
     * Set currencyid
     * @param int $currencyid
     */
    public function setCurrencyid($currencyid, $update = false) {$this->setField('currencyid', $currencyid, $update);}

    /**
     * Filter currencyid
     * @param int $currencyid
     */
    public function filterCurrencyid($currencyid) {$this->filterField('currencyid', $currencyid);}

    /**
     * Get serial
     * @return string
     */
    public function getSerial() { return $this->getField('serial');}

    /**
     * Set serial
     * @param string $serial
     */
    public function setSerial($serial, $update = false) {$this->setField('serial', $serial, $update);}

    /**
     * Filter serial
     * @param string $serial
     */
    public function filterSerial($serial) {$this->filterField('serial', $serial);}

    /**
     * Get warranty
     * @return string
     */
    public function getWarranty() { return $this->getField('warranty');}

    /**
     * Set warranty
     * @param string $warranty
     */
    public function setWarranty($warranty, $update = false) {$this->setField('warranty', $warranty, $update);}

    /**
     * Filter warranty
     * @param string $warranty
     */
    public function filterWarranty($warranty) {$this->filterField('warranty', $warranty);}

    /**
     * Get categoryname
     * @return string
     */
    public function getCategoryname() { return $this->getField('categoryname');}

    /**
     * Set categoryname
     * @param string $categoryname
     */
    public function setCategoryname($categoryname, $update = false) {$this->setField('categoryname', $categoryname, $update);}

    /**
     * Filter categoryname
     * @param string $categoryname
     */
    public function filterCategoryname($categoryname) {$this->filterField('categoryname', $categoryname);}

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
     * Get statusid
     * @return int
     */
    public function getStatusid() { return $this->getField('statusid');}

    /**
     * Set statusid
     * @param int $statusid
     */
    public function setStatusid($statusid, $update = false) {$this->setField('statusid', $statusid, $update);}

    /**
     * Filter statusid
     * @param int $statusid
     */
    public function filterStatusid($statusid) {$this->filterField('statusid', $statusid);}

    /**
     * Get params
     * @return string
     */
    public function getParams() { return $this->getField('params');}

    /**
     * Set params
     * @param string $params
     */
    public function setParams($params, $update = false) {$this->setField('params', $params, $update);}

    /**
     * Filter params
     * @param string $params
     */
    public function filterParams($params) {$this->filterField('params', $params);}

    /**
     * Get datefrom
     * @return string
     */
    public function getDatefrom() { return $this->getField('datefrom');}

    /**
     * Set datefrom
     * @param string $datefrom
     */
    public function setDatefrom($datefrom, $update = false) {$this->setField('datefrom', $datefrom, $update);}

    /**
     * Filter datefrom
     * @param string $datefrom
     */
    public function filterDatefrom($datefrom) {$this->filterField('datefrom', $datefrom);}

    /**
     * Get dateto
     * @return string
     */
    public function getDateto() { return $this->getField('dateto');}

    /**
     * Set dateto
     * @param string $dateto
     */
    public function setDateto($dateto, $update = false) {$this->setField('dateto', $dateto, $update);}

    /**
     * Filter dateto
     * @param string $dateto
     */
    public function filterDateto($dateto) {$this->filterField('dateto', $dateto);}

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
     * Get sortable
     * @return int
     */
    public function getSortable() { return $this->getField('sortable');}

    /**
     * Set sortable
     * @param int $sortable
     */
    public function setSortable($sortable, $update = false) {$this->setField('sortable', $sortable, $update);}

    /**
     * Filter sortable
     * @param int $sortable
     */
    public function filterSortable($sortable) {$this->filterField('sortable', $sortable);}

    /**
     * Get sync
     * @return int
     */
    public function getSync() { return $this->getField('sync');}

    /**
     * Set sync
     * @param int $sync
     */
    public function setSync($sync, $update = false) {$this->setField('sync', $sync, $update);}

    /**
     * Filter sync
     * @param int $sync
     */
    public function filterSync($sync) {$this->filterField('sync', $sync);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shoporderproduct');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopOrderProduct
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopOrderProduct
     */
    public static function Get($key) {return self::GetObject("XShopOrderProduct", $key);}

}

SQLObject::SetFieldArray('shoporderproduct', array('id', 'orderid', 'productid', 'productcount', 'productname', 'productprice', 'currencyid', 'serial', 'warranty', 'categoryname', 'comment', 'statusid', 'params', 'datefrom', 'dateto', 'linkkey', 'sortable', 'sync'));
SQLObject::SetPrimaryKey('shoporderproduct', 'id');
