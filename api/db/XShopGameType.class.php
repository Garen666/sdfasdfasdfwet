<?php
/**
 * Class XShopGameType is ORM to table shopGameType
 * @author SQLObject
 * @package SQLObject
 */
class XShopGameType extends SQLObject {

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
     * Get sort
     * @return int
     */
    public function getSort() { return $this->getField('sort');}

    /**
     * Set sort
     * @param int $sort
     */
    public function setSort($sort, $update = false) {$this->setField('sort', $sort, $update);}

    /**
     * Filter sort
     * @param int $sort
     */
    public function filterSort($sort) {$this->filterField('sort', $sort);}

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
     * Get url
     * @return string
     */
    public function getUrl() { return $this->getField('url');}

    /**
     * Set url
     * @param string $url
     */
    public function setUrl($url, $update = false) {$this->setField('url', $url, $update);}

    /**
     * Filter url
     * @param string $url
     */
    public function filterUrl($url) {$this->filterField('url', $url);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopGameType');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopGameType
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopGameType
     */
    public static function Get($key) {return self::GetObject("XShopGameType", $key);}

}

SQLObject::SetFieldArray('shopGameType', array('id', 'name', 'gameId', 'sort', 'hidden', 'deleted', 'url'));
SQLObject::SetPrimaryKey('shopGameType', 'id');
