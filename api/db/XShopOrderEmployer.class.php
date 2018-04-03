<?php
/**
 * Class XShopOrderEmployer is ORM to table shoporderemployer
 * @author SQLObject
 * @package SQLObject
 */
class XShopOrderEmployer extends SQLObject {

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
     * Get managerid
     * @return int
     */
    public function getManagerid() { return $this->getField('managerid');}

    /**
     * Set managerid
     * @param int $managerid
     */
    public function setManagerid($managerid, $update = false) {$this->setField('managerid', $managerid, $update);}

    /**
     * Filter managerid
     * @param int $managerid
     */
    public function filterManagerid($managerid) {$this->filterField('managerid', $managerid);}

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
     * Get role
     * @return string
     */
    public function getRole() { return $this->getField('role');}

    /**
     * Set role
     * @param string $role
     */
    public function setRole($role, $update = false) {$this->setField('role', $role, $update);}

    /**
     * Filter role
     * @param string $role
     */
    public function filterRole($role) {$this->filterField('role', $role);}

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
     * Get percent
     * @return float
     */
    public function getPercent() { return $this->getField('percent');}

    /**
     * Set percent
     * @param float $percent
     */
    public function setPercent($percent, $update = false) {$this->setField('percent', $percent, $update);}

    /**
     * Filter percent
     * @param float $percent
     */
    public function filterPercent($percent) {$this->filterField('percent', $percent);}

    /**
     * Get term
     * @return string
     */
    public function getTerm() { return $this->getField('term');}

    /**
     * Set term
     * @param string $term
     */
    public function setTerm($term, $update = false) {$this->setField('term', $term, $update);}

    /**
     * Filter term
     * @param string $term
     */
    public function filterTerm($term) {$this->filterField('term', $term);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shoporderemployer');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopOrderEmployer
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopOrderEmployer
     */
    public static function Get($key) {return self::GetObject("XShopOrderEmployer", $key);}

}

SQLObject::SetFieldArray('shoporderemployer', array('id', 'orderid', 'managerid', 'statusid', 'role', 'sum', 'percent', 'term'));
SQLObject::SetPrimaryKey('shoporderemployer', 'id');
