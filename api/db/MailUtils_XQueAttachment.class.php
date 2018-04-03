<?php
/**
 * Class MailUtils_XQueAttachment is ORM to table mailutils_queattachment
 * @author SQLObject
 * @package SQLObject
 */
class MailUtils_XQueAttachment extends SQLObject {

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
     * Get queid
     * @return int
     */
    public function getQueid() { return $this->getField('queid');}

    /**
     * Set queid
     * @param int $queid
     */
    public function setQueid($queid, $update = false) {$this->setField('queid', $queid, $update);}

    /**
     * Filter queid
     * @param int $queid
     */
    public function filterQueid($queid) {$this->filterField('queid', $queid);}

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('mailutils_queattachment');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return MailUtils_XQueAttachment
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return MailUtils_XQueAttachment
     */
    public static function Get($key) {return self::GetObject("MailUtils_XQueAttachment", $key);}

}

SQLObject::SetFieldArray('mailutils_queattachment', array('id', 'queid', 'cdate', 'name', 'type', 'file'));
SQLObject::SetPrimaryKey('mailutils_queattachment', 'id');
