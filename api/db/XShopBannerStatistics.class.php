<?php
/**
 * Class XShopBannerStatistics is ORM to table shopbannerstatistic
 * @author SQLObject
 * @package SQLObject
 */
class XShopBannerStatistics extends SQLObject {

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
     * Get bannerid
     * @return int
     */
    public function getBannerid() { return $this->getField('bannerid');}

    /**
     * Set bannerid
     * @param int $bannerid
     */
    public function setBannerid($bannerid, $update = false) {$this->setField('bannerid', $bannerid, $update);}

    /**
     * Filter bannerid
     * @param int $bannerid
     */
    public function filterBannerid($bannerid) {$this->filterField('bannerid', $bannerid);}

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
     * Get sessionid
     * @return string
     */
    public function getSessionid() { return $this->getField('sessionid');}

    /**
     * Set sessionid
     * @param string $sessionid
     */
    public function setSessionid($sessionid, $update = false) {$this->setField('sessionid', $sessionid, $update);}

    /**
     * Filter sessionid
     * @param string $sessionid
     */
    public function filterSessionid($sessionid) {$this->filterField('sessionid', $sessionid);}

    /**
     * Get ip
     * @return string
     */
    public function getIp() { return $this->getField('ip');}

    /**
     * Set ip
     * @param string $ip
     */
    public function setIp($ip, $update = false) {$this->setField('ip', $ip, $update);}

    /**
     * Filter ip
     * @param string $ip
     */
    public function filterIp($ip) {$this->filterField('ip', $ip);}

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopbannerstatistic');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopBannerStatistics
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopBannerStatistics
     */
    public static function Get($key) {return self::GetObject("XShopBannerStatistics", $key);}

}

SQLObject::SetFieldArray('shopbannerstatistic', array('id', 'bannerid', 'userid', 'sessionid', 'ip', 'cdate'));
SQLObject::SetPrimaryKey('shopbannerstatistic', 'id');
