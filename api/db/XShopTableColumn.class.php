<?php
/**
 * Class XShopTableColumn is ORM to table shoptablecolumn
 * @author SQLObject
 * @package SQLObject
 */
class XShopTableColumn extends SQLObject {

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
     * Get userid
     * @return int
     */
    public function getUserid() { return $this->getField('userid');}

    /**
     * Set userid
     * @param int $userid
     */
    public function setUserid($userid, $update = false) {$this->setField('userid', $userid, $update);}

    /**
     * Filter userid
     * @param int $userid
     */
    public function filterUserid($userid) {$this->filterField('userid', $userid);}

    /**
     * Get key
     * @return string
     */
    public function getKey() { return $this->getField('key');}

    /**
     * Set key
     * @param string $key
     */
    public function setKey($key, $update = false) {$this->setField('key', $key, $update);}

    /**
     * Filter key
     * @param string $key
     */
    public function filterKey($key) {$this->filterField('key', $key);}

    /**
     * Get visible
     * @return int
     */
    public function getVisible() { return $this->getField('visible');}

    /**
     * Set visible
     * @param int $visible
     */
    public function setVisible($visible, $update = false) {$this->setField('visible', $visible, $update);}

    /**
     * Filter visible
     * @param int $visible
     */
    public function filterVisible($visible) {$this->filterField('visible', $visible);}

    /**
     * Get datasource
     * @return string
     */
    public function getDatasource() { return $this->getField('datasource');}

    /**
     * Set datasource
     * @param string $datasource
     */
    public function setDatasource($datasource, $update = false) {$this->setField('datasource', $datasource, $update);}

    /**
     * Filter datasource
     * @param string $datasource
     */
    public function filterDatasource($datasource) {$this->filterField('datasource', $datasource);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shoptablecolumn');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopTableColumn
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopTableColumn
     */
    public static function Get($key) {return self::GetObject("XShopTableColumn", $key);}

}

SQLObject::SetFieldArray('shoptablecolumn', array('id', 'userid', 'key', 'visible', 'datasource'));
SQLObject::SetPrimaryKey('shoptablecolumn', 'id');
