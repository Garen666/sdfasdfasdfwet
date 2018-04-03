<?php
/**
 * Class XShopEvent is ORM to table shopevent
 * @author SQLObject
 * @package SQLObject
 */
class XShopEvent extends SQLObject {

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
     * Get type
     * @return string
     */
    public function getType() { return $this->getField('type');}

    /**
     * Set type
     * @param string $type
     */
    public function setType($type, $update = false) {$this->setField('type', $type, $update);}

    /**
     * Filter type
     * @param string $type
     */
    public function filterType($type) {$this->filterField('type', $type);}

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
     * Get session
     * @return string
     */
    public function getSession() { return $this->getField('session');}

    /**
     * Set session
     * @param string $session
     */
    public function setSession($session, $update = false) {$this->setField('session', $session, $update);}

    /**
     * Filter session
     * @param string $session
     */
    public function filterSession($session) {$this->filterField('session', $session);}

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
     * Get sourceid
     * @return int
     */
    public function getSourceid() { return $this->getField('sourceid');}

    /**
     * Set sourceid
     * @param int $sourceid
     */
    public function setSourceid($sourceid, $update = false) {$this->setField('sourceid', $sourceid, $update);}

    /**
     * Filter sourceid
     * @param int $sourceid
     */
    public function filterSourceid($sourceid) {$this->filterField('sourceid', $sourceid);}

    /**
     * Get subject
     * @return string
     */
    public function getSubject() { return $this->getField('subject');}

    /**
     * Set subject
     * @param string $subject
     */
    public function setSubject($subject, $update = false) {$this->setField('subject', $subject, $update);}

    /**
     * Filter subject
     * @param string $subject
     */
    public function filterSubject($subject) {$this->filterField('subject', $subject);}

    /**
     * Get content
     * @return string
     */
    public function getContent() { return $this->getField('content');}

    /**
     * Set content
     * @param string $content
     */
    public function setContent($content, $update = false) {$this->setField('content', $content, $update);}

    /**
     * Filter content
     * @param string $content
     */
    public function filterContent($content) {$this->filterField('content', $content);}

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
     * Get direction
     * @return int
     */
    public function getDirection() { return $this->getField('direction');}

    /**
     * Set direction
     * @param int $direction
     */
    public function setDirection($direction, $update = false) {$this->setField('direction', $direction, $update);}

    /**
     * Filter direction
     * @param int $direction
     */
    public function filterDirection($direction) {$this->filterField('direction', $direction);}

    /**
     * Get fromuserid
     * @return int
     */
    public function getFromuserid() { return $this->getField('fromuserid');}

    /**
     * Set fromuserid
     * @param int $fromuserid
     */
    public function setFromuserid($fromuserid, $update = false) {$this->setField('fromuserid', $fromuserid, $update);}

    /**
     * Filter fromuserid
     * @param int $fromuserid
     */
    public function filterFromuserid($fromuserid) {$this->filterField('fromuserid', $fromuserid);}

    /**
     * Get touserid
     * @return int
     */
    public function getTouserid() { return $this->getField('touserid');}

    /**
     * Set touserid
     * @param int $touserid
     */
    public function setTouserid($touserid, $update = false) {$this->setField('touserid', $touserid, $update);}

    /**
     * Filter touserid
     * @param int $touserid
     */
    public function filterTouserid($touserid) {$this->filterField('touserid', $touserid);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopevent');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopEvent
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopEvent
     */
    public static function Get($key) {return self::GetObject("XShopEvent", $key);}

}

SQLObject::SetFieldArray('shopevent', array('id', 'type', 'cdate', 'session', 'from', 'to', 'sourceid', 'subject', 'content', 'hidden', 'hash', 'direction', 'fromuserid', 'touserid'));
SQLObject::SetPrimaryKey('shopevent', 'id');
