<?php
/**
 * Class XLotFilterValue is ORM to table lotFilterValue
 * @author SQLObject
 * @package SQLObject
 */
class XLotFilterValue extends SQLObject {

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
     * Get lotTypeId
     * @return int
     */
    public function getLotTypeId() { return $this->getField('lotTypeId');}

    /**
     * Set lotTypeId
     * @param int $lotTypeId
     */
    public function setLotTypeId($lotTypeId, $update = false) {$this->setField('lotTypeId', $lotTypeId, $update);}

    /**
     * Filter lotTypeId
     * @param int $lotTypeId
     */
    public function filterLotTypeId($lotTypeId) {$this->filterField('lotTypeId', $lotTypeId);}

    /**
     * Get lotFilterId
     * @return int
     */
    public function getLotFilterId() { return $this->getField('lotFilterId');}

    /**
     * Set lotFilterId
     * @param int $lotFilterId
     */
    public function setLotFilterId($lotFilterId, $update = false) {$this->setField('lotFilterId', $lotFilterId, $update);}

    /**
     * Filter lotFilterId
     * @param int $lotFilterId
     */
    public function filterLotFilterId($lotFilterId) {$this->filterField('lotFilterId', $lotFilterId);}

    /**
     * Get filterValue
     * @return string
     */
    public function getFilterValue() { return $this->getField('filterValue');}

    /**
     * Set filterValue
     * @param string $filterValue
     */
    public function setFilterValue($filterValue, $update = false) {$this->setField('filterValue', $filterValue, $update);}

    /**
     * Filter filterValue
     * @param string $filterValue
     */
    public function filterFilterValue($filterValue) {$this->filterField('filterValue', $filterValue);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('lotFilterValue');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XLotFilterValue
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XLotFilterValue
     */
    public static function Get($key) {return self::GetObject("XLotFilterValue", $key);}

}

SQLObject::SetFieldArray('lotFilterValue', array('id', 'lotTypeId', 'lotFilterId', 'filterValue'));
SQLObject::SetPrimaryKey('lotFilterValue', 'id');
