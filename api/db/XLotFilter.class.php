<?php
/**
 * Class XLotFilter is ORM to table lotFilter
 * @author SQLObject
 * @package SQLObject
 */
class XLotFilter extends SQLObject {

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
     * Get name
     * @return string
     */
    public function getName() { return $this->getField('name');}

    /**
     * Set name
     * @param string $name
     */
    public function setName($name, $update = false) {$this->setField('name', $name, $update);}

    /**
     * Filter name
     * @param string $name
     */
    public function filterName($name) {$this->filterField('name', $name);}

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
     * Get hidden
     * @return int
     */
    public function getHidden() { return $this->getField('hidden');}

    /**
     * Set hidden
     * @param int $hidden
     */
    public function setHidden($hidden, $update = false) {$this->setField('hidden', $hidden, $update);}

    /**
     * Filter hidden
     * @param int $hidden
     */
    public function filterHidden($hidden) {$this->filterField('hidden', $hidden);}

    /**
     * Get deleted
     * @return int
     */
    public function getDeleted() { return $this->getField('deleted');}

    /**
     * Set deleted
     * @param int $deleted
     */
    public function setDeleted($deleted, $update = false) {$this->setField('deleted', $deleted, $update);}

    /**
     * Filter deleted
     * @param int $deleted
     */
    public function filterDeleted($deleted) {$this->filterField('deleted', $deleted);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('lotFilter');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XLotFilter
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XLotFilter
     */
    public static function Get($key) {return self::GetObject("XLotFilter", $key);}

}

SQLObject::SetFieldArray('lotFilter', array('id', 'name', 'gameId', 'lotTypeId', 'hidden', 'deleted'));
SQLObject::SetPrimaryKey('lotFilter', 'id');
