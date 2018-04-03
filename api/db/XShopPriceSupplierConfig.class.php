<?php
/**
 * Class XShopPriceSupplierConfig is ORM to table shoppricesupplierconfig
 * @author SQLObject
 * @package SQLObject
 */
class XShopPriceSupplierConfig extends SQLObject {

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
     * @return string
     */
    public function getColumnprice() { return $this->getField('columnprice');}

    /**
     * Set columnprice
     * @param string $columnprice
     */
    public function setColumnprice($columnprice, $update = false) {$this->setField('columnprice', $columnprice, $update);}

    /**
     * Filter columnprice
     * @param string $columnprice
     */
    public function filterColumnprice($columnprice) {$this->filterField('columnprice', $columnprice);}

    /**
     * Get columnminretail
     * @return string
     */
    public function getColumnminretail() { return $this->getField('columnminretail');}

    /**
     * Set columnminretail
     * @param string $columnminretail
     */
    public function setColumnminretail($columnminretail, $update = false) {$this->setField('columnminretail', $columnminretail, $update);}

    /**
     * Filter columnminretail
     * @param string $columnminretail
     */
    public function filterColumnminretail($columnminretail) {$this->filterField('columnminretail', $columnminretail);}

    /**
     * Get minretail_cur_id
     * @return int
     */
    public function getMinretail_cur_id() { return $this->getField('minretail_cur_id');}

    /**
     * Set minretail_cur_id
     * @param int $minretail_cur_id
     */
    public function setMinretail_cur_id($minretail_cur_id, $update = false) {$this->setField('minretail_cur_id', $minretail_cur_id, $update);}

    /**
     * Filter minretail_cur_id
     * @param int $minretail_cur_id
     */
    public function filterMinretail_cur_id($minretail_cur_id) {$this->filterField('minretail_cur_id', $minretail_cur_id);}

    /**
     * Get columnrecommretail
     * @return string
     */
    public function getColumnrecommretail() { return $this->getField('columnrecommretail');}

    /**
     * Set columnrecommretail
     * @param string $columnrecommretail
     */
    public function setColumnrecommretail($columnrecommretail, $update = false) {$this->setField('columnrecommretail', $columnrecommretail, $update);}

    /**
     * Filter columnrecommretail
     * @param string $columnrecommretail
     */
    public function filterColumnrecommretail($columnrecommretail) {$this->filterField('columnrecommretail', $columnrecommretail);}

    /**
     * Get recommretail_cur_id
     * @return int
     */
    public function getRecommretail_cur_id() { return $this->getField('recommretail_cur_id');}

    /**
     * Set recommretail_cur_id
     * @param int $recommretail_cur_id
     */
    public function setRecommretail_cur_id($recommretail_cur_id, $update = false) {$this->setField('recommretail_cur_id', $recommretail_cur_id, $update);}

    /**
     * Filter recommretail_cur_id
     * @param int $recommretail_cur_id
     */
    public function filterRecommretail_cur_id($recommretail_cur_id) {$this->filterField('recommretail_cur_id', $recommretail_cur_id);}

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
     * @return string
     */
    public function getColumndiscount() { return $this->getField('columndiscount');}

    /**
     * Set columndiscount
     * @param string $columndiscount
     */
    public function setColumndiscount($columndiscount, $update = false) {$this->setField('columndiscount', $columndiscount, $update);}

    /**
     * Filter columndiscount
     * @param string $columndiscount
     */
    public function filterColumndiscount($columndiscount) {$this->filterField('columndiscount', $columndiscount);}

    /**
     * Get limitfrom
     * @return string
     */
    public function getLimitfrom() { return $this->getField('limitfrom');}

    /**
     * Set limitfrom
     * @param string $limitfrom
     */
    public function setLimitfrom($limitfrom, $update = false) {$this->setField('limitfrom', $limitfrom, $update);}

    /**
     * Filter limitfrom
     * @param string $limitfrom
     */
    public function filterLimitfrom($limitfrom) {$this->filterField('limitfrom', $limitfrom);}

    /**
     * Get limitto
     * @return string
     */
    public function getLimitto() { return $this->getField('limitto');}

    /**
     * Set limitto
     * @param string $limitto
     */
    public function setLimitto($limitto, $update = false) {$this->setField('limitto', $limitto, $update);}

    /**
     * Filter limitto
     * @param string $limitto
     */
    public function filterLimitto($limitto) {$this->filterField('limitto', $limitto);}

    /**
     * Get issearchcode
     * @return int
     */
    public function getIssearchcode() { return $this->getField('issearchcode');}

    /**
     * Set issearchcode
     * @param int $issearchcode
     */
    public function setIssearchcode($issearchcode, $update = false) {$this->setField('issearchcode', $issearchcode, $update);}

    /**
     * Filter issearchcode
     * @param int $issearchcode
     */
    public function filterIssearchcode($issearchcode) {$this->filterField('issearchcode', $issearchcode);}

    /**
     * Get issearchcodethis
     * @return int
     */
    public function getIssearchcodethis() { return $this->getField('issearchcodethis');}

    /**
     * Set issearchcodethis
     * @param int $issearchcodethis
     */
    public function setIssearchcodethis($issearchcodethis, $update = false) {$this->setField('issearchcodethis', $issearchcodethis, $update);}

    /**
     * Filter issearchcodethis
     * @param int $issearchcodethis
     */
    public function filterIssearchcodethis($issearchcodethis) {$this->filterField('issearchcodethis', $issearchcodethis);}

    /**
     * Get issearchname
     * @return int
     */
    public function getIssearchname() { return $this->getField('issearchname');}

    /**
     * Set issearchname
     * @param int $issearchname
     */
    public function setIssearchname($issearchname, $update = false) {$this->setField('issearchname', $issearchname, $update);}

    /**
     * Filter issearchname
     * @param int $issearchname
     */
    public function filterIssearchname($issearchname) {$this->filterField('issearchname', $issearchname);}

    /**
     * Get issearchnameprecision
     * @return int
     */
    public function getIssearchnameprecision() { return $this->getField('issearchnameprecision');}

    /**
     * Set issearchnameprecision
     * @param int $issearchnameprecision
     */
    public function setIssearchnameprecision($issearchnameprecision, $update = false) {$this->setField('issearchnameprecision', $issearchnameprecision, $update);}

    /**
     * Filter issearchnameprecision
     * @param int $issearchnameprecision
     */
    public function filterIssearchnameprecision($issearchnameprecision) {$this->filterField('issearchnameprecision', $issearchnameprecision);}

    /**
     * Get issearcharticul
     * @return int
     */
    public function getIssearcharticul() { return $this->getField('issearcharticul');}

    /**
     * Set issearcharticul
     * @param int $issearcharticul
     */
    public function setIssearcharticul($issearcharticul, $update = false) {$this->setField('issearcharticul', $issearcharticul, $update);}

    /**
     * Filter issearcharticul
     * @param int $issearcharticul
     */
    public function filterIssearcharticul($issearcharticul) {$this->filterField('issearcharticul', $issearcharticul);}

    /**
     * Get importcron
     * @return int
     */
    public function getImportcron() { return $this->getField('importcron');}

    /**
     * Set importcron
     * @param int $importcron
     */
    public function setImportcron($importcron, $update = false) {$this->setField('importcron', $importcron, $update);}

    /**
     * Filter importcron
     * @param int $importcron
     */
    public function filterImportcron($importcron) {$this->filterField('importcron', $importcron);}

    /**
     * Get createnewproduct
     * @return int
     */
    public function getCreatenewproduct() { return $this->getField('createnewproduct');}

    /**
     * Set createnewproduct
     * @param int $createnewproduct
     */
    public function setCreatenewproduct($createnewproduct, $update = false) {$this->setField('createnewproduct', $createnewproduct, $update);}

    /**
     * Filter createnewproduct
     * @param int $createnewproduct
     */
    public function filterCreatenewproduct($createnewproduct) {$this->filterField('createnewproduct', $createnewproduct);}

    /**
     * Get onlyretail
     * @return int
     */
    public function getOnlyretail() { return $this->getField('onlyretail');}

    /**
     * Set onlyretail
     * @param int $onlyretail
     */
    public function setOnlyretail($onlyretail, $update = false) {$this->setField('onlyretail', $onlyretail, $update);}

    /**
     * Filter onlyretail
     * @param int $onlyretail
     */
    public function filterOnlyretail($onlyretail) {$this->filterField('onlyretail', $onlyretail);}

    /**
     * Get removeminretail
     * @return int
     */
    public function getRemoveminretail() { return $this->getField('removeminretail');}

    /**
     * Set removeminretail
     * @param int $removeminretail
     */
    public function setRemoveminretail($removeminretail, $update = false) {$this->setField('removeminretail', $removeminretail, $update);}

    /**
     * Filter removeminretail
     * @param int $removeminretail
     */
    public function filterRemoveminretail($removeminretail) {$this->filterField('removeminretail', $removeminretail);}

    /**
     * Get removerecommretail
     * @return int
     */
    public function getRemoverecommretail() { return $this->getField('removerecommretail');}

    /**
     * Set removerecommretail
     * @param int $removerecommretail
     */
    public function setRemoverecommretail($removerecommretail, $update = false) {$this->setField('removerecommretail', $removerecommretail, $update);}

    /**
     * Filter removerecommretail
     * @param int $removerecommretail
     */
    public function filterRemoverecommretail($removerecommretail) {$this->filterField('removerecommretail', $removerecommretail);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shoppricesupplierconfig');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopPriceSupplierConfig
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopPriceSupplierConfig
     */
    public static function Get($key) {return self::GetObject("XShopPriceSupplierConfig", $key);}

}

SQLObject::SetFieldArray('shoppricesupplierconfig', array('id', 'userid', 'supplierid', 'suppliercurrencyid', 'filetype', 'fileencoding', 'columncode', 'columnname', 'columnarticul', 'columnprice', 'columnminretail', 'minretail_cur_id', 'columnrecommretail', 'recommretail_cur_id', 'columnavail', 'columndiscount', 'limitfrom', 'limitto', 'issearchcode', 'issearchcodethis', 'issearchname', 'issearchnameprecision', 'issearcharticul', 'importcron', 'createnewproduct', 'onlyretail', 'removeminretail', 'removerecommretail'));
SQLObject::SetPrimaryKey('shoppricesupplierconfig', 'id');
