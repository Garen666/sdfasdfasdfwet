<?php
/**
 * Class XCallRouting is ORM to table callrouting
 * @author SQLObject
 * @package SQLObject
 */
class XCallRouting extends SQLObject {

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('callrouting');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XCallRouting
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XCallRouting
     */
    public static function Get($key) {return self::GetObject("XCallRouting", $key);}

}

SQLObject::SetFieldArray('callrouting', array('id', 'from', 'to', 'name'));
SQLObject::SetPrimaryKey('callrouting', 'id');
