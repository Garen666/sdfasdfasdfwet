<?php
/**
 * Class XShopUserVoIP is ORM to table shopuservoip
 * @author SQLObject
 * @package SQLObject
 */
class XShopUserVoIP extends SQLObject {

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
     * Get from
     * @return string
     */
    public function getFrom() { return $this->getField('from');}

    /**
     * Set from
     * @param string $from
     */
    public function setFrom($from, $update = false) {$this->setField('from', $from, $update);}

    /**
     * Filter from
     * @param string $from
     */
    public function filterFrom($from) {$this->filterField('from', $from);}

    /**
     * Get to
     * @return string
     */
    public function getTo() { return $this->getField('to');}

    /**
     * Set to
     * @param string $to
     */
    public function setTo($to, $update = false) {$this->setField('to', $to, $update);}

    /**
     * Filter to
     * @param string $to
     */
    public function filterTo($to) {$this->filterField('to', $to);}

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
     * Get status
     * @return string
     */
    public function getStatus() { return $this->getField('status');}

    /**
     * Set status
     * @param string $status
     */
    public function setStatus($status, $update = false) {$this->setField('status', $status, $update);}

    /**
     * Filter status
     * @param string $status
     */
    public function filterStatus($status) {$this->filterField('status', $status);}

    /**
     * Get channel
     * @return string
     */
    public function getChannel() { return $this->getField('channel');}

    /**
     * Set channel
     * @param string $channel
     */
    public function setChannel($channel, $update = false) {$this->setField('channel', $channel, $update);}

    /**
     * Filter channel
     * @param string $channel
     */
    public function filterChannel($channel) {$this->filterField('channel', $channel);}

    /**
     * Get line
     * @return string
     */
    public function getLine() { return $this->getField('line');}

    /**
     * Set line
     * @param string $line
     */
    public function setLine($line, $update = false) {$this->setField('line', $line, $update);}

    /**
     * Filter line
     * @param string $line
     */
    public function filterLine($line) {$this->filterField('line', $line);}

    /**
     * Get duration
     * @return string
     */
    public function getDuration() { return $this->getField('duration');}

    /**
     * Set duration
     * @param string $duration
     */
    public function setDuration($duration, $update = false) {$this->setField('duration', $duration, $update);}

    /**
     * Filter duration
     * @param string $duration
     */
    public function filterDuration($duration) {$this->filterField('duration', $duration);}

    /**
     * Get closed
     * @return int
     */
    public function getClosed() { return $this->getField('closed');}

    /**
     * Set closed
     * @param int $closed
     */
    public function setClosed($closed, $update = false) {$this->setField('closed', $closed, $update);}

    /**
     * Filter closed
     * @param int $closed
     */
    public function filterClosed($closed) {$this->filterField('closed', $closed);}

    /**
     * Get comment
     * @return string
     */
    public function getComment() { return $this->getField('comment');}

    /**
     * Set comment
     * @param string $comment
     */
    public function setComment($comment, $update = false) {$this->setField('comment', $comment, $update);}

    /**
     * Filter comment
     * @param string $comment
     */
    public function filterComment($comment) {$this->filterField('comment', $comment);}

    /**
     * Get contactfromid
     * @return int
     */
    public function getContactfromid() { return $this->getField('contactfromid');}

    /**
     * Set contactfromid
     * @param int $contactfromid
     */
    public function setContactfromid($contactfromid, $update = false) {$this->setField('contactfromid', $contactfromid, $update);}

    /**
     * Filter contactfromid
     * @param int $contactfromid
     */
    public function filterContactfromid($contactfromid) {$this->filterField('contactfromid', $contactfromid);}

    /**
     * Get contacttoid
     * @return int
     */
    public function getContacttoid() { return $this->getField('contacttoid');}

    /**
     * Set contacttoid
     * @param int $contacttoid
     */
    public function setContacttoid($contacttoid, $update = false) {$this->setField('contacttoid', $contacttoid, $update);}

    /**
     * Filter contacttoid
     * @param int $contacttoid
     */
    public function filterContacttoid($contacttoid) {$this->filterField('contacttoid', $contacttoid);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopuservoip');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopUserVoIP
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopUserVoIP
     */
    public static function Get($key) {return self::GetObject("XShopUserVoIP", $key);}

}

SQLObject::SetFieldArray('shopuservoip', array('id', 'from', 'to', 'cdate', 'udate', 'status', 'channel', 'line', 'duration', 'closed', 'comment', 'contactfromid', 'contacttoid'));
SQLObject::SetPrimaryKey('shopuservoip', 'id');
