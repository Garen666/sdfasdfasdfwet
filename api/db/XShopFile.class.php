<?php
/**
 * Class XShopFile is ORM to table shopfile
 * @author SQLObject
 * @package SQLObject
 */
class XShopFile extends SQLObject {

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
     * Get file
     * @return string
     */
    public function getFile() { return $this->getField('file');}

    /**
     * Set file
     * @param string $file
     */
    public function setFile($file, $update = false) {$this->setField('file', $file, $update);}

    /**
     * Filter file
     * @param string $file
     */
    public function filterFile($file) {$this->filterField('file', $file);}

    /**
     * Get contenttype
     * @return string
     */
    public function getContenttype() { return $this->getField('contenttype');}

    /**
     * Set contenttype
     * @param string $contenttype
     */
    public function setContenttype($contenttype, $update = false) {$this->setField('contenttype', $contenttype, $update);}

    /**
     * Filter contenttype
     * @param string $contenttype
     */
    public function filterContenttype($contenttype) {$this->filterField('contenttype', $contenttype);}

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
        $this->setTablename('shopfile');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopFile
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopFile
     */
    public static function Get($key) {return self::GetObject("XShopFile", $key);}

}

SQLObject::SetFieldArray('shopfile', array('id', 'key', 'name', 'file', 'contenttype', 'cdate', 'userid', 'deleted'));
SQLObject::SetPrimaryKey('shopfile', 'id');
