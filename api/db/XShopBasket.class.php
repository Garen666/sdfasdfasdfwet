<?php
/**
 * Class XShopBasket is ORM to table shopbasket
 * @author SQLObject
 * @package SQLObject
 */
class XShopBasket extends SQLObject {

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
     * Get sid
     * @return string
     */
    public function getSid() { return $this->getField('sid');}

    /**
     * Set sid
     * @param string $sid
     */
    public function setSid($sid, $update = false) {$this->setField('sid', $sid, $update);}

    /**
     * Filter sid
     * @param string $sid
     */
    public function filterSid($sid) {$this->filterField('sid', $sid);}

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
     * Get productid
     * @return int
     */
    public function getProductid() { return $this->getField('productid');}

    /**
     * Set productid
     * @param int $productid
     */
    public function setProductid($productid, $update = false) {$this->setField('productid', $productid, $update);}

    /**
     * Filter productid
     * @param int $productid
     */
    public function filterProductid($productid) {$this->filterField('productid', $productid);}

    /**
     * Get productcount
     * @return float
     */
    public function getProductcount() { return $this->getField('productcount');}

    /**
     * Set productcount
     * @param float $productcount
     */
    public function setProductcount($productcount, $update = false) {$this->setField('productcount', $productcount, $update);}

    /**
     * Filter productcount
     * @param float $productcount
     */
    public function filterProductcount($productcount) {$this->filterField('productcount', $productcount);}

    /**
     * Get productprice
     * @return float
     */
    public function getProductprice() { return $this->getField('productprice');}

    /**
     * Set productprice
     * @param float $productprice
     */
    public function setProductprice($productprice, $update = false) {$this->setField('productprice', $productprice, $update);}

    /**
     * Filter productprice
     * @param float $productprice
     */
    public function filterProductprice($productprice) {$this->filterField('productprice', $productprice);}

    /**
     * Get filter1id
     * @return int
     */
    public function getFilter1id() { return $this->getField('filter1id');}

    /**
     * Set filter1id
     * @param int $filter1id
     */
    public function setFilter1id($filter1id, $update = false) {$this->setField('filter1id', $filter1id, $update);}

    /**
     * Filter filter1id
     * @param int $filter1id
     */
    public function filterFilter1id($filter1id) {$this->filterField('filter1id', $filter1id);}

    /**
     * Get filter1value
     * @return string
     */
    public function getFilter1value() { return $this->getField('filter1value');}

    /**
     * Set filter1value
     * @param string $filter1value
     */
    public function setFilter1value($filter1value, $update = false) {$this->setField('filter1value', $filter1value, $update);}

    /**
     * Filter filter1value
     * @param string $filter1value
     */
    public function filterFilter1value($filter1value) {$this->filterField('filter1value', $filter1value);}

    /**
     * Get filter1markup
     * @return float
     */
    public function getFilter1markup() { return $this->getField('filter1markup');}

    /**
     * Set filter1markup
     * @param float $filter1markup
     */
    public function setFilter1markup($filter1markup, $update = false) {$this->setField('filter1markup', $filter1markup, $update);}

    /**
     * Filter filter1markup
     * @param float $filter1markup
     */
    public function filterFilter1markup($filter1markup) {$this->filterField('filter1markup', $filter1markup);}

    /**
     * Get filter2id
     * @return int
     */
    public function getFilter2id() { return $this->getField('filter2id');}

    /**
     * Set filter2id
     * @param int $filter2id
     */
    public function setFilter2id($filter2id, $update = false) {$this->setField('filter2id', $filter2id, $update);}

    /**
     * Filter filter2id
     * @param int $filter2id
     */
    public function filterFilter2id($filter2id) {$this->filterField('filter2id', $filter2id);}

    /**
     * Get filter2value
     * @return string
     */
    public function getFilter2value() { return $this->getField('filter2value');}

    /**
     * Set filter2value
     * @param string $filter2value
     */
    public function setFilter2value($filter2value, $update = false) {$this->setField('filter2value', $filter2value, $update);}

    /**
     * Filter filter2value
     * @param string $filter2value
     */
    public function filterFilter2value($filter2value) {$this->filterField('filter2value', $filter2value);}

    /**
     * Get filter2markup
     * @return float
     */
    public function getFilter2markup() { return $this->getField('filter2markup');}

    /**
     * Set filter2markup
     * @param float $filter2markup
     */
    public function setFilter2markup($filter2markup, $update = false) {$this->setField('filter2markup', $filter2markup, $update);}

    /**
     * Filter filter2markup
     * @param float $filter2markup
     */
    public function filterFilter2markup($filter2markup) {$this->filterField('filter2markup', $filter2markup);}

    /**
     * Get filter3id
     * @return int
     */
    public function getFilter3id() { return $this->getField('filter3id');}

    /**
     * Set filter3id
     * @param int $filter3id
     */
    public function setFilter3id($filter3id, $update = false) {$this->setField('filter3id', $filter3id, $update);}

    /**
     * Filter filter3id
     * @param int $filter3id
     */
    public function filterFilter3id($filter3id) {$this->filterField('filter3id', $filter3id);}

    /**
     * Get filter3value
     * @return string
     */
    public function getFilter3value() { return $this->getField('filter3value');}

    /**
     * Set filter3value
     * @param string $filter3value
     */
    public function setFilter3value($filter3value, $update = false) {$this->setField('filter3value', $filter3value, $update);}

    /**
     * Filter filter3value
     * @param string $filter3value
     */
    public function filterFilter3value($filter3value) {$this->filterField('filter3value', $filter3value);}

    /**
     * Get filter3markup
     * @return float
     */
    public function getFilter3markup() { return $this->getField('filter3markup');}

    /**
     * Set filter3markup
     * @param float $filter3markup
     */
    public function setFilter3markup($filter3markup, $update = false) {$this->setField('filter3markup', $filter3markup, $update);}

    /**
     * Filter filter3markup
     * @param float $filter3markup
     */
    public function filterFilter3markup($filter3markup) {$this->filterField('filter3markup', $filter3markup);}

    /**
     * Get filter4id
     * @return int
     */
    public function getFilter4id() { return $this->getField('filter4id');}

    /**
     * Set filter4id
     * @param int $filter4id
     */
    public function setFilter4id($filter4id, $update = false) {$this->setField('filter4id', $filter4id, $update);}

    /**
     * Filter filter4id
     * @param int $filter4id
     */
    public function filterFilter4id($filter4id) {$this->filterField('filter4id', $filter4id);}

    /**
     * Get filter4value
     * @return string
     */
    public function getFilter4value() { return $this->getField('filter4value');}

    /**
     * Set filter4value
     * @param string $filter4value
     */
    public function setFilter4value($filter4value, $update = false) {$this->setField('filter4value', $filter4value, $update);}

    /**
     * Filter filter4value
     * @param string $filter4value
     */
    public function filterFilter4value($filter4value) {$this->filterField('filter4value', $filter4value);}

    /**
     * Get filter4markup
     * @return float
     */
    public function getFilter4markup() { return $this->getField('filter4markup');}

    /**
     * Set filter4markup
     * @param float $filter4markup
     */
    public function setFilter4markup($filter4markup, $update = false) {$this->setField('filter4markup', $filter4markup, $update);}

    /**
     * Filter filter4markup
     * @param float $filter4markup
     */
    public function filterFilter4markup($filter4markup) {$this->filterField('filter4markup', $filter4markup);}

    /**
     * Get filter5id
     * @return int
     */
    public function getFilter5id() { return $this->getField('filter5id');}

    /**
     * Set filter5id
     * @param int $filter5id
     */
    public function setFilter5id($filter5id, $update = false) {$this->setField('filter5id', $filter5id, $update);}

    /**
     * Filter filter5id
     * @param int $filter5id
     */
    public function filterFilter5id($filter5id) {$this->filterField('filter5id', $filter5id);}

    /**
     * Get filter5value
     * @return string
     */
    public function getFilter5value() { return $this->getField('filter5value');}

    /**
     * Set filter5value
     * @param string $filter5value
     */
    public function setFilter5value($filter5value, $update = false) {$this->setField('filter5value', $filter5value, $update);}

    /**
     * Filter filter5value
     * @param string $filter5value
     */
    public function filterFilter5value($filter5value) {$this->filterField('filter5value', $filter5value);}

    /**
     * Get filter5markup
     * @return float
     */
    public function getFilter5markup() { return $this->getField('filter5markup');}

    /**
     * Set filter5markup
     * @param float $filter5markup
     */
    public function setFilter5markup($filter5markup, $update = false) {$this->setField('filter5markup', $filter5markup, $update);}

    /**
     * Filter filter5markup
     * @param float $filter5markup
     */
    public function filterFilter5markup($filter5markup) {$this->filterField('filter5markup', $filter5markup);}

    /**
     * Get filter6id
     * @return int
     */
    public function getFilter6id() { return $this->getField('filter6id');}

    /**
     * Set filter6id
     * @param int $filter6id
     */
    public function setFilter6id($filter6id, $update = false) {$this->setField('filter6id', $filter6id, $update);}

    /**
     * Filter filter6id
     * @param int $filter6id
     */
    public function filterFilter6id($filter6id) {$this->filterField('filter6id', $filter6id);}

    /**
     * Get filter6value
     * @return string
     */
    public function getFilter6value() { return $this->getField('filter6value');}

    /**
     * Set filter6value
     * @param string $filter6value
     */
    public function setFilter6value($filter6value, $update = false) {$this->setField('filter6value', $filter6value, $update);}

    /**
     * Filter filter6value
     * @param string $filter6value
     */
    public function filterFilter6value($filter6value) {$this->filterField('filter6value', $filter6value);}

    /**
     * Get filter6markup
     * @return float
     */
    public function getFilter6markup() { return $this->getField('filter6markup');}

    /**
     * Set filter6markup
     * @param float $filter6markup
     */
    public function setFilter6markup($filter6markup, $update = false) {$this->setField('filter6markup', $filter6markup, $update);}

    /**
     * Filter filter6markup
     * @param float $filter6markup
     */
    public function filterFilter6markup($filter6markup) {$this->filterField('filter6markup', $filter6markup);}

    /**
     * Get filter7id
     * @return int
     */
    public function getFilter7id() { return $this->getField('filter7id');}

    /**
     * Set filter7id
     * @param int $filter7id
     */
    public function setFilter7id($filter7id, $update = false) {$this->setField('filter7id', $filter7id, $update);}

    /**
     * Filter filter7id
     * @param int $filter7id
     */
    public function filterFilter7id($filter7id) {$this->filterField('filter7id', $filter7id);}

    /**
     * Get filter7value
     * @return string
     */
    public function getFilter7value() { return $this->getField('filter7value');}

    /**
     * Set filter7value
     * @param string $filter7value
     */
    public function setFilter7value($filter7value, $update = false) {$this->setField('filter7value', $filter7value, $update);}

    /**
     * Filter filter7value
     * @param string $filter7value
     */
    public function filterFilter7value($filter7value) {$this->filterField('filter7value', $filter7value);}

    /**
     * Get filter7markup
     * @return float
     */
    public function getFilter7markup() { return $this->getField('filter7markup');}

    /**
     * Set filter7markup
     * @param float $filter7markup
     */
    public function setFilter7markup($filter7markup, $update = false) {$this->setField('filter7markup', $filter7markup, $update);}

    /**
     * Filter filter7markup
     * @param float $filter7markup
     */
    public function filterFilter7markup($filter7markup) {$this->filterField('filter7markup', $filter7markup);}

    /**
     * Get filter8id
     * @return int
     */
    public function getFilter8id() { return $this->getField('filter8id');}

    /**
     * Set filter8id
     * @param int $filter8id
     */
    public function setFilter8id($filter8id, $update = false) {$this->setField('filter8id', $filter8id, $update);}

    /**
     * Filter filter8id
     * @param int $filter8id
     */
    public function filterFilter8id($filter8id) {$this->filterField('filter8id', $filter8id);}

    /**
     * Get filter8value
     * @return string
     */
    public function getFilter8value() { return $this->getField('filter8value');}

    /**
     * Set filter8value
     * @param string $filter8value
     */
    public function setFilter8value($filter8value, $update = false) {$this->setField('filter8value', $filter8value, $update);}

    /**
     * Filter filter8value
     * @param string $filter8value
     */
    public function filterFilter8value($filter8value) {$this->filterField('filter8value', $filter8value);}

    /**
     * Get filter8markup
     * @return float
     */
    public function getFilter8markup() { return $this->getField('filter8markup');}

    /**
     * Set filter8markup
     * @param float $filter8markup
     */
    public function setFilter8markup($filter8markup, $update = false) {$this->setField('filter8markup', $filter8markup, $update);}

    /**
     * Filter filter8markup
     * @param float $filter8markup
     */
    public function filterFilter8markup($filter8markup) {$this->filterField('filter8markup', $filter8markup);}

    /**
     * Get filter9id
     * @return int
     */
    public function getFilter9id() { return $this->getField('filter9id');}

    /**
     * Set filter9id
     * @param int $filter9id
     */
    public function setFilter9id($filter9id, $update = false) {$this->setField('filter9id', $filter9id, $update);}

    /**
     * Filter filter9id
     * @param int $filter9id
     */
    public function filterFilter9id($filter9id) {$this->filterField('filter9id', $filter9id);}

    /**
     * Get filter9value
     * @return string
     */
    public function getFilter9value() { return $this->getField('filter9value');}

    /**
     * Set filter9value
     * @param string $filter9value
     */
    public function setFilter9value($filter9value, $update = false) {$this->setField('filter9value', $filter9value, $update);}

    /**
     * Filter filter9value
     * @param string $filter9value
     */
    public function filterFilter9value($filter9value) {$this->filterField('filter9value', $filter9value);}

    /**
     * Get filter9markup
     * @return float
     */
    public function getFilter9markup() { return $this->getField('filter9markup');}

    /**
     * Set filter9markup
     * @param float $filter9markup
     */
    public function setFilter9markup($filter9markup, $update = false) {$this->setField('filter9markup', $filter9markup, $update);}

    /**
     * Filter filter9markup
     * @param float $filter9markup
     */
    public function filterFilter9markup($filter9markup) {$this->filterField('filter9markup', $filter9markup);}

    /**
     * Get filter10id
     * @return int
     */
    public function getFilter10id() { return $this->getField('filter10id');}

    /**
     * Set filter10id
     * @param int $filter10id
     */
    public function setFilter10id($filter10id, $update = false) {$this->setField('filter10id', $filter10id, $update);}

    /**
     * Filter filter10id
     * @param int $filter10id
     */
    public function filterFilter10id($filter10id) {$this->filterField('filter10id', $filter10id);}

    /**
     * Get filter10value
     * @return string
     */
    public function getFilter10value() { return $this->getField('filter10value');}

    /**
     * Set filter10value
     * @param string $filter10value
     */
    public function setFilter10value($filter10value, $update = false) {$this->setField('filter10value', $filter10value, $update);}

    /**
     * Filter filter10value
     * @param string $filter10value
     */
    public function filterFilter10value($filter10value) {$this->filterField('filter10value', $filter10value);}

    /**
     * Get filter10markup
     * @return float
     */
    public function getFilter10markup() { return $this->getField('filter10markup');}

    /**
     * Set filter10markup
     * @param float $filter10markup
     */
    public function setFilter10markup($filter10markup, $update = false) {$this->setField('filter10markup', $filter10markup, $update);}

    /**
     * Filter filter10markup
     * @param float $filter10markup
     */
    public function filterFilter10markup($filter10markup) {$this->filterField('filter10markup', $filter10markup);}

    /**
     * Get params
     * @return string
     */
    public function getParams() { return $this->getField('params');}

    /**
     * Set params
     * @param string $params
     */
    public function setParams($params, $update = false) {$this->setField('params', $params, $update);}

    /**
     * Filter params
     * @param string $params
     */
    public function filterParams($params) {$this->filterField('params', $params);}

    /**
     * Get datefrom
     * @return string
     */
    public function getDatefrom() { return $this->getField('datefrom');}

    /**
     * Set datefrom
     * @param string $datefrom
     */
    public function setDatefrom($datefrom, $update = false) {$this->setField('datefrom', $datefrom, $update);}

    /**
     * Filter datefrom
     * @param string $datefrom
     */
    public function filterDatefrom($datefrom) {$this->filterField('datefrom', $datefrom);}

    /**
     * Get dateto
     * @return string
     */
    public function getDateto() { return $this->getField('dateto');}

    /**
     * Set dateto
     * @param string $dateto
     */
    public function setDateto($dateto, $update = false) {$this->setField('dateto', $dateto, $update);}

    /**
     * Filter dateto
     * @param string $dateto
     */
    public function filterDateto($dateto) {$this->filterField('dateto', $dateto);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopbasket');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopBasket
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopBasket
     */
    public static function Get($key) {return self::GetObject("XShopBasket", $key);}

}

SQLObject::SetFieldArray('shopbasket', array('id', 'cdate', 'sid', 'userid', 'productid', 'productcount', 'productprice', 'filter1id', 'filter1value', 'filter1markup', 'filter2id', 'filter2value', 'filter2markup', 'filter3id', 'filter3value', 'filter3markup', 'filter4id', 'filter4value', 'filter4markup', 'filter5id', 'filter5value', 'filter5markup', 'filter6id', 'filter6value', 'filter6markup', 'filter7id', 'filter7value', 'filter7markup', 'filter8id', 'filter8value', 'filter8markup', 'filter9id', 'filter9value', 'filter9markup', 'filter10id', 'filter10value', 'filter10markup', 'params', 'datefrom', 'dateto'));
SQLObject::SetPrimaryKey('shopbasket', 'id');
