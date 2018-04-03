<?php
/**
 * WebProduction Shop (wpshop)
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class User extends XUser {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return User
     */
    public static function Get($key) {
        return self::GetObject("User", $key);
    }

    /**
     * @return User
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return array
     */
    public function makeInfoArray() {
        $a = array();
        $a['id'] = $this->getId();
        $a['login'] = $this->getLogin();
        $a['name'] = $this->makeName();
        $a['email'] = htmlspecialchars($this->getEmail());
        $a['url'] = $this->makeURLEdit();
        $a['logo'] = $this->makeImageThumb(50, 50, 'crop');
        return $a;
    }

    public function makeURLEdit() {
        return Engine::GetLinkMaker()->makeURLByContentIDParam(
        'shop-admin-users-control',
        $this->getId()
        );
    }

    /**
     * @deprecated
     */
    public function makeURLHistory() {
        return $this->makeURLEvent();
    }

    public function makeURLEvent() {
        return Engine::GetLinkMaker()->makeURLByContentIDParam(
        'shop-admin-users-event',
        $this->getId()
        );
    }

    /**
     * Является ли юзер менеджером или админом?
     *
     * @todo admin - not manager!
     *
     * @return bool
     */
    public function isAdmin() {
        return ($this->getLevel() >= 2);
    }

    /**
     * Является ли юзер менеджером?
     *
     * @return bool
     */
    public function isManager() {
        return ($this->getEmployer() == 1);
    }

    /**
     * Проверить, разрешен ли пользователю доступ к ACL-ключу $permissionKey
     *
     * @param string $permissionKey
     * @return bool
     */
    public function isAllowed($permissionKey) {
        try {
            $user = $this;
            if ($user->getLevel() >= 3) {
                return true;
            }
            $role = 'user'.$user->getId();
            return Shop::Get()->getUserService()->getUserACL($user)->isAllowed(
            $role,
            $permissionKey
            );
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Проверить, запрещен ли пользователю доступ к ACL-ключу $permissionKey
     *
     * @param string $permissionKey
     * @return bool
     */
    public function isDenied($permissionKey) {
        return !$this->isAllowed($permissionKey);
    }

    /**
     * Построить URL на Gravatar
     *
     * @deprecated
     *
     * @param int $size
     * @return bool|string
     */
    public function makeImageGravatar($size = 50, $default = false) {
        if ($this->getEmail() && Checker::CheckEmail($this->getEmail())) {
            return "http://www.gravatar.com/avatar/".md5(strtolower($this->getEmail()))."?s=".$size.'&d='.urlencode($default);
        }

        return false;
    }

    /**
     * Получить валюту пользователя.
     * Если валюта не указана - будет выставлена системная.
     *
     * @return ShopCurrency
     */
    public function getCurrency() {
        $currencyID = $this->getCurrencyid();
        if (!$currencyID) {
            try {
                SQLObject::TransactionStart();

                $currencyID = Shop::Get()->getCurrencyService()->getCurrencySystem()->getId();
                $this->setCurrencyid($currencyID);
                $this->update();

                SQLObject::TransactionCommit();
            } catch (Exception $ge) {
                SQLObject::TransactionRollback();
                throw $ge;
            }
        }

        return Shop::Get()->getCurrencyService()->getCurrencyByID($currencyID);
    }

    /**
     * Получить финансовые транзакции пользователя
     *
     * @return ShopCash
     */
    public function getCashTransactions() {
        return Shop::Get()->getCashService()->getUserTransactions($this);
    }

    /**
     * @return User
     */
    public function getManager() {
        return Shop::Get()->getUserService()->getUserByID(
        $this->getManagerid()
        );
    }

    /**
     * @return User
     */
    public function getAuthor() {
        return Shop::Get()->getUserService()->getUserByID(
        $this->getAuthorid()
        );
    }

    /**
     * Посчитать баланс в указанной валюте.
     *
     * Метод править разрешено только Senior'ам!
     *
     * @param ShopCurrency $currency
     * @return float
     */
    public function makeBalance(ShopCurrency $currency) {
        $balance = $this->getBalance();

        $balance = Shop::Get()->getCurrencyService()->convertCurrency(
        $balance,
        $this->getCurrency(),
        $currency
        );

        return $balance;
    }

    public function makeLogin() {
        if ($this->getLogin()){
            return $this->getLogin();
        } else {
            return $this->getEmail();
        }
    }

    /**
     * Построить имя пользователя
     *
     * @param bool $escape
     * @return string
     */
    public function makeName($escape = true, $format = true) {
        $name= $this->getLogin();

        // формат по умолчанию - полный (format == true)
        if ($format === true) {
            if ($this->getPost()) {
                $name .= ' ('.$this->getPost().')';
            }

            if (!$name && $this->getLogin()) {
                $name .= ' @'.$this->getLogin();
            }
        }

        $name = str_replace(',', ', ', $name);
        $name = str_replace('  ', ' ', $name);
        if ($name) {
            if ($escape) {
                $name = htmlspecialchars($name);
            }
            return $name;
        }

        if ($format === true) {
            return '#'.$this->getId();
        }
    }

    /**
     * Получить группу пользователя
     *
     * @return ShopUserGroup
     */
    public function getUserGroup() {
        return Shop::Get()->getUserService()->getUserGroupByID(
        $this->getGroupid()
        );
    }

    /**
     * @return array
     */
    public function makeAssignArrayForDocument() {

        $a['userid'] = $this->getId();

        // все поля
        $tmp = $this->getValues();
        foreach ($tmp as $key => $value) {
            $a['user_'.$key] = nl2br(htmlspecialchars($value));
        }

        return $a;
    }

    /**
     * @return ShopSource
     */
    public function getSource() {
        return Shop::Get()->getShopService()->getSourceByID(
        $this->getSourceid()
        );
    }



    /**
     * @param int $width
     * @param bool $height
     * @param string $method
     * @param bool $changeStubs
     * @return string
     */
    public function makeImageThumb($width = 50, $height = false, $method = 'prop', $changeStubs = false) {
        $src =  MEDIA_PATH.'/shop/stub-man.jpg';

        // получаем формат
        $format = Shop::Get()->getSettingsService()->getSettingValue('image-format');
        $format = strtolower($format);
        if ($format != 'png' && $format != 'jpg') {
            $format = 'jpg';
        }

        return Shop_ImageProcessor::MakeThumbUniversal($src, $width, $height, $method, $format);
    }

    /**
     * @return ShopEvent
     */
    public function getEvents($company = false, $direction = 'all') {
        $contactArray = array();
        $contactID = -1;

        $connection = ConnectionManager::Get()->getConnectionDatabase();


            // реквизиты текущего контакта
            $contactID = $this->getId();

        // находим все события от или на юзера
        $events = new ShopEvent();
        $events->setOrder('cdate', 'DESC');
        if ($direction == 'all') {
            if ($contactArray) {
                $events->addWhereQuery("(`fromuserid` IN (".implode(',', $contactArray).") OR `touserid` IN (".implode(',', $contactArray)."))");
            } else {
                $events->addWhereQuery("(`fromuserid`='{$contactID}' OR `touserid`='{$contactID}')");
            }
        } elseif ($direction == 'from') {
            if ($contactArray) {
                $events->addWhereArray($contactArray, 'fromuserid');
            } else {
                $events->setFromuserid($contactID);
            }
        } elseif ($direction == 'to') {
            if ($contactArray) {
                $events->addWhereArray($contactArray, 'touserid');
            } else {
                $events->setTouserid($contactID);
            }
        } else {
            $events->addWhereQuery('1=0');
        }

        return $events;

    }

    public function insert() {
        if (!$this->getAuthorid()) {
            try {
                $user = Shop::Get()->getUserService()->getUser();
                $this->setAuthorid($user->getId());
            } catch (Exception $e) {

            }
        }

        return parent::insert();
    }

    /**
     * Получить заказы клиента
     *
     * @return ShopOrder
     */
    public function getOrders() {
        $x = Shop::Get()->getShopService()->getOrdersAll();
        $x->setUserid($this->getId());
        return $x;
    }

    /**
     * Получить список ролей
     *
     * @return array
     */
    public function getRoleArray() {
        // получаем список ролей
        $title = trim($this->getPost());
        $titleArray = explode(',', $title);

        $a = array();
        foreach ($titleArray as $x) {
            $x = trim($x);
            if ($x) {
                $a[] = $x;
            }
        }
        return $a;
    }

    public function makeColor() {
        $colorArray = array();
        $colorArray[] = 'aqua';
        $colorArray[] = 'greenyellow';
        $colorArray[] = 'blue';
        $colorArray[] = 'brown';
        $colorArray[] = 'coral';
        $colorArray[] = 'green';
        $colorArray[] = 'gold';
        $colorArray[] = 'silver';
        $colorArray[] = 'crimson';
        $colorArray[] = 'violet';

        $s = $this->getId().'';
        $digit = substr($s, strlen($s) - 1, 1);

        return $colorArray[$digit];
    }

}