<?php
/**
 * Class XShopPaymentResult is ORM to table shoppaymentresult
 * @author SQLObject
 * @package SQLObject
 */
class XShopPaymentResult extends SQLObject {

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
     * Get amount
     * @return float
     */
    public function getAmount() { return $this->getField('amount');}

    /**
     * Set amount
     * @param float $amount
     */
    public function setAmount($amount, $update = false) {$this->setField('amount', $amount, $update);}

    /**
     * Filter amount
     * @param float $amount
     */
    public function filterAmount($amount) {$this->filterField('amount', $amount);}

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shoppaymentresult');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopPaymentResult
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopPaymentResult
     */
    public static function Get($key) {return self::GetObject("XShopPaymentResult", $key);}

}

SQLObject::SetFieldArray('shoppaymentresult', array('id', 'amount', 'orderid', 'status'));
SQLObject::SetPrimaryKey('shoppaymentresult', 'id');
