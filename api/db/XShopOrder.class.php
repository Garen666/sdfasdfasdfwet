<?php
/**
 * Class XShopOrder is ORM to table shoporder
 * @author SQLObject
 * @package SQLObject
 */
class XShopOrder extends SQLObject {

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
     * Get managerid
     * @return int
     */
    public function getManagerid() { return $this->getField('managerid');}

    /**
     * Set managerid
     * @param int $managerid
     */
    public function setManagerid($managerid, $update = false) {$this->setField('managerid', $managerid, $update);}

    /**
     * Filter managerid
     * @param int $managerid
     */
    public function filterManagerid($managerid) {$this->filterField('managerid', $managerid);}

    /**
     * Get authorid
     * @return int
     */
    public function getAuthorid() { return $this->getField('authorid');}

    /**
     * Set authorid
     * @param int $authorid
     */
    public function setAuthorid($authorid, $update = false) {$this->setField('authorid', $authorid, $update);}

    /**
     * Filter authorid
     * @param int $authorid
     */
    public function filterAuthorid($authorid) {$this->filterField('authorid', $authorid);}

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
     * Get udate
     * @return string
     */
    public function getUdate() { return $this->getField('udate');}

    /**
     * Set udate
     * @param string $udate
     */
    public function setUdate($udate, $update = false) {$this->setField('udate', $udate, $update);}

    /**
     * Filter udate
     * @param string $udate
     */
    public function filterUdate($udate) {$this->filterField('udate', $udate);}

    /**
     * Get statusid
     * @return int
     */
    public function getStatusid() { return $this->getField('statusid');}

    /**
     * Set statusid
     * @param int $statusid
     */
    public function setStatusid($statusid, $update = false) {$this->setField('statusid', $statusid, $update);}

    /**
     * Filter statusid
     * @param int $statusid
     */
    public function filterStatusid($statusid) {$this->filterField('statusid', $statusid);}

    /**
     * Get categoryid
     * @return int
     */
    public function getCategoryid() { return $this->getField('categoryid');}

    /**
     * Set categoryid
     * @param int $categoryid
     */
    public function setCategoryid($categoryid, $update = false) {$this->setField('categoryid', $categoryid, $update);}

    /**
     * Filter categoryid
     * @param int $categoryid
     */
    public function filterCategoryid($categoryid) {$this->filterField('categoryid', $categoryid);}

    /**
     * Get comments
     * @return string
     */
    public function getComments() { return $this->getField('comments');}

    /**
     * Set comments
     * @param string $comments
     */
    public function setComments($comments, $update = false) {$this->setField('comments', $comments, $update);}

    /**
     * Filter comments
     * @param string $comments
     */
    public function filterComments($comments) {$this->filterField('comments', $comments);}

    /**
     * Get sum
     * @return float
     */
    public function getSum() { return $this->getField('sum');}

    /**
     * Set sum
     * @param float $sum
     */
    public function setSum($sum, $update = false) {$this->setField('sum', $sum, $update);}

    /**
     * Filter sum
     * @param float $sum
     */
    public function filterSum($sum) {$this->filterField('sum', $sum);}

    /**
     * Get currencyid
     * @return int
     */
    public function getCurrencyid() { return $this->getField('currencyid');}

    /**
     * Set currencyid
     * @param int $currencyid
     */
    public function setCurrencyid($currencyid, $update = false) {$this->setField('currencyid', $currencyid, $update);}

    /**
     * Filter currencyid
     * @param int $currencyid
     */
    public function filterCurrencyid($currencyid) {$this->filterField('currencyid', $currencyid);}

    /**
     * Get paymentid
     * @return int
     */
    public function getPaymentid() { return $this->getField('paymentid');}

    /**
     * Set paymentid
     * @param int $paymentid
     */
    public function setPaymentid($paymentid, $update = false) {$this->setField('paymentid', $paymentid, $update);}

    /**
     * Filter paymentid
     * @param int $paymentid
     */
    public function filterPaymentid($paymentid) {$this->filterField('paymentid', $paymentid);}

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
     * Get dateclosed
     * @return string
     */
    public function getDateclosed() { return $this->getField('dateclosed');}

    /**
     * Set dateclosed
     * @param string $dateclosed
     */
    public function setDateclosed($dateclosed, $update = false) {$this->setField('dateclosed', $dateclosed, $update);}

    /**
     * Filter dateclosed
     * @param string $dateclosed
     */
    public function filterDateclosed($dateclosed) {$this->filterField('dateclosed', $dateclosed);}

    /**
     * Get parentid
     * @return int
     */
    public function getParentid() { return $this->getField('parentid');}

    /**
     * Set parentid
     * @param int $parentid
     */
    public function setParentid($parentid, $update = false) {$this->setField('parentid', $parentid, $update);}

    /**
     * Filter parentid
     * @param int $parentid
     */
    public function filterParentid($parentid) {$this->filterField('parentid', $parentid);}

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
     * Get ip
     * @return string
     */
    public function getIp() { return $this->getField('ip');}

    /**
     * Set ip
     * @param string $ip
     */
    public function setIp($ip, $update = false) {$this->setField('ip', $ip, $update);}

    /**
     * Filter ip
     * @param string $ip
     */
    public function filterIp($ip) {$this->filterField('ip', $ip);}

    /**
     * Get utm_source
     * @return string
     */
    public function getUtm_source() { return $this->getField('utm_source');}

    /**
     * Set utm_source
     * @param string $utm_source
     */
    public function setUtm_source($utm_source, $update = false) {$this->setField('utm_source', $utm_source, $update);}

    /**
     * Filter utm_source
     * @param string $utm_source
     */
    public function filterUtm_source($utm_source) {$this->filterField('utm_source', $utm_source);}

    /**
     * Get utm_medium
     * @return string
     */
    public function getUtm_medium() { return $this->getField('utm_medium');}

    /**
     * Set utm_medium
     * @param string $utm_medium
     */
    public function setUtm_medium($utm_medium, $update = false) {$this->setField('utm_medium', $utm_medium, $update);}

    /**
     * Filter utm_medium
     * @param string $utm_medium
     */
    public function filterUtm_medium($utm_medium) {$this->filterField('utm_medium', $utm_medium);}

    /**
     * Get utm_campaign
     * @return string
     */
    public function getUtm_campaign() { return $this->getField('utm_campaign');}

    /**
     * Set utm_campaign
     * @param string $utm_campaign
     */
    public function setUtm_campaign($utm_campaign, $update = false) {$this->setField('utm_campaign', $utm_campaign, $update);}

    /**
     * Filter utm_campaign
     * @param string $utm_campaign
     */
    public function filterUtm_campaign($utm_campaign) {$this->filterField('utm_campaign', $utm_campaign);}

    /**
     * Get utm_content
     * @return string
     */
    public function getUtm_content() { return $this->getField('utm_content');}

    /**
     * Set utm_content
     * @param string $utm_content
     */
    public function setUtm_content($utm_content, $update = false) {$this->setField('utm_content', $utm_content, $update);}

    /**
     * Filter utm_content
     * @param string $utm_content
     */
    public function filterUtm_content($utm_content) {$this->filterField('utm_content', $utm_content);}

    /**
     * Get utm_term
     * @return string
     */
    public function getUtm_term() { return $this->getField('utm_term');}

    /**
     * Set utm_term
     * @param string $utm_term
     */
    public function setUtm_term($utm_term, $update = false) {$this->setField('utm_term', $utm_term, $update);}

    /**
     * Filter utm_term
     * @param string $utm_term
     */
    public function filterUtm_term($utm_term) {$this->filterField('utm_term', $utm_term);}

    /**
     * Get utm_date
     * @return string
     */
    public function getUtm_date() { return $this->getField('utm_date');}

    /**
     * Set utm_date
     * @param string $utm_date
     */
    public function setUtm_date($utm_date, $update = false) {$this->setField('utm_date', $utm_date, $update);}

    /**
     * Filter utm_date
     * @param string $utm_date
     */
    public function filterUtm_date($utm_date) {$this->filterField('utm_date', $utm_date);}

    /**
     * Get utm_referrer
     * @return string
     */
    public function getUtm_referrer() { return $this->getField('utm_referrer');}

    /**
     * Set utm_referrer
     * @param string $utm_referrer
     */
    public function setUtm_referrer($utm_referrer, $update = false) {$this->setField('utm_referrer', $utm_referrer, $update);}

    /**
     * Filter utm_referrer
     * @param string $utm_referrer
     */
    public function filterUtm_referrer($utm_referrer) {$this->filterField('utm_referrer', $utm_referrer);}

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
        $this->setTablename('shoporder');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopOrder
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopOrder
     */
    public static function Get($key) {return self::GetObject("XShopOrder", $key);}

}

SQLObject::SetFieldArray('shoporder', array('id', 'name', 'userid', 'managerid', 'authorid', 'cdate', 'udate', 'statusid', 'categoryid', 'comments', 'sum', 'currencyid', 'paymentid', 'hash', 'dateclosed', 'parentid', 'linkkey', 'ip', 'utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term', 'utm_date', 'utm_referrer', 'deleted'));
SQLObject::SetPrimaryKey('shoporder', 'id');
