<?php
/**
 * Class XShopProductsNoticeOfAvailability is ORM to table shopproductsnoticeofavailability
 * @author SQLObject
 * @package SQLObject
 */
class XShopProductsNoticeOfAvailability extends SQLObject {

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
     * Get email
     * @return string
     */
    public function getEmail() { return $this->getField('email');}

    /**
     * Set email
     * @param string $email
     */
    public function setEmail($email, $update = false) {$this->setField('email', $email, $update);}

    /**
     * Filter email
     * @param string $email
     */
    public function filterEmail($email) {$this->filterField('email', $email);}

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
     * Get senddate
     * @return string
     */
    public function getSenddate() { return $this->getField('senddate');}

    /**
     * Set senddate
     * @param string $senddate
     */
    public function setSenddate($senddate, $update = false) {$this->setField('senddate', $senddate, $update);}

    /**
     * Filter senddate
     * @param string $senddate
     */
    public function filterSenddate($senddate) {$this->filterField('senddate', $senddate);}

    /**
     * Get status
     * @return int
     */
    public function getStatus() { return $this->getField('status');}

    /**
     * Set status
     * @param int $status
     */
    public function setStatus($status, $update = false) {$this->setField('status', $status, $update);}

    /**
     * Filter status
     * @param int $status
     */
    public function filterStatus($status) {$this->filterField('status', $status);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopproductsnoticeofavailability');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopProductsNoticeOfAvailability
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopProductsNoticeOfAvailability
     */
    public static function Get($key) {return self::GetObject("XShopProductsNoticeOfAvailability", $key);}

}

SQLObject::SetFieldArray('shopproductsnoticeofavailability', array('id', 'productid', 'name', 'email', 'cdate', 'senddate', 'status'));
SQLObject::SetPrimaryKey('shopproductsnoticeofavailability', 'id');
