<?php
/**
 * Class XUser is ORM to table users
 * @author SQLObject
 * @package SQLObject
 */
class XUser extends SQLObject {

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
     * Get login
     * @return string
     */
    public function getLogin() { return $this->getField('login');}

    /**
     * Set login
     * @param string $login
     */
    public function setLogin($login, $update = false) {$this->setField('login', $login, $update);}

    /**
     * Filter login
     * @param string $login
     */
    public function filterLogin($login) {$this->filterField('login', $login);}

    /**
     * Get password
     * @return string
     */
    public function getPassword() { return $this->getField('password');}

    /**
     * Set password
     * @param string $password
     */
    public function setPassword($password, $update = false) {$this->setField('password', $password, $update);}

    /**
     * Filter password
     * @param string $password
     */
    public function filterPassword($password) {$this->filterField('password', $password);}

    /**
     * Get level
     * @return int
     */
    public function getLevel() { return $this->getField('level');}

    /**
     * Set level
     * @param int $level
     */
    public function setLevel($level, $update = false) {$this->setField('level', $level, $update);}

    /**
     * Filter level
     * @param int $level
     */
    public function filterLevel($level) {$this->filterField('level', $level);}

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
     * Get adate
     * @return string
     */
    public function getAdate() { return $this->getField('adate');}

    /**
     * Set adate
     * @param string $adate
     */
    public function setAdate($adate, $update = false) {$this->setField('adate', $adate, $update);}

    /**
     * Filter adate
     * @param string $adate
     */
    public function filterAdate($adate) {$this->filterField('adate', $adate);}

    /**
     * Get sdate
     * @return string
     */
    public function getSdate() { return $this->getField('sdate');}

    /**
     * Set sdate
     * @param string $sdate
     */
    public function setSdate($sdate, $update = false) {$this->setField('sdate', $sdate, $update);}

    /**
     * Filter sdate
     * @param string $sdate
     */
    public function filterSdate($sdate) {$this->filterField('sdate', $sdate);}

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
     * Get sid
     * @return string
     */
    public function getSid() { return $this->getField('sid');}

    /**
     * Set sid
     * @param string $sid
     */
    public function setSid($sid, $update = false) {$this->setField('sid', $sid, $update);}

    /**
     * Filter sid
     * @param string $sid
     */
    public function filterSid($sid) {$this->filterField('sid', $sid);}

    /**
     * Get email
     * @return string
     */
    public function getEmail() { return $this->getField('email');}

    /**
     * Set email
     * @param string $email
     */
    public function setEmail($email, $update = false) {$this->setField('email', $email, $update);}

    /**
     * Filter email
     * @param string $email
     */
    public function filterEmail($email) {$this->filterField('email', $email);}

    /**
     * Get commentadmin
     * @return string
     */
    public function getCommentadmin() { return $this->getField('commentadmin');}

    /**
     * Set commentadmin
     * @param string $commentadmin
     */
    public function setCommentadmin($commentadmin, $update = false) {$this->setField('commentadmin', $commentadmin, $update);}

    /**
     * Filter commentadmin
     * @param string $commentadmin
     */
    public function filterCommentadmin($commentadmin) {$this->filterField('commentadmin', $commentadmin);}

    /**
     * Get post
     * @return string
     */
    public function getPost() { return $this->getField('post');}

    /**
     * Set post
     * @param string $post
     */
    public function setPost($post, $update = false) {$this->setField('post', $post, $update);}

    /**
     * Filter post
     * @param string $post
     */
    public function filterPost($post) {$this->filterField('post', $post);}

    /**
     * Get groupid
     * @return int
     */
    public function getGroupid() { return $this->getField('groupid');}

    /**
     * Set groupid
     * @param int $groupid
     */
    public function setGroupid($groupid, $update = false) {$this->setField('groupid', $groupid, $update);}

    /**
     * Filter groupid
     * @param int $groupid
     */
    public function filterGroupid($groupid) {$this->filterField('groupid', $groupid);}

    /**
     * Get activatecode
     * @return string
     */
    public function getActivatecode() { return $this->getField('activatecode');}

    /**
     * Set activatecode
     * @param string $activatecode
     */
    public function setActivatecode($activatecode, $update = false) {$this->setField('activatecode', $activatecode, $update);}

    /**
     * Filter activatecode
     * @param string $activatecode
     */
    public function filterActivatecode($activatecode) {$this->filterField('activatecode', $activatecode);}

    /**
     * Get distribution
     * @return int
     */
    public function getDistribution() { return $this->getField('distribution');}

    /**
     * Set distribution
     * @param int $distribution
     */
    public function setDistribution($distribution, $update = false) {$this->setField('distribution', $distribution, $update);}

    /**
     * Filter distribution
     * @param int $distribution
     */
    public function filterDistribution($distribution) {$this->filterField('distribution', $distribution);}

    /**
     * Get edate
     * @return string
     */
    public function getEdate() { return $this->getField('edate');}

    /**
     * Set edate
     * @param string $edate
     */
    public function setEdate($edate, $update = false) {$this->setField('edate', $edate, $update);}

    /**
     * Filter edate
     * @param string $edate
     */
    public function filterEdate($edate) {$this->filterField('edate', $edate);}

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
     * Get employer
     * @return int
     */
    public function getEmployer() { return $this->getField('employer');}

    /**
     * Set employer
     * @param int $employer
     */
    public function setEmployer($employer, $update = false) {$this->setField('employer', $employer, $update);}

    /**
     * Filter employer
     * @param int $employer
     */
    public function filterEmployer($employer) {$this->filterField('employer', $employer);}

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
     * Get identifier
     * @return string
     */
    public function getIdentifier() { return $this->getField('identifier');}

    /**
     * Set identifier
     * @param string $identifier
     */
    public function setIdentifier($identifier, $update = false) {$this->setField('identifier', $identifier, $update);}

    /**
     * Filter identifier
     * @param string $identifier
     */
    public function filterIdentifier($identifier) {$this->filterField('identifier', $identifier);}

    /**
     * Create an object
     * @param int $id
     */
    public function __construct($id = 0) {
        $this->setTablename('users');
        $this->setClassname(__CLASS__);
        parent::__construct($id);
    }

    /**
     * @return XUser
     */
    public function getNext($exception = false) {return parent::getNext($exception); }

    /**
     * @return XUser
     */
    public static function Get($key) {return self::GetObject("XUser", $key);}

}

SQLObject::SetFieldArray('users', array('id', 'login', 'password', 'level', 'cdate', 'adate', 'sdate', 'ip', 'sid', 'email', 'commentadmin', 'post', 'groupid', 'activatecode', 'distribution', 'edate', 'udate', 'sourceid', 'authorid', 'employer', 'utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term', 'utm_date', 'utm_referrer', 'identifier'));
SQLObject::SetPrimaryKey('users', 'id');
