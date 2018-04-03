<?php
/**
 * WebProduction Shop (wpshop)
 * @copyright (C) 2011-2014 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Shop_UserService extends ServiceUtils_UserService {

    /**
     * @return User
     */
    public function getUsersAll($user = false) {
        $x = parent::getUsersAll();
        $x->setOrder(array('login'), 'ASC');

        if ($user) {
            // накладываем ACL
            if ($user->getLevel() >= 3) {
                return $x;
            }

            // фильтр по уровню
            $levelArray = array(-1);
            for ($j = 0; $j <= 3; $j++) {
                if ($user->isAllowed('users-level-'.$j.'-view')) {
                    $levelArray[] = $j;
                }
            }
            $x->addWhereArray($levelArray, 'level');

            if ($user->isAllowed('users-all-view')) {
                return $x;
            }

            $userID = $user->getId();

            // фильтр по группе
            $groups = $this->getUserGroupsAll();
            $groupIDArray = array(-1);
            while ($group = $groups->getNext()) {
                if ($user->isAllowed('users-group-'.$group->getId().'-view')) {
                    $groupIDArray[] = $group->getId();
                }
            }
            if ($user->isAllowed('users-group-0-view')) {
                $groupIDArray[] = 0;
            }
            $x->addWhereArray($groupIDArray, 'groupid');

            // фильтр по менеджеру
            $managers = Shop::Get()->getUserService()->getUsersManagers();
            $managerIDArray = array($userID); // свои видно всегда
            while ($m = $managers->getNext()) {
                if ($user->isAllowed('users-manager-'.$m->getId().'-view')) {
                    $managerIDArray[] = $m->getId();
                }
            }
            if ($user->isAllowed('users-manager-0-view')) {
                $managerIDArray[] = 0;
            }
            $x->addWhereArray($managerIDArray, 'managerid');
        }

        return $x;
    }

    /**
     * @return User
     */
    public function addUser($login, $password, $email, $name, $phone, $address, $bdate, $parentid,
    $level = false, $commentadmin = false, $groupid = false, $pricelevel = 0, $distribution = false,
    $tags = false, $namelast=false, $namemiddle=false) {
        $selfRegister = false;
        try {
            $this->getUser();
        } catch (Exception $e) {
            $selfRegister = true;
        }
        try {
            SQLObject::TransactionStart();

            $name = trim($name);
            $login = trim($login);
            $email = trim($email);
            $address = trim($address);
            $bdate = trim($bdate);
            $parentid = trim($parentid);
            $namelast = trim($namelast);
            $namemiddle = trim($namemiddle);

            $tags = $this->_checkTags($tags);

            $pricelevel = (int) $pricelevel;
            if ($pricelevel < 0) {
                $pricelevel = 0;
            }
            if ($pricelevel > 5) {
                $pricelevel = 5;
            }

            // нужно ли активировать аккаунты?
            $activate = Shop::Get()->getSettingsService()->getSettingValue('user-account-activate');

            $ex = new ServiceUtils_Exception();
            if ($login) {
                if (!Checker::CheckLogin($login)) {
                    $ex->addError('login');
                } else {
                    $user = new User();
                    $user->setLogin($login);
                    if ($user->select()) {
                        $ex->addError('login-exists');
                    }
                }
            }
            if ($selfRegister) {
                if (!$password) {
                    $ex->addError('easy-password');
                }
            } elseif ($password && !Checker::CheckPassword($password)) {
                $ex->addError('password');
            }

            if (!empty($parentid)) {
                try {
                    !$this->getUserByID($parentid);
                } catch (Exception $e) {
                    $ex->addError('parentid');
                }
            }

            // Проверка даты рожения
            if ($bdate && !Checker::CheckDate($bdate)) {
                $ex->addError('bdate');
            }




            // поиск пользователя по email
            if ($email) {
                try {
                    $this->findUserByContact($email, 'email');

                       $ex->addError('email-exists');

                } catch (Exception $userEx) {

                }

            }


            if ($ex->getCount()) {
                throw $ex;
            }

            $user = new User();
            $user->setCdate(date('Y-m-d H:i:s'));
            $user->setEmail($email);
            if ($login) {
                $user->setLogin($login);
            }
            $user->setPassword($this->createHash($password));

            $user->setGroupid($groupid);
            $user->setDistribution($distribution);
            $user->setUdate(date('Y-m-d H:i:s'));


            if ($level) {
                $level = (int)$level;
                $user->setLevel($level);
            } elseif ($activate) {
                $user->setLevel(0);

                PackageLoader::Get()->import('Randomer');
                $random = Randomer_Password::Random(16, 16);
                $user->setActivatecode($random);
            } else {
                $user->setLevel(1);
            }

            if ($commentadmin) {
                $user->setCommentadmin($commentadmin);
            }

            $user->insert();

            // sendmail
            $tpl = Shop::Get()->getSettingsService()->getSettingValue('letter-registration');
            if ($tpl) {
                $sender = MailUtils_SmartySender::CreateFromTemplateData($tpl);
                $sender->setEmailFrom(Shop::Get()->getSettingsService()->getSettingValue('header-email'));
                $sender->addEmail($email);
                $sender->assign('id', $user->getId());
                $sender->assign('login', $login);
                $sender->assign('password', $password);
                $sender->assign('signature', Shop::Get()->getSettingsService()->getSettingValue('letter-signature'));
                if (isset($random) && $activate && $level < 3) {
                    $sender->assign('activateURL', Engine::Get()->getProjectURL() . Engine::GetLinkMaker()->makeURLByContentIDParams('shop-account-activate', array('email' => $email, 'code' => $random)));
                }
                $sender->send();
            }

            // fire event
            $event = Events::Get()->generateEvent('shopUserAddAfter');
            $event->setUser($user);
            $event->notify();

            SQLObject::TransactionCommit();

            return $user;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Выслать новый пароль на почту
     *
     * @param string $login_email
     */
    public function remindPassword($login_email) {
        try {
            SQLObject::TransactionStart();

            $login_email = trim($login_email);

            try {
                $user = $this->getUserByLogin($login_email);
            } catch (Exception $e) {
                $user = $this->getUserByEmail($login_email);
            }

            PackageLoader::Get()->import('Randomer');
            $password = Randomer_Password::Random(6);
            $user->setPassword($this->createHash($password));
            $user->update();

            $tpl = Shop::Get()->getSettingsService()->getSettingValue('letter-remindpassword');
            if ($tpl) {
                $sender = MailUtils_SmartySender::CreateFromTemplateData($tpl);
                $sender->setEmailFrom(Shop::Get()->getSettingsService()->getSettingValue('reverse-email'));
                $sender->addEmail($user->getEmail());
                $sender->assign('login', $user->getLogin());
                $sender->assign('password', $password);
                $sender->assign('email', $user->getEmail());
                $sender->assign('signature', Shop::Get()->getSettingsService()->getSettingValue('letter-signature'));
                $sender->send();
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Сгенерировать и выслать новый пароль на почту
     * @param User $user
     */
    public  function generateUserPassword($user) {
        PackageLoader::Get()->import('Randomer');
        $random = Randomer_Password::Random(6, 9);
        $user->setPassword(Shop::Get()->getUserService()->createHash($random));
        $user->update();

        // sendmail

        $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('reverse-email');
        $emailTo = $user->getEmail();
        $subject = 'Новый пароль';
        $text = '';
        $text .= "Здравствуйте, " .$user->getName() . ". \n";
        $text .= "Ваш доступ в систему ";
        $text .= '<a href='.Engine::Get()->getProjectURL().'>'.Engine::Get()->getProjectURL().'</a>' .": \n";
        if ($user->getLogin()) {
            $text .= "Ваш логин: " . $user->getLogin() ."\n";
        }
        $text .= "Ваш еmail: " .$user->getEmail() ."\n";
        $text .= "Ваш новый пароль: " .$random ."\n";
        $text .= "Спасибо" . ".\n";

        Shop::Get()->getUserService()->sendEmail($emailFrom, $emailTo, $subject, $text);
    }

    /**
     * Обновить профайл юзера
     *
     * @param User $user
     * @param string $email
     * @param string $password
     * @param string $name
     * @param string $phone
     * @param string $address
     * @param string $bdate
     * @param string $phones
     * @param string $emails
     * @param string $urls
     * @param string $time
     * @param int $parentid
     * @param bool $check
     * @param string $commentadmin
     * @param int $managerid
     * @param int $groupid
     * @param string $login
     * @param unknown_type $company
     * @param unknown_type $pricelevel
     * @param unknown_type $distribution
     */
    public function updateUserProfile(User $user, $email, $password, $name, $phone, $address, $bdate,
    $phones, $emails, $urls, $time, $parentid, $check = true, $commentadmin = false, $managerid = false,
    $groupid = false, $login = false, $company = false, $pricelevel = 0,
    $distribution = false, $tags = false, $cdate = false, $namelast=false, $namemiddle=false, $post=false,
    $typesex = false, $skype = false, $jabber = false, $whatsapp = false, $employer = false, $allowreferal = false) {
        try {
            SQLObject::TransactionStart();

            // fire event
            $event = Events::Get()->generateEvent('shopUserEditBefore');
            $event->setUser($user);
            $event->notify();

            $name = trim($name);
            $email = trim($email);
            $post = trim($post);
            $parentid = trim($parentid);
            $namelast = trim($namelast);
            $namemiddle = trim($namemiddle);


            $tags = $this->_checkTags($tags);

            $pricelevel = (int)$pricelevel;
            if ($pricelevel < 0) {
                $pricelevel = 0;
            }
            if ($pricelevel > 5) {
                $pricelevel = 5;
            }

            $ex = new ServiceUtils_Exception();

            if (empty($email)) {
                $ex->addError('nocontact');
            }

            if ( empty($name) && empty($namelast)) {
                $ex->addError('noname');
            }

            if ($password && !Checker::CheckPassword($password)) {
                $ex->addError('password');
            }

            //Разрешен ли дубликат email
            if ($check && !Checker::CheckEmail($email) || ($email && !Checker::CheckEmail($email))) {
                $ex->addError('email');
            } elseif ($email) {
                $tmp = new User();
                $tmp->setEmail($email);
                if ($tmp->select() && $tmp->getId() != $user->getId()) {
                    $ex->addError('email-exists');
                }
            }

            if (!empty($parentid)) {
                try {
                    !$this->getUserByID($parentid);
                } catch (Exception $e) {
                    $ex->addError('parentid');
                }
            }



            if (!empty($bdate)) {
                $data_arr = explode('-',$bdate);
                if( !checkdate($data_arr[1],$data_arr[2],$data_arr[0])){
                    $ex->addError('bdate');
                }
            }

            if (!empty($cdate)) {
                if (!Checker::CheckDate($cdate)) {
                    $ex->addError('cdate');
                }
            }

            if ($groupid) {
                try {
                    $group = $this->getUserGroupByID($groupid);
                } catch (Exception $e) {
                    $ex->addError('groupid');
                }
            }

            if ($login) {
                if (!Checker::CheckLogin($login)) {
                    $ex->addError('login');
                } else {
                    $user_test = new User();
                    $user_test->setLogin($login);
                    if ($user_test->select() && $user->getId() != $user_test->getId()) {
                        $ex->addError('login-exists');
                    }
                }
            }

            if ($ex->getCount()) {
                throw $ex;
            }

            $user->setEmail($email);
            $user->setCdate($cdate);
            if ($post) {
                $post = str_replace(', ', ',', $post);
                $post = str_replace(' ,', ',', $post);
                $user->setPost($post);
            }
            $user->setGroupid($groupid);
            $user->setUdate(date('Y-m-d H:i:s'));

            if ($commentadmin) {
                $user->setCommentadmin($commentadmin);
            }

            if ($password && !Checker::CheckPassword($password)) {
                $user->setPassword($this->createHash($password));
            }

            if ($login){
                $user->setLogin($login);
            }


            if ($distribution) {
                $user->setDistribution(1);
            } else {
                $user->setDistribution(0);
            }

            if ($employer) {
                $user->setEmployer(1);
            } else {
                $user->setEmployer(0);
            }

            $user->update();

            // fire event
            $event = Events::Get()->generateEvent('shopUserEditAfter');
            $event->setUser($user);
            $event->notify();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    public function updateUserAuth(User $user, $login, $password = false) {
        try {
            SQLObject::TransactionStart();

            // fire event
            $event = Events::Get()->generateEvent('shopUserEditBefore');
            $event->setUser($user);
            $event->notify();

            $ex = new ServiceUtils_Exception();
            if ($password && !Checker::CheckPassword($password)) {
                $ex->addError('password');
            }

            if ($login) {
                if (!Checker::CheckLogin($login)) {
                    $ex->addError('login');
                } else {
                    $user_test = new User();
                    $user_test->setLogin($login);
                    if ($user_test->select() && $user->getId() != $user_test->getId()) {
                        $ex->addError('login-exists');
                    }
                }
            }

            if ($ex->getCount()) {
                throw $ex;
            }

            $user->setLogin($login);
            if ($password) {
                $user->setPassword($this->createHash($password));
            }

            $user->setUdate(date('Y-m-d H:i:s'));
            $user->update();

            // fire event
            $event = Events::Get()->generateEvent('shopUserEditAfter');
            $event->setUser($user);
            $event->notify();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    public function updateUserACL(User $user, $level, $aclArray, $edate = false) {
        if (!$aclArray) {
            $aclArray = array();
        }

        $level = (int)$level;
        if ($level < 0) {
            throw new ServiceUtils_Exception();
        }

        if ($edate && Checker::CheckDate($edate)) {
            $edate = DateTime_Formatter::DateTimeISO9075($edate);
        } else {
            $edate = '0000-00-00 00:00:00';
        }

        try {
            SQLObject::TransactionStart();

            $user->setEdate($edate);
            $user->setLevel($level);
            $user->setUdate(date('Y-m-d H:i:s'));
            $user->update();

            // убираем старые ACL
            $acl = new XUserACL();
            $acl->setUserid($user->getId());
            $acl->delete(true);

            // вставляем новые ACL
            foreach ($aclArray as $x) {
                $acl = new XUserACL();
                $acl->setUserid($user->getId());
                $acl->setAcl($x);
                $acl->insert();
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Получить ACL для юзера
     *
     * @param User $user
     * @return ACL_Simple
     */
    public function getUserACL(User $user) {
        if (!isset($this->_acl[$user->getId()])) {
            // подключаем ACL
            PackageLoader::Get()->import('ACL');

            // создаем ACL
            $this->_acl[$user->getId()] = new ACL_Simple();

            // добавляем в ACL текущую роль
            $role = $this->_acl[$user->getId()]->addRole('user' . $user->getId());

            // получаем группу юзера
            // и загружаем в ACL список привелегий группы
            $list = new XUserACL();
            $list->setUserid($user->getId());
            while ($x = $list->getNext()) {
                $resource = $this->_acl[$user->getId()]->addResource($x->getAcl());
                $this->_acl[$user->getId()]->allow($role, $resource);
            }
        }
        return $this->_acl[$user->getId()];
    }

    /**
     * Получить список прав юзера в виде 2D-assoc массива
     *
     * @return array
     * @param User $user
     */
    public function getUserACLArray(User $user) {
        $acl = $this->getACLPermissions();
        $a = array();
        foreach ($acl as $x) {
            $key = str_replace('-', '_', $x['key']);
            $a[$key] = $user->isAllowed($x['key']);
        }
        return $a;
    }

    /**
     * Получить список прав доступа.
     * Метод вернет 2D-массив
     *
     * @return array
     */
    public function getACLPermissions() {
        $xml = simplexml_load_string(file_get_contents(dirname(__FILE__) . '/../acl/acl.xml'));
        $a = array();
        foreach ($xml->key as $key) {
            $key = $key . '';

            // переводим ключ
            $name = Shop::Get()->getTranslateService()->getTranslateSecure('acl-' . $key);

            // если перевода нет - то используем ключ
            if (!$name) {
                $name = $key;
            }

            $a[] = array(
            'name' => $name,
            'key' => $key,
            );
        }

        // задачи
        if (Engine::Get()->getConfigFieldSecure('project-box')) {
            // в режиме box заказы и задачи это одно и тоже

            /*// ACL по проектам
            $a[] = array(
            'name' => 'Задачи :: Доступ по проектам ::  Все проекты',
            'key' => 'orders-project-all',
            );

            $project = IssueService::Get()->getProjectsAll();
            $project->setActive(1);
            while ($x = $project->getNext()) {
                $a[] = array(
                'name' => 'Задачи :: Доступ по проектам ::  '.$x->getName(),
                'key' => 'orders-project-'.$x->getId(),
                );
            }*/

            // ACL по статусам
            $a[] = array(
            'name' => 'Задачи :: Доступ по статусу ::  Все статусы :: Просмотр',
            'key' => 'orders-status-all-view',
            );

            $a[] = array(
            'name' => 'Задачи :: Доступ по статусу ::  Все статусы :: Управление',
            'key' => 'orders-status-all-change',
            );

            $workflows = Shop::Get()->getShopService()->getWorkflowsAll();
            $workflows->setHidden(0);
            while ($w = $workflows->getNext()) {
                $status = $w->getStatuses();
                while ($s = $status->getNext()) {
                    $a[] = array(
                    'name' => 'Задачи :: Доступ по статусу :: '.$w->getName().' :: #'.$s->getId().' / '.$s->getName().' :: Просмотр',
                    'key' => 'orders-status-'.$s->getId().'-view',
                    );

                    $a[] = array(
                    'name' => 'Задачи :: Доступ по статусу :: '.$w->getName().' :: #'.$s->getId().' / '.$s->getName().' :: Управление',
                    'key' => 'orders-status-' . $s->getId() . '-change',
                    );
                }
            }

            // ACL по менеджерам
            $a[] = array(
            'name' => 'Задачи :: Доступ по менеджеру ::  Все менеджеры :: Просмотр',
            'key' => 'orders-manager-all-view',
            );

            $a[] = array(
            'name' => 'Задачи :: Доступ по менеджеру ::  Все менеджеры :: Управление',
            'key' => 'orders-manager-all-change',
            );

            $managers = Shop::Get()->getUserService()->getUsersManagers();
            while ($s = $managers->getNext()) {
                $a[] = array(
                'name' => 'Задачи :: Доступ по менеджеру :: '.$s->makeName(false, 'lmf').' :: Просмотр',
                'key' => 'orders-manager-'.$s->getId().'-view',
                );

                $a[] = array(
                'name' => 'Задачи :: Доступ по менеджеру :: '.$s->makeName(false, 'lmf').' :: Управление',
                'key' => 'orders-manager-' . $s->getId() . '-change',
                );
            }

            // ACL по категориям заказов
            $a[] = array(
            'name' => 'Задачи :: Доступ по бизнес-процессу ::  Все категории :: Просмотр',
            'key' => 'orders-category-all-view'
            );
            $a[] = array(
            'name' => 'Задачи :: Доступ по бизнес-процессу ::  Все категории :: Управление',
            'key' => 'orders-category-all-change'
            );

            $categories = Shop::Get()->getShopService()->getWorkflowsAll();
            $categories->setHidden(0);
            while ($s = $categories->getNext()) {
                $a[] = array(
                'name' => 'Задачи :: Доступ по бизнес-процессу :: '.$s->getName().' :: Просмотр',
                'key' => 'orders-category-'.$s->getId().'-view',
                );

                $a[] = array(
                'name' => 'Задачи :: Доступ по бизнес-процессу :: '.$s->getName().' :: Управление',
                'key' => 'orders-category-'.$s->getId().'-change',
                );
            }

        } else {
            // ACL по статусам заказов
            $a[] = array(
            'name' => 'Заказы :: Доступ по статусу ::  Все статусы :: Просмотр',
            'key' => 'orders-status-all-view',
            );

            $a[] = array(
            'name' => 'Заказы :: Доступ по статусу ::  Все статусы :: Управление',
            'key' => 'orders-status-all-change',
            );

            $status = Shop::Get()->getShopService()->getStatusAll();
            $index = 0;
            while ($s = $status->getNext()) {
                try {
                    $categoryName = 'Без категории';
                    $category = $s->getCategory();
                    $categoryName = $category->getName();
                } catch (Exception $e) {

                }

                $a[] = array(
                'name' => 'Заказы :: Доступ по статусу :: '.$categoryName.' :: #'.$index.' / '. $s->getName().' :: Просмотр',
                'key' => 'orders-status-'.$s->getId().'-view',
                );

                $a[] = array(
                'name' => 'Заказы :: Доступ по статусу :: '.$categoryName.' :: #'.$index.' / '. $s->getName().' :: Управление',
                'key' => 'orders-status-' . $s->getId() . '-change',
                );

                $index ++;
            }

            // ACL по менеджерам заказов
            $a[] = array(
            'name' => 'Заказы :: Доступ по менеджеру ::  Все менеджеры :: Просмотр',
            'key' => 'orders-manager-all-view',
            );

            $a[] = array(
            'name' => 'Заказы :: Доступ по менеджеру ::  Все менеджеры :: Управление',
            'key' => 'orders-manager-all-change',
            );

            $managers = Shop::Get()->getUserService()->getUsersManagers();
            while ($s = $managers->getNext()) {
                $a[] = array(
                'name' => 'Заказы :: Доступ по менеджеру :: '.$s->makeName(false, 'lmf').' :: Просмотр',
                'key' => 'orders-manager-'.$s->getId().'-view',
                );

                $a[] = array(
                'name' => 'Заказы :: Доступ по менеджеру :: '.$s->makeName(false, 'lmf').' :: Управление',
                'key' => 'orders-manager-' . $s->getId() . '-change',
                );
            }

            // ACL по категориям заказов
            $a[] = array(
            'name' => 'Заказы :: Доступ по категории ::  Все категории :: Просмотр',
            'key' => 'orders-category-all-view'
            );
            $a[] = array(
            'name' => 'Заказы :: Доступ по категории ::  Все категории :: Управление',
            'key' => 'orders-category-all-change'
            );

            $categories = Shop::Get()->getShopService()->getOrderCategoryAll();
            $categories->setHidden(0);
            while ($s = $categories->getNext()) {
                $a[] = array(
                'name' => 'Заказы :: Доступ по категории :: '.$s->getName().' :: Просмотр',
                'key' => 'orders-category-'.$s->getId().'-view',
                );

                $a[] = array(
                'name' => 'Заказы :: Доступ по категории :: '.$s->getName().' :: Управление',
                'key' => 'orders-category-'.$s->getId().'-change',
                );
            }
            $a[] = array(
            'name' => 'Заказы :: Доступ по категории :: Без категории :: Просмотр',
            'key' => 'orders-category-0-view'
            );
            $a[] = array(
            'name' => 'Заказы :: Доступ по категории :: Без категории :: Управление',
            'key' => 'orders-category-0-change'
            );
        }

        // ACL по группам контактов
        $userGroups = $this->getUserGroupsAll();
        while ($group = $userGroups->getNext()) {
            $a[] = array(
            'name' => 'Контакты :: Доступ по группе :: '.$group->getName().' :: Просмотр',
            'key' => 'users-group-' . $group->getId().'-view',
            );

            $a[] = array(
            'name' => 'Контакты :: Доступ по группе :: '.$group->getName().' :: Управление',
            'key' => 'users-group-' . $group->getId().'-change',
            );
        }

        $a[] = array(
        'name' => 'Контакты :: Доступ по группе :: Без группы :: Просмотр',
        'key' => 'users-group-0-view',
        );

        $a[] = array(
        'name' => 'Контакты :: Доступ по группе :: Без группы :: Управление',
        'key' => 'users-group-0-change',
        );

        // ACL по менеджерам контактов
        $managers = Shop::Get()->getUserService()->getUsersManagers();
        while ($s = $managers->getNext()) {
            $a[] = array(
            'name' => 'Контакты :: Доступ по менеджеру :: '.$s->makeName(false, 'lmf').' :: Просмотр',
            'key' => 'users-manager-'.$s->getId().'-view',
            );

            $a[] = array(
            'name' => 'Контакты :: Доступ по менеджеру :: '.$s->makeName(false, 'lmf').' :: Управление',
            'key' => 'users-manager-' . $s->getId() . '-change',
            );
        }

        $a[] = array(
        'name' => 'Контакты :: Доступ по менеджеру :: Без менеджера :: Просмотр',
        'key' => 'users-manager-0-view',
        );

        $a[] = array(
        'name' => 'Контакты :: Доступ по менеджеру :: Без менеджера :: Управление',
        'key' => 'users-manager-0-change',
        );

        // ACL по уровню доступа к контактам
        $a[] = array(
        'name' => 'Контакты :: Доступ по уровню :: Заблокированные :: Просмотр',
        'key' => 'users-level-0-view',
        );

        $a[] = array(
        'name' => 'Контакты :: Доступ по уровню :: Заблокированные :: Управление',
        'key' => 'users-level-0-change',
        );

        $a[] = array(
        'name' => 'Контакты :: Доступ по уровню :: Клиенты и контакты :: Просмотр',
        'key' => 'users-level-1-view',
        );

        $a[] = array(
        'name' => 'Контакты :: Доступ по уровню :: Клиенты и контакты :: Управление',
        'key' => 'users-level-1-change',
        );

        $a[] = array(
        'name' => 'Контакты :: Доступ по уровню :: Менеджеры :: Просмотр',
        'key' => 'users-level-2-view',
        );

        $a[] = array(
        'name' => 'Контакты :: Доступ по уровню :: Менеджеры :: Управление',
        'key' => 'users-level-2-change',
        );

        $a[] = array(
        'name' => 'Контакты :: Доступ по уровню :: Администраторы :: Просмотр',
        'key' => 'users-level-3-view',
        );

        $a[] = array(
        'name' => 'Контакты :: Доступ по уровню :: Администраторы :: Управление',
        'key' => 'users-level-3-change',
        );

        // ACL по менеджерам контактов - чтение истории
        $managers = Shop::Get()->getUserService()->getUsersManagers();
        while ($s = $managers->getNext()) {
            $a[] = array(
            'name' => 'Контакты :: События :: '.$s->makeName(false, 'lmf').' :: Просмотр событий',
            'key' => 'users-manager-'.$s->getId().'-history',
            );

            $a[] = array(
            'name' => 'Контакты :: События :: '.$s->makeName(false, 'lmf').' :: Рейтинг событий',
            'key' => 'users-manager-'.$s->getId().'-history-rating',
            );
        }

        // уведомления по категория
        $categories = Shop::Get()->getShopService()->getOrderCategoryAll();
        while ($s = $categories->getNext()) {
            $a[] = array(
            'name' => 'Уведомления :: Заказы :: По категории :: '.$s->getName(),
            'key' => 'notify-order-category-'.$s->getId(),
            );
        }
        $a[] = array(
        'name' => 'Уведомления :: Заказы :: По категории :: Без категори',
        'key' => 'notify-order-category-0',
        );

        // добавляем кастомные ACL
        foreach ($this->_aclPermissionArray as $key => $name) {
            $a[] = array(
            'name' => $name,
            'key' => $key,
            );
        }

        usort($a, array($this, '_sortACL'));
        return $a;
    }

    /**
     * Зарегистрировать ACL-permission.
     * Метод используется модулями для регистрации своих ACL.
     *
     * @param string $key
     * @param string $name
     */
    public function addACLPermission($key, $name) {
        $key = trim($key);
        $name = trim($name);

        if (!$key) {
            throw new ServiceUtils_Exception('key');
        }

        if (!$name) {
            throw new ServiceUtils_Exception('name');
        }

        $this->_aclPermissionArray[$key] = $name;
    }



    /**
     * Зарегистрировать пользователя-клиента.
     *
     * @uses 5+
     *
     * @param string $clientName
     * @param string $login
     * @param string $password
     * @param string $email
     * @param string $phone
     * @param string $address
     * @param string $commentAdmin
     * @param string $time
     * @param string $commentAdmin
     * @param string $groupType
     * @return User
     */
    public function addUserClient($clientName, $login = false, $password = false, $email = false, $phone = false, $address = false, $company = false, $time = false, $commentAdmin = false, $groupType = false, $namelast = false, $namemiddle = false, $post = false, $typesex = false) {
        try {
            SQLObject::TransactionStart();

            $clientName = trim($clientName);
            $namelast = trim($namelast);
            $namemiddle = trim($namemiddle);
            $login = trim($login);
            $email = trim($email);
            $address = trim($address);
            $time = trim($time);
            $post = trim($post);
            $commentAdmin = trim($commentAdmin);

            $ex = new ServiceUtils_Exception();

            $emailArray = array();
            if ($email) {
                $tmp = explode("\n", $email);
                foreach ($tmp as $x) {
                    // из телефона убираем всякий мусор, оставляем только цифры
                    if (Checker::CheckEmail($x)) {
                        $emailArray[] = $x;
                    } else {
                        $ex->addError('email');
                    }
                }
            }
            if ($emailArray) {
                $email = $emailArray[0];
                unset($emailArray[0]);
            }
            $emails = implode("\n", $emailArray);



            /* в задаче #35282 описаны критерии поиска */
            // поиск пользователя по email
            if (empty($user) && $email) {
                try {
                    $user = $this->findUserByContact($email, 'email');
                } catch (Exception $userEx) {
                    unset($user);
                }
            }


            if (!$clientName && !$namelast && !$namemiddle) {
                $ex->addError('name');
            }

            if ($ex->getCount()) {
                throw $ex;
            }

            if (!empty($user)) {
                // обновляем данные пользователя

                if ($clientName) {
                    $user->setName($clientName);
                }
                if ($namelast) {
                    $user->setNamelast(trim($namelast));
                }
                if ($namemiddle) {
                    $user->setNamemiddle($namemiddle);
                }
                if ($phone) {
                    $user->setPhone($phone);
                }
                if ($phones) {
                    $user->setPhones($phones);
                }
                if ($email) {
                    $user->setEmail($email);
                }
                if ($emails) {
                    $user->setEmails($emails);
                }
                if ($address) {
                    $user->setAddress($address);
                }
                if ($commentAdmin) {
                    $user->setCommentadmin($commentAdmin);
                }
                if ($time) {
                    $user->setTime($time);
                }

                if ($post) {
                    $user->setPost($post);
                }

                $user->setUdate(date('Y-m-d H:i:s'));
                $user->update();

                // и возвращаем его
                // позже, после транзакции
            } else {
                // пользователя нужно создавать нового
                if (!($login || $email)) { // если нет логина или мыла создаём логин

                }
                $user = new User();
                $user->setEmail($email);
                $user->setCommentadmin($commentAdmin);
                $user->setPost($post);
                $user->setLevel(1);
                $user->setDistribution(1);
                // данные для авторизации
                if ($login) {
                    $user->setLogin($login);
                    // @todo уже есть выше эта строка $user->setLevel(1);
                }

                // пароль всегда
                PackageLoader::Get()->import('Randomer');
                $password = Randomer_Password::Random(6,9);
                $user->setPassword($this->createHash($password));

                // дата создания
                $user->setCdate(date('Y-m-d H:i:s'));

                // автоматически ставим менеджера "себя"
                /*try {
                    $user->setManagerid($this->getUser()->getId());
                } catch (Exception $managerEx) {

                }*/


                // определение группы
                if ($groupType) {
                    $group = new ShopUserGroup();
                    $group->setGroup($groupType);
                    $group->select();
                    $user->setGroupid($group->getId());
                }

                // отправляем письмо на почту юзеру,
                // только если это само-регистрация
                $selfRegister = false;
                try {
                    $this->getUser();
                } catch (Exception $e) {
                    $selfRegister = true;
                }

                if ($selfRegister && $user->getEmail()) {
                    $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('reverse-email');
                    $emailTo = $user->getEmail();
                    $subject = 'Авторегистрация';
                    $text = '';
                    $text .= "Здравствуйте, ".$user->makeName(true, 'lfm')."! <br />";
                    $text .= "Вы успешно зарегистрированы на ";
                    $text .= '<a href='.Engine::Get()->getProjectURL().'>'.Engine::Get()->getProjectURL().'</a>' .": <br />";
                    $text .= "Ваш доступ: <br />";
                    $text .= "<br />";
                    if ($user->getLogin()) {
                        $text .= "Логин: ".$user->getLogin()."<br />";
                    }
                    $text .= "Email: ".$user->getEmail()."<br />";
                    $text .= "Пароль: ".$password."<br />";
                    $text .="<br />";
                    $text .= "Спасибо. <br />";

                    // отправка письма
                    $this->sendEmail($emailFrom, $emailTo, $subject, $text);
                }

                $user->setUdate(date('Y-m-d H:i:s'));
                $user->insert();
            }

            try {
                $userDo = Shop::Get()->getUserService()->getUser();

                CommentsAPI::Get()->addComment(
                'shop-history-user-add'.$user->getId(),
                Shop::Get()->getTranslateService()->getTranslate('translated_adeded_user').' #'.$user->getId().' '.$user->makeName(),
                $userDo->getId()
                );
            } catch (Exception $e) {

            }

            // fire event
            $event = Events::Get()->generateEvent('shopUserAddAfter');
            $event->setUser($user);
            $event->notify();

            SQLObject::TransactionCommit();

            // возвращаем пользователя
            return $user;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Поиск пользователей и клиентов
     *
     * @param string $query
     * @return User
     */
    public function searchUsers($query, $cuser = false, $allowShotQuery = false) {
        $query = trim($query);
        if (!$allowShotQuery and strlen($query) < 3) {
            throw new ServiceUtils_Exception();
        }

        $users = $this->getUsersAll($cuser);
        $connection = $users->getConnectionDatabase();

        // перестановки всех слов
        $a = array();
        if (preg_match_all("/([\.\d\pL]+)/ius", $query, $r)) {
            foreach ($r[1] as $part) {
                $a[] = $connection->escapeString($part);
            }
        }

        if (!$a) {
            throw new ServiceUtils_Exception();
        }

        foreach ($a as $part) {
            $w = array();

            $w[] = "id ='$part'";
            $w[] = "login LIKE '%$part%'";
            $w[] = "email LIKE '%$part%'";
            $w[] = "address LIKE '%$part%'";
            $w[] = "post LIKE '%$part%'";
            $w[] = "commentadmin LIKE '%$part%'";


            // превращаем в en транскрипцию
            try {
                $partTr = StringUtils_Transliterate::TransliterateRuToEn($part);

                $partTr = $connection->escapeString($partTr);

                $w[] = "name LIKE '%$partTr%'";
            } catch (Exception $e) {

            }

            // превращаем ru
            try {
                $partRu = StringUtils_Transliterate::TransliterateCorrectTo('ru', $part);

                $partRu = $connection->escapeString($partRu);

                $w[] = "name LIKE '%$partRu%'";
            } catch (Exception $e) {

            }

            // превращаем en
            try {
                $partEn = StringUtils_Transliterate::TransliterateCorrectTo('en', $part);

                $partEn = $connection->escapeString($partEn);

                $w[] = "name LIKE '%$partEn%'";
            } catch (Exception $e) {

            }

            $users->addWhereQuery("(" . implode(' OR ', $w) . ")");
        }

        return $users;
    }

    /**
     * @param $query
     * @param bool $cuser
     * @param bool $allowShotQuery
     * @return User
     * @throws ServiceUtils_Exception
     */
    public function searchUsersByEmails($query, $cuser = false, $allowShotQuery = false) {
        $query = trim($query);
        if (!$allowShotQuery and strlen($query) < 3) {
            throw new ServiceUtils_Exception();
        }

        $users = $this->getUsersAll($cuser);
        $connection = $users->getConnectionDatabase();

        // перестановки всех слов
        $a = array();
        if (preg_match_all("/([\.\d\pL]+)/ius", $query, $r)) {
            foreach ($r[1] as $part) {
                $a[] = $connection->escapeString($part);
            }
        }

        if (!$a) {
            throw new ServiceUtils_Exception();
        }

        foreach ($a as $part) {
            $w = array();

            $w[] = "email LIKE '%$part%'";

            // превращаем в en транскрипцию
            try {
                $partTr = StringUtils_Transliterate::TransliterateRuToEn($part);

                $partTr = $connection->escapeString($partTr);

                $w[] = "email LIKE '%$partTr%'";
            } catch (Exception $e) {

            }

            // превращаем ru
            try {
                $partRu = StringUtils_Transliterate::TransliterateCorrectTo('ru', $part);

                $partRu = $connection->escapeString($partRu);

                $w[] = "email LIKE '%$partRu%'";
            } catch (Exception $e) {

            }

            // превращаем en
            try {
                $partEn = StringUtils_Transliterate::TransliterateCorrectTo('en', $part);

                $partEn = $connection->escapeString($partEn);

                $w[] = "email LIKE '%$partEn%'";
            } catch (Exception $e) {

            }

            $users->addWhereQuery("(" . implode(' OR ', $w) . ")");
        }

        return $users;
    }

    /**
     * Поиск должностей
     * (для автокомплита)
     *
     * @param string $post
     * @return array
     */
    public function searchPosts($post) {
        $connection = ConnectionManager::Get()->getConnectionDatabase();

        $post = $connection->escapeString($post);
        $post = str_replace(' ', '%', $post);

        $sql = "SELECT DISTINCT `post` FROM `users` WHERE `post` LIKE '%$post%' LIMIT 20";

        $result = array();
        $q = $connection->query($sql);
        while ($x = $connection->fetch($q)) {
            $result[] = $x['post'];
        }

        return $result;

    }

    /**
     * @return ShopUserGroup
     */
    public function getUserGroupByID($id) {
        try {
            return $this->getObjectByID($id, 'ShopUserGroup');
        } catch (Exception $e) {
        }
        throw new ServiceUtils_Exception('ShopUserGroup by id not found');
    }

    /**
     * @return ShopUserGroup
     */
    public function getUserGroupsAll() {
        $x = new ShopUserGroup();
        $x->setOrder(array('sort', 'name'), 'ASC');
        return $x;
    }

    /**
     * Получить пользователей по группе
     *
     * @param ShopUserGroup $group
     * @return User
     */
    public function getUsersByGroup(ShopUserGroup $group, $user = false) {
        $users = $this->getUsersAll($user);

        $class = $group->getLogicclass();
        if ($class) {
            if (class_exists($class)) {
                $processor = new $class();
                $users = $processor->getContacts($users, $group);
            } else {
                $users->addWhereQuery('1=0');
            }
        } else {
            $users->setGroupid($group->getId());
        }
        return $users;
    }

    /**
     * Получить всех пользователей по ролям
     *
     * @param string $roleName
     * @return User
     */
    public function getUsersByRole($roleName) {
        return RoleService::Get()->getUsersByRole($roleName);
    }

    /**
     * Получить массив групп пользователей
     *
     * @todo remove this method (deprecate)
     * @deprecated
     *
     * @return array
     */
    public function getUsersGroups() {
        $groups = $this->getUserGroupsAll();
        $groupsArray = array();
        while ($group = $groups->getNext()) {
            $groupsArray[] = array(
            'id' => $group->getId(),
            'name' => $group->getName(),
            'url' => Engine::Get()->GetLinkMaker()->makeURLByContentIDParam('shop-admin-users', $group->getId(), 'groupid')
            );
        }
        return $groupsArray;
    }

    /**
     * @param User $user
     * @param User $cuser
     * @return bool
     */
    public function isUserViewAllowed(User $user, User $cuser) {
        if ($cuser->isDenied('users')) {
            return false;
        }

        // фильтр по уровню
        if ($cuser->isDenied('users-level-'.$user->getLevel().'-view')) {
            return false;
        }

        if ($cuser->isAllowed('users-all-view')) {
            return true;
        }

        // своих юзеров и себя видно всегда
        if ($cuser->getId() == $user->getId()) {
            return true;
        }

        if ($cuser->getId() == $user->getManagerid()) {
            return true;
        }

        // фильтр по группе
        if ($cuser->isDenied('users-group-'.$user->getGroupid().'-view')) {
            return false;
        }

        // фильтр по менеджеру
        if ($cuser->isDenied('users-manager-'.$user->getManagerid().'-view')) {
            return false;
        }

        return true;
    }

    /**
     * @param User $user
     * @param User $cuser
     * @return bool
     */
    public function isUserChangeAllowed(User $user, User $cuser) {
        if ($cuser->isDenied('users')) {
            return false;
        }

        // фильтр по уровню
        if ($cuser->isDenied('users-level-'.$user->getLevel().'-change')) {
            return false;
        }

        if ($cuser->isAllowed('users-all-edit')) {
            return true;
        }

        /*if ($cuser->getId() == $user->getId()) {
        return true;
        }*/

        /*if ($cuser->getId() == $user->getManagerid()) {
        return true;
        }*/

        // фильтр по группе
        if ($cuser->isDenied('users-group-'.$user->getGroupid().'-change')) {
            return false;
        }

        // фильтр по менеджеру
        if ($cuser->isDenied('users-manager-'.$user->getManagerid().'-change')) {
            return false;
        }

        return true;
    }

    /**
     * Выслать письмо пользователю на почту
     * с сохранением в events (OneBox only)
     *
     * @param $emailTo
     * @param $emailFrom
     * @param $subject
     * @param $text
     * @param $fileArray
     * @throws Exception
     */
    public function sendEmail($emailFrom, $emailTo, $subject, $text, $fileArray = false, $sendDate = false) {
        try {
            SQLObject::TransactionStart();

            $subject = trim($subject);
            $text = trim($text);
            $emailFrom = trim($emailFrom);
            if (!is_array($emailTo)) {
                $emailTo = trim($emailTo);
                $emailTo = array($emailTo);
            }

            if (!$emailTo) {
                throw new ServiceUtils_Exception();
            }
            if (!Checker::CheckEmail($emailFrom)) {
                throw new ServiceUtils_Exception();
            }
            if (!$subject && !$text) {
                throw new ServiceUtils_Exception();
            }

            if (!Checker::CheckDate($sendDate)) {
                $sendDate = DateTime_Object::Now()->__toString();
            }

            foreach ($emailTo as $x) {
                $sender = new MailUtils_Letter($emailFrom, $x, $subject, $text);
                $sender->setBodyType('text/html');
                if ($fileArray) {
                    foreach ($fileArray as $file) {
                        $fileName = $file['name'];
                        $type = $file['type'];
                        $file = $file['tmp_name'];

                        $sender->addAttachment(file_get_contents($file), $fileName, $type);
                    }
                }
                $sender->send($sendDate);
            }

            if (Engine::Get()->getConfigFieldSecure('project-box')) {
                $subjectGroup = EventService::Get()->parseSubjectGroup($subject);

                // сохраняем событие
                foreach ($emailTo as $to) {
                    // issue #56342 - если ящик парсится box'ом - то
                    // не надо в него ничего сохранять, так как оно
                    // и так запарсится позже
                    if (EventService::Get()->checkEmailParser($to)) {
                        continue;
                    }

                    $event = new ShopEvent();
                    $event->setCdate(date('Y-m-d H:i:s'));
                    $event->setType('email');
                    $event->setFrom($emailFrom);
                    $event->setTo($to);
                    $event->setSubject($subject);
                    $event->setSubjectgroup($subjectGroup);
                    $event->setContent(strip_tags($text));
                    $event->setMailbox('sent');
                    $event->insert();

                    EventService::Get()->processEventParameters($event);
                }
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }


    /**
     * @param $email
     * @param $code
     * @throws Exception
     * @throws ServiceUtils_Exception
     */
    public function activateUser($email, $code) {
        try {
            $user = new User();
            $user->setEmail($email);
            $user->setActivatecode($code);
            $user->setLevel(0);
            $user->setLimitCount(1);

            if (!$user->select()) {
                throw new ServiceUtils_Exception();
            }

            $user->setLevel(1);
            $user->setActivatecode('');

            $user->update();

            return $user;
        } catch (Exception $ge) {
            throw $ge;
        }
    }

    /**
     * Вход
     *
     * @param string $login
     * @param string $password
     * @throws ServiceUtils_Exception
     * @return User
     */
    public function login($login, $password, $cookie = false, $indm5 = false) {
        $user = parent::login($login, $password, $cookie, $indm5);

        $this->_checkUserEdate($user);
        return $user;
    }

    /**
     *
     * автоматически логиним пользователя
     * только для пользователей level = 1
     *
     * @param User $user
     * @return User
     * @throws ServiceUtils_Exception
     */
    public function automaticalLogin (User $user) {
        if ($user->getLevel() != 1) {
            throw new ServiceUtils_Exception();
        }
        return $this->login(
            $user->getLogin() ? $user->getLogin() : $user->getEmail(),
            $user->getPassword(),
            false, // $cookie
            true // не криптить пароль
        );
    }

    /**
     * @param $identifier
     * @return User
     */
    public function getUserByIdentifier($identifier) {
        return $this->getObjectByField('identifier', $identifier);
    }

    /**
     * @param User $user
     * @return string
     */
    public function getUserIdentifier (User $user) {
        if ($user->getIdentifier()) {
            return $user->getIdentifier();
        }
        $str = md5($user->getId().microtime(true));
        $user->setIdentifier($str);
        $user->update();
        return $str;
    }

    /**
     * @return User
     */
    public function getUsersManagers($user = false) {
        $users = $this->getUsersAll($user);
        $users->setEmployer(1);

        return $users;
    }


    /**
     * Найти пользователя по контакту
     *
     * @param string $contact
     * @param string $type
     * @return User
     */
    public function findUserByContact($contact, $type) {
        if (!$contact) {
            throw new ServiceUtils_Exception();
        }

        if (!$type) {
            throw new ServiceUtils_Exception();
        }

        $contact = strtolower($contact);

        if (!empty($this->_findCacheArray[$contact][$type])) {
            return $this->_findCacheArray[$contact][$type];
        }

        if (isset($this->_findCacheArray[$contact][$type])) {
            throw new ServiceUtils_Exception();
        }

       if ($type == 'email') {
            $e = ConnectionManager::Get()->getConnectionDatabase()->escapeString($contact);

            $users = new User();
            $users->addWhereQuery("(email='{$e}')");
            while ($x = $users->getNext()) {
                $a = $x->getEmailArray();
                if (in_array($contact, $a)) {
                    $this->_findCacheArray[$contact][$type] = $x;
                    return $x;
                }
            }
        } elseif ($type == 'email') {
            $e = ConnectionManager::Get()->getConnectionDatabase()->escapeString($contact);

            $users = new User();
            $users->addWhereQuery("(email='{$e}')");
            while ($x = $users->getNext()) {
                $a = $x->getEmailArray();
                if (in_array($contact, $a)) {
                    $this->_findCacheArray[$contact][$type] = $x;
                    return $x;
                }
            }
        }

        $this->_findCacheArray[$contact][$type] = false;

        throw new ServiceUtils_Exception();
    }

    /**
     * Проверить дату актуальности юзера (user.edate)
     *
     * @param User $user
     */
    private function _checkUserEdate(User $user) {
        if ($this->_checkUserEdateFlag) {
            return;
        }

        // issue #42002 - user edate
        if (Checker::CheckDate($user->getEdate())) {
            if ($user->getEdate() < date('Y-m-d H:i:s')) {
                // выход
                $this->logout($user);

                throw new ServiceUtils_Exception();
            }
        }

        $this->_checkUserEdateFlag = true;
    }

    private function _sortACL($a, $b) {
        return $a['name'] > $b['name'];
    }


    /**
     * Убираем косяки и дубликаты из тегов
     *
     * @param string $tags
     * @return string
     */
    private function _checkTags($tags) {
        $tags = explode(',', $tags);
        $a = array();
        foreach ($tags as $x) {
            $x = trim($x);
            if ($x) {
                $a[] = $x;
            }
        }
        return implode(',', $a);
    }

    private $_aclPermissionArray = array();

    private $_checkUserEdateFlag = false;

    private $_findCacheArray = array();

}