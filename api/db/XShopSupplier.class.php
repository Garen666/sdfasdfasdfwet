<?php
/**
 * Class XShopSupplier is ORM to table shopsupplier
 * @author SQLObject
 * @package SQLObject
 */
class XShopSupplier extends SQLObject {

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
     * Get description
     * @return string
     */
    public function getDescription() { return $this->getField('description');}

    /**
     * Set description
     * @param string $description
     */
    public function setDescription($description, $update = false) {$this->setField('description', $description, $update);}

    /**
     * Filter description
     * @param string $description
     */
    public function filterDescription($description) {$this->filterField('description', $description);}

    /**
     * Get contactid
     * @return int
     */
    public function getContactid() { return $this->getField('contactid');}

    /**
     * Set contactid
     * @param int $contactid
     */
    public function setContactid($contactid, $update = false) {$this->setField('contactid', $contactid, $update);}

    /**
     * Filter contactid
     * @param int $contactid
     */
    public function filterContactid($contactid) {$this->filterField('contactid', $contactid);}

    /**
     * Get workflowid
     * @return int
     */
    public function getWorkflowid() { return $this->getField('workflowid');}

    /**
     * Set workflowid
     * @param int $workflowid
     */
    public function setWorkflowid($workflowid, $update = false) {$this->setField('workflowid', $workflowid, $update);}

    /**
     * Filter workflowid
     * @param int $workflowid
     */
    public function filterWorkflowid($workflowid) {$this->filterField('workflowid', $workflowid);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopsupplier');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopSupplier
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopSupplier
     */
    public static function Get($key) {return self::GetObject("XShopSupplier", $key);}

}

SQLObject::SetFieldArray('shopsupplier', array('id', 'name', 'description', 'contactid', 'workflowid'));
SQLObject::SetPrimaryKey('shopsupplier', 'id');
