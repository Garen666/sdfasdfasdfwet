<?php
/**
 * Class XShopSearchLog is ORM to table shopsearch
 * @author SQLObject
 * @package SQLObject
 */
class XShopSearchLog extends SQLObject {

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
     * Get sid
     * @return string
     */
    public function getSid() { return $this->getField('sid');}

    /**
     * Set sid
     * @param string $sid
     */
    public function setSid($sid, $update = false) {$this->setField('sid', $sid, $update);}

    /**
     * Filter sid
     * @param string $sid
     */
    public function filterSid($sid) {$this->filterField('sid', $sid);}

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
     * Get query
     * @return string
     */
    public function getQuery() { return $this->getField('query');}

    /**
     * Set query
     * @param string $query
     */
    public function setQuery($query, $update = false) {$this->setField('query', $query, $update);}

    /**
     * Filter query
     * @param string $query
     */
    public function filterQuery($query) {$this->filterField('query', $query);}

    /**
     * Get countresult
     * @return int
     */
    public function getCountresult() { return $this->getField('countresult');}

    /**
     * Set countresult
     * @param int $countresult
     */
    public function setCountresult($countresult, $update = false) {$this->setField('countresult', $countresult, $update);}

    /**
     * Filter countresult
     * @param int $countresult
     */
    public function filterCountresult($countresult) {$this->filterField('countresult', $countresult);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopsearch');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopSearchLog
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopSearchLog
     */
    public static function Get($key) {return self::GetObject("XShopSearchLog", $key);}

}

SQLObject::SetFieldArray('shopsearch', array('id', 'cdate', 'sid', 'userid', 'query', 'countresult'));
SQLObject::SetPrimaryKey('shopsearch', 'id');
