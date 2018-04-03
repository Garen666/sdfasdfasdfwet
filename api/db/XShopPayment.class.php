<?php
/**
 * Class XShopPayment is ORM to table shoppayment
 * @author SQLObject
 * @package SQLObject
 */
class XShopPayment extends SQLObject {

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
     * Get image
     * @return string
     */
    public function getImage() { return $this->getField('image');}

    /**
     * Set image
     * @param string $image
     */
    public function setImage($image, $update = false) {$this->setField('image', $image, $update);}

    /**
     * Filter image
     * @param string $image
     */
    public function filterImage($image) {$this->filterField('image', $image);}

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
     * Get contentid
     * @return string
     */
    public function getContentid() { return $this->getField('contentid');}

    /**
     * Set contentid
     * @param string $contentid
     */
    public function setContentid($contentid, $update = false) {$this->setField('contentid', $contentid, $update);}

    /**
     * Filter contentid
     * @param string $contentid
     */
    public function filterContentid($contentid) {$this->filterField('contentid', $contentid);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shoppayment');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopPayment
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopPayment
     */
    public static function Get($key) {return self::GetObject("XShopPayment", $key);}

}

SQLObject::SetFieldArray('shoppayment', array('id', 'name', 'description', 'image', 'hidden', 'contentid'));
SQLObject::SetPrimaryKey('shoppayment', 'id');
