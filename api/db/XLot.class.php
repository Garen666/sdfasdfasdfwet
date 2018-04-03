<?php
/**
 * Class XLot is ORM to table lots
 * @author SQLObject
 * @package SQLObject
 */
class XLot extends SQLObject {

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
     * Get gameId
     * @return int
     */
    public function getGameId() { return $this->getField('gameId');}

    /**
     * Set gameId
     * @param int $gameId
     */
    public function setGameId($gameId, $update = false) {$this->setField('gameId', $gameId, $update);}

    /**
     * Filter gameId
     * @param int $gameId
     */
    public function filterGameId($gameId) {$this->filterField('gameId', $gameId);}

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('lots');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XLot
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XLot
     */
    public static function Get($key) {return self::GetObject("XLot", $key);}

}

SQLObject::SetFieldArray('lots', array('id', 'userId', 'gameId', 'lotTypeId'));
SQLObject::SetPrimaryKey('lots', 'id');
