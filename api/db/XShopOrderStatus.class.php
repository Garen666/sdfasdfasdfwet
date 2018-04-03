<?php
/**
 * Class XShopOrderStatus is ORM to table shoporderstatus
 * @author SQLObject
 * @package SQLObject
 */
class XShopOrderStatus extends SQLObject {

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
     * Get message
     * @return string
     */
    public function getMessage() { return $this->getField('message');}

    /**
     * Set message
     * @param string $message
     */
    public function setMessage($message, $update = false) {$this->setField('message', $message, $update);}

    /**
     * Filter message
     * @param string $message
     */
    public function filterMessage($message) {$this->filterField('message', $message);}

    /**
     * Get messageadmin
     * @return string
     */
    public function getMessageadmin() { return $this->getField('messageadmin');}

    /**
     * Set messageadmin
     * @param string $messageadmin
     */
    public function setMessageadmin($messageadmin, $update = false) {$this->setField('messageadmin', $messageadmin, $update);}

    /**
     * Filter messageadmin
     * @param string $messageadmin
     */
    public function filterMessageadmin($messageadmin) {$this->filterField('messageadmin', $messageadmin);}

    /**
     * Get default
     * @return int
     */
    public function getDefault() { return $this->getField('default');}

    /**
     * Set default
     * @param int $default
     */
    public function setDefault($default, $update = false) {$this->setField('default', $default, $update);}

    /**
     * Filter default
     * @param int $default
     */
    public function filterDefault($default) {$this->filterField('default', $default);}

    /**
     * Get sort
     * @return int
     */
    public function getSort() { return $this->getField('sort');}

    /**
     * Set sort
     * @param int $sort
     */
    public function setSort($sort, $update = false) {$this->setField('sort', $sort, $update);}

    /**
     * Filter sort
     * @param int $sort
     */
    public function filterSort($sort) {$this->filterField('sort', $sort);}

    /**
     * Get priority
     * @return int
     */
    public function getPriority() { return $this->getField('priority');}

    /**
     * Set priority
     * @param int $priority
     */
    public function setPriority($priority, $update = false) {$this->setField('priority', $priority, $update);}

    /**
     * Filter priority
     * @param int $priority
     */
    public function filterPriority($priority) {$this->filterField('priority', $priority);}

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
     * Get x
     * @return int
     */
    public function getX() { return $this->getField('x');}

    /**
     * Set x
     * @param int $x
     */
    public function setX($x, $update = false) {$this->setField('x', $x, $update);}

    /**
     * Filter x
     * @param int $x
     */
    public function filterX($x) {$this->filterField('x', $x);}

    /**
     * Get y
     * @return int
     */
    public function getY() { return $this->getField('y');}

    /**
     * Set y
     * @param int $y
     */
    public function setY($y, $update = false) {$this->setField('y', $y, $update);}

    /**
     * Filter y
     * @param int $y
     */
    public function filterY($y) {$this->filterField('y', $y);}

    /**
     * Get width
     * @return int
     */
    public function getWidth() { return $this->getField('width');}

    /**
     * Set width
     * @param int $width
     */
    public function setWidth($width, $update = false) {$this->setField('width', $width, $update);}

    /**
     * Filter width
     * @param int $width
     */
    public function filterWidth($width) {$this->filterField('width', $width);}

    /**
     * Get height
     * @return int
     */
    public function getHeight() { return $this->getField('height');}

    /**
     * Set height
     * @param int $height
     */
    public function setHeight($height, $update = false) {$this->setField('height', $height, $update);}

    /**
     * Filter height
     * @param int $height
     */
    public function filterHeight($height) {$this->filterField('height', $height);}

    /**
     * Get colour
     * @return string
     */
    public function getColour() { return $this->getField('colour');}

    /**
     * Set colour
     * @param string $colour
     */
    public function setColour($colour, $update = false) {$this->setField('colour', $colour, $update);}

    /**
     * Filter colour
     * @param string $colour
     */
    public function filterColour($colour) {$this->filterField('colour', $colour);}

    /**
     * Get term
     * @return int
     */
    public function getTerm() { return $this->getField('term');}

    /**
     * Set term
     * @param int $term
     */
    public function setTerm($term, $update = false) {$this->setField('term', $term, $update);}

    /**
     * Filter term
     * @param int $term
     */
    public function filterTerm($term) {$this->filterField('term', $term);}

    /**
     * Get termperiod
     * @return string
     */
    public function getTermperiod() { return $this->getField('termperiod');}

    /**
     * Set termperiod
     * @param string $termperiod
     */
    public function setTermperiod($termperiod, $update = false) {$this->setField('termperiod', $termperiod, $update);}

    /**
     * Filter termperiod
     * @param string $termperiod
     */
    public function filterTermperiod($termperiod) {$this->filterField('termperiod', $termperiod);}

    /**
     * Get processor
     * @return string
     */
    public function getProcessor() { return $this->getField('processor');}

    /**
     * Set processor
     * @param string $processor
     */
    public function setProcessor($processor, $update = false) {$this->setField('processor', $processor, $update);}

    /**
     * Filter processor
     * @param string $processor
     */
    public function filterProcessor($processor) {$this->filterField('processor', $processor);}

    /**
     * Get roleid
     * @return int
     */
    public function getRoleid() { return $this->getField('roleid');}

    /**
     * Set roleid
     * @param int $roleid
     */
    public function setRoleid($roleid, $update = false) {$this->setField('roleid', $roleid, $update);}

    /**
     * Filter roleid
     * @param int $roleid
     */
    public function filterRoleid($roleid) {$this->filterField('roleid', $roleid);}

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
     * Get cnt
     * @return int
     */
    public function getCnt() { return $this->getField('cnt');}

    /**
     * Set cnt
     * @param int $cnt
     */
    public function setCnt($cnt, $update = false) {$this->setField('cnt', $cnt, $update);}

    /**
     * Filter cnt
     * @param int $cnt
     */
    public function filterCnt($cnt) {$this->filterField('cnt', $cnt);}

    /**
     * Get cntlast
     * @return int
     */
    public function getCntlast() { return $this->getField('cntlast');}

    /**
     * Set cntlast
     * @param int $cntlast
     */
    public function setCntlast($cntlast, $update = false) {$this->setField('cntlast', $cntlast, $update);}

    /**
     * Filter cntlast
     * @param int $cntlast
     */
    public function filterCntlast($cntlast) {$this->filterField('cntlast', $cntlast);}

    /**
     * Get smart
     * @return string
     */
    public function getSmart() { return $this->getField('smart');}

    /**
     * Set smart
     * @param string $smart
     */
    public function setSmart($smart, $update = false) {$this->setField('smart', $smart, $update);}

    /**
     * Filter smart
     * @param string $smart
     */
    public function filterSmart($smart) {$this->filterField('smart', $smart);}

    /**
     * Get onlyauto
     * @return int
     */
    public function getOnlyauto() { return $this->getField('onlyauto');}

    /**
     * Set onlyauto
     * @param int $onlyauto
     */
    public function setOnlyauto($onlyauto, $update = false) {$this->setField('onlyauto', $onlyauto, $update);}

    /**
     * Filter onlyauto
     * @param int $onlyauto
     */
    public function filterOnlyauto($onlyauto) {$this->filterField('onlyauto', $onlyauto);}

    /**
     * Get onlyissue
     * @return int
     */
    public function getOnlyissue() { return $this->getField('onlyissue');}

    /**
     * Set onlyissue
     * @param int $onlyissue
     */
    public function setOnlyissue($onlyissue, $update = false) {$this->setField('onlyissue', $onlyissue, $update);}

    /**
     * Filter onlyissue
     * @param int $onlyissue
     */
    public function filterOnlyissue($onlyissue) {$this->filterField('onlyissue', $onlyissue);}

    /**
     * Get jumpmanager
     * @return int
     */
    public function getJumpmanager() { return $this->getField('jumpmanager');}

    /**
     * Set jumpmanager
     * @param int $jumpmanager
     */
    public function setJumpmanager($jumpmanager, $update = false) {$this->setField('jumpmanager', $jumpmanager, $update);}

    /**
     * Filter jumpmanager
     * @param int $jumpmanager
     */
    public function filterJumpmanager($jumpmanager) {$this->filterField('jumpmanager', $jumpmanager);}

    /**
     * Get prepayed
     * @return int
     */
    public function getPrepayed() { return $this->getField('prepayed');}

    /**
     * Set prepayed
     * @param int $prepayed
     */
    public function setPrepayed($prepayed, $update = false) {$this->setField('prepayed', $prepayed, $update);}

    /**
     * Filter prepayed
     * @param int $prepayed
     */
    public function filterPrepayed($prepayed) {$this->filterField('prepayed', $prepayed);}

    /**
     * Get notifyemailclient
     * @return int
     */
    public function getNotifyemailclient() { return $this->getField('notifyemailclient');}

    /**
     * Set notifyemailclient
     * @param int $notifyemailclient
     */
    public function setNotifyemailclient($notifyemailclient, $update = false) {$this->setField('notifyemailclient', $notifyemailclient, $update);}

    /**
     * Filter notifyemailclient
     * @param int $notifyemailclient
     */
    public function filterNotifyemailclient($notifyemailclient) {$this->filterField('notifyemailclient', $notifyemailclient);}

    /**
     * Get notifyemailadmin
     * @return int
     */
    public function getNotifyemailadmin() { return $this->getField('notifyemailadmin');}

    /**
     * Set notifyemailadmin
     * @param int $notifyemailadmin
     */
    public function setNotifyemailadmin($notifyemailadmin, $update = false) {$this->setField('notifyemailadmin', $notifyemailadmin, $update);}

    /**
     * Filter notifyemailadmin
     * @param int $notifyemailadmin
     */
    public function filterNotifyemailadmin($notifyemailadmin) {$this->filterField('notifyemailadmin', $notifyemailadmin);}

    /**
     * Get notifyemailmanager
     * @return int
     */
    public function getNotifyemailmanager() { return $this->getField('notifyemailmanager');}

    /**
     * Set notifyemailmanager
     * @param int $notifyemailmanager
     */
    public function setNotifyemailmanager($notifyemailmanager, $update = false) {$this->setField('notifyemailmanager', $notifyemailmanager, $update);}

    /**
     * Filter notifyemailmanager
     * @param int $notifyemailmanager
     */
    public function filterNotifyemailmanager($notifyemailmanager) {$this->filterField('notifyemailmanager', $notifyemailmanager);}

    /**
     * Get needcontent
     * @return int
     */
    public function getNeedcontent() { return $this->getField('needcontent');}

    /**
     * Set needcontent
     * @param int $needcontent
     */
    public function setNeedcontent($needcontent, $update = false) {$this->setField('needcontent', $needcontent, $update);}

    /**
     * Filter needcontent
     * @param int $needcontent
     */
    public function filterNeedcontent($needcontent) {$this->filterField('needcontent', $needcontent);}

    /**
     * Get needdocument
     * @return int
     */
    public function getNeeddocument() { return $this->getField('needdocument');}

    /**
     * Set needdocument
     * @param int $needdocument
     */
    public function setNeeddocument($needdocument, $update = false) {$this->setField('needdocument', $needdocument, $update);}

    /**
     * Filter needdocument
     * @param int $needdocument
     */
    public function filterNeeddocument($needdocument) {$this->filterField('needdocument', $needdocument);}

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
     * Get shipped
     * @return int
     */
    public function getShipped() { return $this->getField('shipped');}

    /**
     * Set shipped
     * @param int $shipped
     */
    public function setShipped($shipped, $update = false) {$this->setField('shipped', $shipped, $update);}

    /**
     * Filter shipped
     * @param int $shipped
     */
    public function filterShipped($shipped) {$this->filterField('shipped', $shipped);}

    /**
     * Get autorepeatperiod
     * @return string
     */
    public function getAutorepeatperiod() { return $this->getField('autorepeatperiod');}

    /**
     * Set autorepeatperiod
     * @param string $autorepeatperiod
     */
    public function setAutorepeatperiod($autorepeatperiod, $update = false) {$this->setField('autorepeatperiod', $autorepeatperiod, $update);}

    /**
     * Filter autorepeatperiod
     * @param string $autorepeatperiod
     */
    public function filterAutorepeatperiod($autorepeatperiod) {$this->filterField('autorepeatperiod', $autorepeatperiod);}

    /**
     * Get autorepeatterm
     * @return int
     */
    public function getAutorepeatterm() { return $this->getField('autorepeatterm');}

    /**
     * Set autorepeatterm
     * @param int $autorepeatterm
     */
    public function setAutorepeatterm($autorepeatterm, $update = false) {$this->setField('autorepeatterm', $autorepeatterm, $update);}

    /**
     * Filter autorepeatterm
     * @param int $autorepeatterm
     */
    public function filterAutorepeatterm($autorepeatterm) {$this->filterField('autorepeatterm', $autorepeatterm);}

    /**
     * Get subworkflow1
     * @return int
     */
    public function getSubworkflow1() { return $this->getField('subworkflow1');}

    /**
     * Set subworkflow1
     * @param int $subworkflow1
     */
    public function setSubworkflow1($subworkflow1, $update = false) {$this->setField('subworkflow1', $subworkflow1, $update);}

    /**
     * Filter subworkflow1
     * @param int $subworkflow1
     */
    public function filterSubworkflow1($subworkflow1) {$this->filterField('subworkflow1', $subworkflow1);}

    /**
     * Get subworkflow1name
     * @return string
     */
    public function getSubworkflow1name() { return $this->getField('subworkflow1name');}

    /**
     * Set subworkflow1name
     * @param string $subworkflow1name
     */
    public function setSubworkflow1name($subworkflow1name, $update = false) {$this->setField('subworkflow1name', $subworkflow1name, $update);}

    /**
     * Filter subworkflow1name
     * @param string $subworkflow1name
     */
    public function filterSubworkflow1name($subworkflow1name) {$this->filterField('subworkflow1name', $subworkflow1name);}

    /**
     * Get subworkflow2
     * @return int
     */
    public function getSubworkflow2() { return $this->getField('subworkflow2');}

    /**
     * Set subworkflow2
     * @param int $subworkflow2
     */
    public function setSubworkflow2($subworkflow2, $update = false) {$this->setField('subworkflow2', $subworkflow2, $update);}

    /**
     * Filter subworkflow2
     * @param int $subworkflow2
     */
    public function filterSubworkflow2($subworkflow2) {$this->filterField('subworkflow2', $subworkflow2);}

    /**
     * Get subworkflow2name
     * @return string
     */
    public function getSubworkflow2name() { return $this->getField('subworkflow2name');}

    /**
     * Set subworkflow2name
     * @param string $subworkflow2name
     */
    public function setSubworkflow2name($subworkflow2name, $update = false) {$this->setField('subworkflow2name', $subworkflow2name, $update);}

    /**
     * Filter subworkflow2name
     * @param string $subworkflow2name
     */
    public function filterSubworkflow2name($subworkflow2name) {$this->filterField('subworkflow2name', $subworkflow2name);}

    /**
     * Get subworkflow3
     * @return int
     */
    public function getSubworkflow3() { return $this->getField('subworkflow3');}

    /**
     * Set subworkflow3
     * @param int $subworkflow3
     */
    public function setSubworkflow3($subworkflow3, $update = false) {$this->setField('subworkflow3', $subworkflow3, $update);}

    /**
     * Filter subworkflow3
     * @param int $subworkflow3
     */
    public function filterSubworkflow3($subworkflow3) {$this->filterField('subworkflow3', $subworkflow3);}

    /**
     * Get subworkflow3name
     * @return string
     */
    public function getSubworkflow3name() { return $this->getField('subworkflow3name');}

    /**
     * Set subworkflow3name
     * @param string $subworkflow3name
     */
    public function setSubworkflow3name($subworkflow3name, $update = false) {$this->setField('subworkflow3name', $subworkflow3name, $update);}

    /**
     * Filter subworkflow3name
     * @param string $subworkflow3name
     */
    public function filterSubworkflow3name($subworkflow3name) {$this->filterField('subworkflow3name', $subworkflow3name);}

    /**
     * Get subworkflow4
     * @return int
     */
    public function getSubworkflow4() { return $this->getField('subworkflow4');}

    /**
     * Set subworkflow4
     * @param int $subworkflow4
     */
    public function setSubworkflow4($subworkflow4, $update = false) {$this->setField('subworkflow4', $subworkflow4, $update);}

    /**
     * Filter subworkflow4
     * @param int $subworkflow4
     */
    public function filterSubworkflow4($subworkflow4) {$this->filterField('subworkflow4', $subworkflow4);}

    /**
     * Get subworkflow4name
     * @return string
     */
    public function getSubworkflow4name() { return $this->getField('subworkflow4name');}

    /**
     * Set subworkflow4name
     * @param string $subworkflow4name
     */
    public function setSubworkflow4name($subworkflow4name, $update = false) {$this->setField('subworkflow4name', $subworkflow4name, $update);}

    /**
     * Filter subworkflow4name
     * @param string $subworkflow4name
     */
    public function filterSubworkflow4name($subworkflow4name) {$this->filterField('subworkflow4name', $subworkflow4name);}

    /**
     * Get subworkflow5
     * @return int
     */
    public function getSubworkflow5() { return $this->getField('subworkflow5');}

    /**
     * Set subworkflow5
     * @param int $subworkflow5
     */
    public function setSubworkflow5($subworkflow5, $update = false) {$this->setField('subworkflow5', $subworkflow5, $update);}

    /**
     * Filter subworkflow5
     * @param int $subworkflow5
     */
    public function filterSubworkflow5($subworkflow5) {$this->filterField('subworkflow5', $subworkflow5);}

    /**
     * Get subworkflow5name
     * @return string
     */
    public function getSubworkflow5name() { return $this->getField('subworkflow5name');}

    /**
     * Set subworkflow5name
     * @param string $subworkflow5name
     */
    public function setSubworkflow5name($subworkflow5name, $update = false) {$this->setField('subworkflow5name', $subworkflow5name, $update);}

    /**
     * Filter subworkflow5name
     * @param string $subworkflow5name
     */
    public function filterSubworkflow5name($subworkflow5name) {$this->filterField('subworkflow5name', $subworkflow5name);}

    /**
     * Get subworkflow6
     * @return int
     */
    public function getSubworkflow6() { return $this->getField('subworkflow6');}

    /**
     * Set subworkflow6
     * @param int $subworkflow6
     */
    public function setSubworkflow6($subworkflow6, $update = false) {$this->setField('subworkflow6', $subworkflow6, $update);}

    /**
     * Filter subworkflow6
     * @param int $subworkflow6
     */
    public function filterSubworkflow6($subworkflow6) {$this->filterField('subworkflow6', $subworkflow6);}

    /**
     * Get subworkflow6name
     * @return string
     */
    public function getSubworkflow6name() { return $this->getField('subworkflow6name');}

    /**
     * Set subworkflow6name
     * @param string $subworkflow6name
     */
    public function setSubworkflow6name($subworkflow6name, $update = false) {$this->setField('subworkflow6name', $subworkflow6name, $update);}

    /**
     * Filter subworkflow6name
     * @param string $subworkflow6name
     */
    public function filterSubworkflow6name($subworkflow6name) {$this->filterField('subworkflow6name', $subworkflow6name);}

    /**
     * Get subworkflow7
     * @return int
     */
    public function getSubworkflow7() { return $this->getField('subworkflow7');}

    /**
     * Set subworkflow7
     * @param int $subworkflow7
     */
    public function setSubworkflow7($subworkflow7, $update = false) {$this->setField('subworkflow7', $subworkflow7, $update);}

    /**
     * Filter subworkflow7
     * @param int $subworkflow7
     */
    public function filterSubworkflow7($subworkflow7) {$this->filterField('subworkflow7', $subworkflow7);}

    /**
     * Get subworkflow7name
     * @return string
     */
    public function getSubworkflow7name() { return $this->getField('subworkflow7name');}

    /**
     * Set subworkflow7name
     * @param string $subworkflow7name
     */
    public function setSubworkflow7name($subworkflow7name, $update = false) {$this->setField('subworkflow7name', $subworkflow7name, $update);}

    /**
     * Filter subworkflow7name
     * @param string $subworkflow7name
     */
    public function filterSubworkflow7name($subworkflow7name) {$this->filterField('subworkflow7name', $subworkflow7name);}

    /**
     * Get subworkflow8
     * @return int
     */
    public function getSubworkflow8() { return $this->getField('subworkflow8');}

    /**
     * Set subworkflow8
     * @param int $subworkflow8
     */
    public function setSubworkflow8($subworkflow8, $update = false) {$this->setField('subworkflow8', $subworkflow8, $update);}

    /**
     * Filter subworkflow8
     * @param int $subworkflow8
     */
    public function filterSubworkflow8($subworkflow8) {$this->filterField('subworkflow8', $subworkflow8);}

    /**
     * Get subworkflow8name
     * @return string
     */
    public function getSubworkflow8name() { return $this->getField('subworkflow8name');}

    /**
     * Set subworkflow8name
     * @param string $subworkflow8name
     */
    public function setSubworkflow8name($subworkflow8name, $update = false) {$this->setField('subworkflow8name', $subworkflow8name, $update);}

    /**
     * Filter subworkflow8name
     * @param string $subworkflow8name
     */
    public function filterSubworkflow8name($subworkflow8name) {$this->filterField('subworkflow8name', $subworkflow8name);}

    /**
     * Get subworkflow9
     * @return int
     */
    public function getSubworkflow9() { return $this->getField('subworkflow9');}

    /**
     * Set subworkflow9
     * @param int $subworkflow9
     */
    public function setSubworkflow9($subworkflow9, $update = false) {$this->setField('subworkflow9', $subworkflow9, $update);}

    /**
     * Filter subworkflow9
     * @param int $subworkflow9
     */
    public function filterSubworkflow9($subworkflow9) {$this->filterField('subworkflow9', $subworkflow9);}

    /**
     * Get subworkflow9name
     * @return string
     */
    public function getSubworkflow9name() { return $this->getField('subworkflow9name');}

    /**
     * Set subworkflow9name
     * @param string $subworkflow9name
     */
    public function setSubworkflow9name($subworkflow9name, $update = false) {$this->setField('subworkflow9name', $subworkflow9name, $update);}

    /**
     * Filter subworkflow9name
     * @param string $subworkflow9name
     */
    public function filterSubworkflow9name($subworkflow9name) {$this->filterField('subworkflow9name', $subworkflow9name);}

    /**
     * Get subworkflow10
     * @return int
     */
    public function getSubworkflow10() { return $this->getField('subworkflow10');}

    /**
     * Set subworkflow10
     * @param int $subworkflow10
     */
    public function setSubworkflow10($subworkflow10, $update = false) {$this->setField('subworkflow10', $subworkflow10, $update);}

    /**
     * Filter subworkflow10
     * @param int $subworkflow10
     */
    public function filterSubworkflow10($subworkflow10) {$this->filterField('subworkflow10', $subworkflow10);}

    /**
     * Get subworkflow10name
     * @return string
     */
    public function getSubworkflow10name() { return $this->getField('subworkflow10name');}

    /**
     * Set subworkflow10name
     * @param string $subworkflow10name
     */
    public function setSubworkflow10name($subworkflow10name, $update = false) {$this->setField('subworkflow10name', $subworkflow10name, $update);}

    /**
     * Filter subworkflow10name
     * @param string $subworkflow10name
     */
    public function filterSubworkflow10name($subworkflow10name) {$this->filterField('subworkflow10name', $subworkflow10name);}

    /**
     * Get storage_incoming
     * @return int
     */
    public function getStorage_incoming() { return $this->getField('storage_incoming');}

    /**
     * Set storage_incoming
     * @param int $storage_incoming
     */
    public function setStorage_incoming($storage_incoming, $update = false) {$this->setField('storage_incoming', $storage_incoming, $update);}

    /**
     * Filter storage_incoming
     * @param int $storage_incoming
     */
    public function filterStorage_incoming($storage_incoming) {$this->filterField('storage_incoming', $storage_incoming);}

    /**
     * Get storagenameid_incoming
     * @return int
     */
    public function getStoragenameid_incoming() { return $this->getField('storagenameid_incoming');}

    /**
     * Set storagenameid_incoming
     * @param int $storagenameid_incoming
     */
    public function setStoragenameid_incoming($storagenameid_incoming, $update = false) {$this->setField('storagenameid_incoming', $storagenameid_incoming, $update);}

    /**
     * Filter storagenameid_incoming
     * @param int $storagenameid_incoming
     */
    public function filterStoragenameid_incoming($storagenameid_incoming) {$this->filterField('storagenameid_incoming', $storagenameid_incoming);}

    /**
     * Get storage_sale
     * @return int
     */
    public function getStorage_sale() { return $this->getField('storage_sale');}

    /**
     * Set storage_sale
     * @param int $storage_sale
     */
    public function setStorage_sale($storage_sale, $update = false) {$this->setField('storage_sale', $storage_sale, $update);}

    /**
     * Filter storage_sale
     * @param int $storage_sale
     */
    public function filterStorage_sale($storage_sale) {$this->filterField('storage_sale', $storage_sale);}

    /**
     * Get storage_reserve
     * @return int
     */
    public function getStorage_reserve() { return $this->getField('storage_reserve');}

    /**
     * Set storage_reserve
     * @param int $storage_reserve
     */
    public function setStorage_reserve($storage_reserve, $update = false) {$this->setField('storage_reserve', $storage_reserve, $update);}

    /**
     * Filter storage_reserve
     * @param int $storage_reserve
     */
    public function filterStorage_reserve($storage_reserve) {$this->filterField('storage_reserve', $storage_reserve);}

    /**
     * Get storage_unreserve
     * @return int
     */
    public function getStorage_unreserve() { return $this->getField('storage_unreserve');}

    /**
     * Set storage_unreserve
     * @param int $storage_unreserve
     */
    public function setStorage_unreserve($storage_unreserve, $update = false) {$this->setField('storage_unreserve', $storage_unreserve, $update);}

    /**
     * Filter storage_unreserve
     * @param int $storage_unreserve
     */
    public function filterStorage_unreserve($storage_unreserve) {$this->filterField('storage_unreserve', $storage_unreserve);}

    /**
     * Get storage_return
     * @return int
     */
    public function getStorage_return() { return $this->getField('storage_return');}

    /**
     * Set storage_return
     * @param int $storage_return
     */
    public function setStorage_return($storage_return, $update = false) {$this->setField('storage_return', $storage_return, $update);}

    /**
     * Filter storage_return
     * @param int $storage_return
     */
    public function filterStorage_return($storage_return) {$this->filterField('storage_return', $storage_return);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('shoporderstatus');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XShopOrderStatus
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XShopOrderStatus
     */
    public static function Get($key) {return self::GetObject("XShopOrderStatus", $key);}

}

SQLObject::SetFieldArray('shoporderstatus', array('id', 'name', 'message', 'messageadmin', 'default', 'sort', 'priority', 'linkkey', 'categoryid', 'content', 'x', 'y', 'width', 'height', 'colour', 'term', 'termperiod', 'processor', 'roleid', 'managerid', 'cnt', 'cntlast', 'smart', 'onlyauto', 'onlyissue', 'jumpmanager', 'prepayed', 'notifyemailclient', 'notifyemailadmin', 'notifyemailmanager', 'needcontent', 'needdocument', 'closed', 'shipped', 'autorepeatperiod', 'autorepeatterm', 'subworkflow1', 'subworkflow1name', 'subworkflow2', 'subworkflow2name', 'subworkflow3', 'subworkflow3name', 'subworkflow4', 'subworkflow4name', 'subworkflow5', 'subworkflow5name', 'subworkflow6', 'subworkflow6name', 'subworkflow7', 'subworkflow7name', 'subworkflow8', 'subworkflow8name', 'subworkflow9', 'subworkflow9name', 'subworkflow10', 'subworkflow10name', 'storage_incoming', 'storagenameid_incoming', 'storage_sale', 'storage_reserve', 'storage_unreserve', 'storage_return'));
SQLObject::SetPrimaryKey('shoporderstatus', 'id');
