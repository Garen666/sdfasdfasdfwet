<?php
/**
 * Class XShopLogo is ORM to table shoplogo
 * @author SQLObject
 * @package SQLObject
 */
class XShopLogo extends SQLObject {

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
     * Get sdate
     * @return string
     */
    public function getSdate() { return $this->getField('sdate');}

    /**
     * Set sdate
     * @param string $sdate
     */
    public function setSdate($sdate, $update = false) {$this->setField('sdate', $sdate, $update);}

    /**
     * Filter sdate
     * @param string $sdate
     */
    public function filterSdate($sdate) {$this->filterField('sdate', $sdate);}

    /**
     * Get edate
     * @return string
     */
    public function getEdate() { return $this->getField('edate');}

    /**
     * Set edate
     * @param string $edate
     */
    public function setEdate($edate, $update = false) {$this->setField('edate', $edate, $update);}

    /**
     * Filter edate
     * @param string $edate
     */
    public function filterEdate($edate) {$this->filterField('edate', $edate);}

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
     * Get default
     * @return int
     */
    public function getDefault() { return $this->getField('default');}

    /**
     * Set default
     * @param int $default
     */
    public function setDefault($default, $update = false) {$this->setField('default', $default, $update);}

    /**
     * Filter default
     * @param int $default
     */
    public function filterDefault($default) {$this->filterField('default', $default);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shoplogo');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopLogo
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopLogo
     */
    public static function Get($key) {return self::GetObject("XShopLogo", $key);}

}

SQLObject::SetFieldArray('shoplogo', array('id', 'sdate', 'edate', 'name', 'file', 'default'));
SQLObject::SetPrimaryKey('shoplogo', 'id');
