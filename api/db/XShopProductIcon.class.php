<?php
/**
 * Class XShopProductIcon is ORM to table shopproducticon
 * @author SQLObject
 * @package SQLObject
 */
class XShopProductIcon extends SQLObject {

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
     * Get url
     * @return string
     */
    public function getUrl() { return $this->getField('url');}

    /**
     * Set url
     * @param string $url
     */
    public function setUrl($url, $update = false) {$this->setField('url', $url, $update);}

    /**
     * Filter url
     * @param string $url
     */
    public function filterUrl($url) {$this->filterField('url', $url);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shopproducticon');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopProductIcon
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopProductIcon
     */
    public static function Get($key) {return self::GetObject("XShopProductIcon", $key);}

}

SQLObject::SetFieldArray('shopproducticon', array('id', 'name', 'image', 'url'));
SQLObject::SetPrimaryKey('shopproducticon', 'id');
