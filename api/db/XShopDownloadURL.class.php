<?php
/**
 * Class XShopDownloadURL is ORM to table shopdownloadurl
 * @author SQLObject
 * @package SQLObject
 */
class XShopDownloadURL extends SQLObject {

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
     * Get hash
     * @return string
     */
    public function getHash() { return $this->getField('hash');}

    /**
     * Set hash
     * @param string $hash
     */
    public function setHash($hash, $update = false) {$this->setField('hash', $hash, $update);}

    /**
     * Filter hash
     * @param string $hash
     */
    public function filterHash($hash) {$this->filterField('hash', $hash);}

    /**
     * Get linkkey
     * @return string
     */
    public function getLinkkey() { return $this->getField('linkkey');}

    /**
     * Set linkkey
     * @param string $linkkey
     */
    public function setLinkkey($linkkey, $update = false) {$this->setField('linkkey', $linkkey, $update);}

    /**
     * Filter linkkey
     * @param string $linkkey
     */
    public function filterLinkkey($linkkey) {$this->filterField('linkkey', $linkkey);}

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopdownloadurl');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopDownloadURL
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopDownloadURL
     */
    public static function Get($key) {return self::GetObject("XShopDownloadURL", $key);}

}

SQLObject::SetFieldArray('shopdownloadurl', array('id', 'file', 'hash', 'linkkey', 'cdate', 'edate'));
SQLObject::SetPrimaryKey('shopdownloadurl', 'id');
