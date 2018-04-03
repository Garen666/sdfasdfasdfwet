<?php
/**
 * Class XPayment is ORM to table payments
 * @author SQLObject
 * @package SQLObject
 */
class XPayment extends SQLObject {

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
     * Get userId
     * @return int
     */
    public function getUserId() { return $this->getField('userId');}

    /**
     * Set userId
     * @param int $userId
     */
    public function setUserId($userId, $update = false) {$this->setField('userId', $userId, $update);}

    /**
     * Filter userId
     * @param int $userId
     */
    public function filterUserId($userId) {$this->filterField('userId', $userId);}

    /**
     * Get orderId
     * @return int
     */
    public function getOrderId() { return $this->getField('orderId');}

    /**
     * Set orderId
     * @param int $orderId
     */
    public function setOrderId($orderId, $update = false) {$this->setField('orderId', $orderId, $update);}

    /**
     * Filter orderId
     * @param int $orderId
     */
    public function filterOrderId($orderId) {$this->filterField('orderId', $orderId);}

    /**
     * Get sum
     * @return float
     */
    public function getSum() { return $this->getField('sum');}

    /**
     * Set sum
     * @param float $sum
     */
    public function setSum($sum, $update = false) {$this->setField('sum', $sum, $update);}

    /**
     * Filter sum
     * @param float $sum
     */
    public function filterSum($sum) {$this->filterField('sum', $sum);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('payments');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XPayment
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XPayment
     */
    public static function Get($key) {return self::GetObject("XPayment", $key);}

}

SQLObject::SetFieldArray('payments', array('id', 'cdate', 'userId', 'orderId', 'sum'));
SQLObject::SetPrimaryKey('payments', 'id');
