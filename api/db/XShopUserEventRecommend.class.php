<?php
/**
 * Class XShopUserEventRecommend is ORM to table shopusereventrecommend
 * @author SQLObject
 * @package SQLObject
 */
class XShopUserEventRecommend extends SQLObject {

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
     * Get day
     * @return int
     */
    public function getDay() { return $this->getField('day');}

    /**
     * Set day
     * @param int $day
     */
    public function setDay($day, $update = false) {$this->setField('day', $day, $update);}

    /**
     * Filter day
     * @param int $day
     */
    public function filterDay($day) {$this->filterField('day', $day);}

    /**
     * Get time
     * @return string
     */
    public function getTime() { return $this->getField('time');}

    /**
     * Set time
     * @param string $time
     */
    public function setTime($time, $update = false) {$this->setField('time', $time, $update);}

    /**
     * Filter time
     * @param string $time
     */
    public function filterTime($time) {$this->filterField('time', $time);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopusereventrecommend');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopUserEventRecommend
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopUserEventRecommend
     */
    public static function Get($key) {return self::GetObject("XShopUserEventRecommend", $key);}

}

SQLObject::SetFieldArray('shopusereventrecommend', array('id', 'userid', 'day', 'time'));
SQLObject::SetPrimaryKey('shopusereventrecommend', 'id');
