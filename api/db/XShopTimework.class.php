<?php
/**
 * Class XShopTimework is ORM to table shoptimework
 * @author SQLObject
 * @package SQLObject
 */
class XShopTimework extends SQLObject {

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
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shoptimework');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopTimework
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopTimework
     */
    public static function Get($key) {return self::GetObject("XShopTimework", $key);}

}

SQLObject::SetFieldArray('shoptimework', array('id', 'datefrom', 'dateto', 'comment'));
SQLObject::SetPrimaryKey('shoptimework', 'id');
