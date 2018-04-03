<?php
/**
 * Class XShopCoupon is ORM to table shopcoupon
 * @author SQLObject
 * @package SQLObject
 */
class XShopCoupon extends SQLObject {

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
     * Get code
     * @return string
     */
    public function getCode() { return $this->getField('code');}

    /**
     * Set code
     * @param string $code
     */
    public function setCode($code, $update = false) {$this->setField('code', $code, $update);}

    /**
     * Filter code
     * @param string $code
     */
    public function filterCode($code) {$this->filterField('code', $code);}

    /**
     * Get dateused
     * @return string
     */
    public function getDateused() { return $this->getField('dateused');}

    /**
     * Set dateused
     * @param string $dateused
     */
    public function setDateused($dateused, $update = false) {$this->setField('dateused', $dateused, $update);}

    /**
     * Filter dateused
     * @param string $dateused
     */
    public function filterDateused($dateused) {$this->filterField('dateused', $dateused);}

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopcoupon');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopCoupon
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopCoupon
     */
    public static function Get($key) {return self::GetObject("XShopCoupon", $key);}

}

SQLObject::SetFieldArray('shopcoupon', array('id', 'code', 'dateused', 'amount', 'currencyid', 'orderid', 'comment'));
SQLObject::SetPrimaryKey('shopcoupon', 'id');
