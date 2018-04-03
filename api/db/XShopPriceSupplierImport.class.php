<?php
/**
 * Class XShopPriceSupplierImport is ORM to table shoppricesupplierimport
 * @author SQLObject
 * @package SQLObject
 */
class XShopPriceSupplierImport extends SQLObject {

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
     * Get pdate
     * @return string
     */
    public function getPdate() { return $this->getField('pdate');}

    /**
     * Set pdate
     * @param string $pdate
     */
    public function setPdate($pdate, $update = false) {$this->setField('pdate', $pdate, $update);}

    /**
     * Filter pdate
     * @param string $pdate
     */
    public function filterPdate($pdate) {$this->filterField('pdate', $pdate);}

    /**
     * Get step
     * @return int
     */
    public function getStep() { return $this->getField('step');}

    /**
     * Set step
     * @param int $step
     */
    public function setStep($step, $update = false) {$this->setField('step', $step, $update);}

    /**
     * Filter step
     * @param int $step
     */
    public function filterStep($step) {$this->filterField('step', $step);}

    /**
     * Get supplierid
     * @return int
     */
    public function getSupplierid() { return $this->getField('supplierid');}

    /**
     * Set supplierid
     * @param int $supplierid
     */
    public function setSupplierid($supplierid, $update = false) {$this->setField('supplierid', $supplierid, $update);}

    /**
     * Filter supplierid
     * @param int $supplierid
     */
    public function filterSupplierid($supplierid) {$this->filterField('supplierid', $supplierid);}

    /**
     * Get suppliercurrencyid
     * @return int
     */
    public function getSuppliercurrencyid() { return $this->getField('suppliercurrencyid');}

    /**
     * Set suppliercurrencyid
     * @param int $suppliercurrencyid
     */
    public function setSuppliercurrencyid($suppliercurrencyid, $update = false) {$this->setField('suppliercurrencyid', $suppliercurrencyid, $update);}

    /**
     * Filter suppliercurrencyid
     * @param int $suppliercurrencyid
     */
    public function filterSuppliercurrencyid($suppliercurrencyid) {$this->filterField('suppliercurrencyid', $suppliercurrencyid);}

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
     * Get filetype
     * @return string
     */
    public function getFiletype() { return $this->getField('filetype');}

    /**
     * Set filetype
     * @param string $filetype
     */
    public function setFiletype($filetype, $update = false) {$this->setField('filetype', $filetype, $update);}

    /**
     * Filter filetype
     * @param string $filetype
     */
    public function filterFiletype($filetype) {$this->filterField('filetype', $filetype);}

    /**
     * Get fileencoding
     * @return string
     */
    public function getFileencoding() { return $this->getField('fileencoding');}

    /**
     * Set fileencoding
     * @param string $fileencoding
     */
    public function setFileencoding($fileencoding, $update = false) {$this->setField('fileencoding', $fileencoding, $update);}

    /**
     * Filter fileencoding
     * @param string $fileencoding
     */
    public function filterFileencoding($fileencoding) {$this->filterField('fileencoding', $fileencoding);}

    /**
     * Get columncode
     * @return string
     */
    public function getColumncode() { return $this->getField('columncode');}

    /**
     * Set columncode
     * @param string $columncode
     */
    public function setColumncode($columncode, $update = false) {$this->setField('columncode', $columncode, $update);}

    /**
     * Filter columncode
     * @param string $columncode
     */
    public function filterColumncode($columncode) {$this->filterField('columncode', $columncode);}

    /**
     * Get columnname
     * @return string
     */
    public function getColumnname() { return $this->getField('columnname');}

    /**
     * Set columnname
     * @param string $columnname
     */
    public function setColumnname($columnname, $update = false) {$this->setField('columnname', $columnname, $update);}

    /**
     * Filter columnname
     * @param string $columnname
     */
    public function filterColumnname($columnname) {$this->filterField('columnname', $columnname);}

    /**
     * Get columnarticul
     * @return string
     */
    public function getColumnarticul() { return $this->getField('columnarticul');}

    /**
     * Set columnarticul
     * @param string $columnarticul
     */
    public function setColumnarticul($columnarticul, $update = false) {$this->setField('columnarticul', $columnarticul, $update);}

    /**
     * Filter columnarticul
     * @param string $columnarticul
     */
    public function filterColumnarticul($columnarticul) {$this->filterField('columnarticul', $columnarticul);}

    /**
     * Get columnprice
     * @return int
     */
    public function getColumnprice() { return $this->getField('columnprice');}

    /**
     * Set columnprice
     * @param int $columnprice
     */
    public function setColumnprice($columnprice, $update = false) {$this->setField('columnprice', $columnprice, $update);}

    /**
     * Filter columnprice
     * @param int $columnprice
     */
    public function filterColumnprice($columnprice) {$this->filterField('columnprice', $columnprice);}

    /**
     * Get columnminretail
     * @return int
     */
    public function getColumnminretail() { return $this->getField('columnminretail');}

    /**
     * Set columnminretail
     * @param int $columnminretail
     */
    public function setColumnminretail($columnminretail, $update = false) {$this->setField('columnminretail', $columnminretail, $update);}

    /**
     * Filter columnminretail
     * @param int $columnminretail
     */
    public function filterColumnminretail($columnminretail) {$this->filterField('columnminretail', $columnminretail);}

    /**
     * Get columnminretail_cur_id
     * @return int
     */
    public function getColumnminretail_cur_id() { return $this->getField('columnminretail_cur_id');}

    /**
     * Set columnminretail_cur_id
     * @param int $columnminretail_cur_id
     */
    public function setColumnminretail_cur_id($columnminretail_cur_id, $update = false) {$this->setField('columnminretail_cur_id', $columnminretail_cur_id, $update);}

    /**
     * Filter columnminretail_cur_id
     * @param int $columnminretail_cur_id
     */
    public function filterColumnminretail_cur_id($columnminretail_cur_id) {$this->filterField('columnminretail_cur_id', $columnminretail_cur_id);}

    /**
     * Get columnrecommretail
     * @return int
     */
    public function getColumnrecommretail() { return $this->getField('columnrecommretail');}

    /**
     * Set columnrecommretail
     * @param int $columnrecommretail
     */
    public function setColumnrecommretail($columnrecommretail, $update = false) {$this->setField('columnrecommretail', $columnrecommretail, $update);}

    /**
     * Filter columnrecommretail
     * @param int $columnrecommretail
     */
    public function filterColumnrecommretail($columnrecommretail) {$this->filterField('columnrecommretail', $columnrecommretail);}

    /**
     * Get columnrecommretail_cur_id
     * @return int
     */
    public function getColumnrecommretail_cur_id() { return $this->getField('columnrecommretail_cur_id');}

    /**
     * Set columnrecommretail_cur_id
     * @param int $columnrecommretail_cur_id
     */
    public function setColumnrecommretail_cur_id($columnrecommretail_cur_id, $update = false) {$this->setField('columnrecommretail_cur_id', $columnrecommretail_cur_id, $update);}

    /**
     * Filter columnrecommretail_cur_id
     * @param int $columnrecommretail_cur_id
     */
    public function filterColumnrecommretail_cur_id($columnrecommretail_cur_id) {$this->filterField('columnrecommretail_cur_id', $columnrecommretail_cur_id);}

    /**
     * Get columnavail
     * @return string
     */
    public function getColumnavail() { return $this->getField('columnavail');}

    /**
     * Set columnavail
     * @param string $columnavail
     */
    public function setColumnavail($columnavail, $update = false) {$this->setField('columnavail', $columnavail, $update);}

    /**
     * Filter columnavail
     * @param string $columnavail
     */
    public function filterColumnavail($columnavail) {$this->filterField('columnavail', $columnavail);}

    /**
     * Get columndiscount
     * @return int
     */
    public function getColumndiscount() { return $this->getField('columndiscount');}

    /**
     * Set columndiscount
     * @param int $columndiscount
     */
    public function setColumndiscount($columndiscount, $update = false) {$this->setField('columndiscount', $columndiscount, $update);}

    /**
     * Filter columndiscount
     * @param int $columndiscount
     */
    public function filterColumndiscount($columndiscount) {$this->filterField('columndiscount', $columndiscount);}

    /**
     * Get optionarray
     * @return string
     */
    public function getOptionarray() { return $this->getField('optionarray');}

    /**
     * Set optionarray
     * @param string $optionarray
     */
    public function setOptionarray($optionarray, $update = false) {$this->setField('optionarray', $optionarray, $update);}

    /**
     * Filter optionarray
     * @param string $optionarray
     */
    public function filterOptionarray($optionarray) {$this->filterField('optionarray', $optionarray);}

    /**
     * Get searchnameprecision
     * @return int
     */
    public function getSearchnameprecision() { return $this->getField('searchnameprecision');}

    /**
     * Set searchnameprecision
     * @param int $searchnameprecision
     */
    public function setSearchnameprecision($searchnameprecision, $update = false) {$this->setField('searchnameprecision', $searchnameprecision, $update);}

    /**
     * Filter searchnameprecision
     * @param int $searchnameprecision
     */
    public function filterSearchnameprecision($searchnameprecision) {$this->filterField('searchnameprecision', $searchnameprecision);}

    /**
     * Get lastpart
     * @return int
     */
    public function getLastpart() { return $this->getField('lastpart');}

    /**
     * Set lastpart
     * @param int $lastpart
     */
    public function setLastpart($lastpart, $update = false) {$this->setField('lastpart', $lastpart, $update);}

    /**
     * Filter lastpart
     * @param int $lastpart
     */
    public function filterLastpart($lastpart) {$this->filterField('lastpart', $lastpart);}

    /**
     * Get firstpart
     * @return int
     */
    public function getFirstpart() { return $this->getField('firstpart');}

    /**
     * Set firstpart
     * @param int $firstpart
     */
    public function setFirstpart($firstpart, $update = false) {$this->setField('firstpart', $firstpart, $update);}

    /**
     * Filter firstpart
     * @param int $firstpart
     */
    public function filterFirstpart($firstpart) {$this->filterField('firstpart', $firstpart);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shoppricesupplierimport');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopPriceSupplierImport
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopPriceSupplierImport
     */
    public static function Get($key) {return self::GetObject("XShopPriceSupplierImport", $key);}

}

SQLObject::SetFieldArray('shoppricesupplierimport', array('id', 'cdate', 'pdate', 'step', 'supplierid', 'suppliercurrencyid', 'file', 'filetype', 'fileencoding', 'columncode', 'columnname', 'columnarticul', 'columnprice', 'columnminretail', 'columnminretail_cur_id', 'columnrecommretail', 'columnrecommretail_cur_id', 'columnavail', 'columndiscount', 'optionarray', 'searchnameprecision', 'lastpart', 'firstpart'));
SQLObject::SetPrimaryKey('shoppricesupplierimport', 'id');
