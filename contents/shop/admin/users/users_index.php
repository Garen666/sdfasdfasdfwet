<?php
class users_index extends Engine_Class {

    public function process() {
        // включить box-пункты или нет
        $this->setValue('box', Engine::Get()->getConfigFieldSecure('project-box'));

        $canUserAdd = $this->getUser()->isAllowed('users-add');
        $this->setValue('canUserAdd', $canUserAdd);

        $groupID = $this->getArgumentSecure('groupid');

        try {
            $group = Shop::Get()->getUserService()->getUserGroupByID($groupID);
            $this->setValue('groupName', $group->getName());
            $this->setValue('groupDescription', $group->getDescription());
        } catch (Exception $e) {

        }

        $datasource = new Datasource_Users($groupID);

        $filterCompany = $this->getArgumentSecure('company', 'string');
        if ($filterCompany) {
            $datasource->getSQLObject()->setCompany($filterCompany);
        }

        $typesex = $this->getArgumentSecure('typesex');

        if ($typesex) {
            $this->setValue('typesexValue', $typesex);
            $datasource->getSQLObject()->setTypesex($typesex);
        }

        if($this->getControlValue('change')){
            try {
                SQLObject::TransactionStart();

                $subscribeStatus = $this->getControlValue('changesubscibe');
                $level = $this->getControlValue('level');
                $managerID = $this->getControlValue('manager');

                if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                    foreach($r[1] as $userID){
                        $user = Shop::Get()->getUserService()->getUserByID($userID);
                        if($subscribeStatus != '-1'){
                            $user->setDistribution($subscribeStatus);
                        }
                        if($level != '-1'){
                            $user->setLevel($level);
                        }
                        if($managerID != '-1'){
                            $user->setManagerid($managerID);
                        }
                        $user->update();
                    }
                }

                SQLObject::TransactionCommit();
            } catch (Exceprion $e) {
                SQLObject::TransactionRollback();
            }

            // перемещение пользователей в группу
            if ($this->getControlValue('movegroup')) {
                try {
                    $groupToId = $this->getControlValue('movegroup');

                    if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                        foreach ($r[1] as $userID) {
                            try {
                                $user = Shop::Get()->getUserService()->getUserByID($userID);
                                $user->setGroupid($groupToId);
                                $user->update();
                            } catch (Exception $pe) {

                            }
                        }
                    }

                } catch (Exception $e) {

                }
            }


            // обьединить
            if ($this->getControlValue('join')){

                if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                    try {
                        Shop::Get()->getUserService()->mergeUsers($r[1]);
                    } catch (Exception $pe) {

                    }
                }
            }

        }

        // массовая рассылка
        if($this->getControlValue('send')){
            $arrUserId = array();
            if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                foreach ($r[1] as $userID) {
                    try {
                        $arrUserId[] = $userID;
                    } catch (Exception $pe) {

                    }
                }
            }
            $str = '';
            foreach($arrUserId as $id){
                if($id == end($arrUserId)){
                    $str .= 'user[]='.$id;
                } else {
                    $str .= 'user[]='.$id.'&';
                }
            }

            header("Location: /admin/shop/users/mailing/?".$str);
        }

        // массовое удаление
        if ($this->getControlValue('delete')){

            if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                $activeUserId = Shop::Get()->getUserService()->getUser()->getId();
                foreach ($r[1] as $userID) {
                    try {
                        // если это не текущий пользователь
                        if($activeUserId != $userID){
                            $user = Shop::Get()->getUserService()->getUserByID($userID);
                            $user->delete();
                        }
                        try {
                            $userDo = Shop::Get()->getUserService()->getUser();

                            CommentsAPI::Get()->addComment(
                            'shop-history-user-del'.$user->getId(),
                            Shop::Get()->getTranslateService()->getTranslate('translate_user_deleted').' #'.$user->getId().' '.$user->makeName(),
                            $userDo->getId()
                            );
                        } catch (Exception $e) {

                        }
                    } catch (Exception $pe) {

                    }
                }
            }
        }

        // объединить клиентов
        if ($this->getControlValue('join')){

            if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                try {
                    Shop::Get()->getUserService()->mergeUsers($r[1]);
                } catch (Exception $pe) {

                }
            }
        }

        if ($this->getControlValue('mode') == 'list') {
            $table = new Shop_ContentTable($datasource);

            $filterPhone = $this->getArgumentSecure('filterphone');
            if ($filterPhone) {
                $filterPhone = preg_replace("/([^0-9])/ius", '', $filterPhone);
                $filterPhone = preg_replace("/\d/ius", '$0%', $filterPhone);
                $filterPhone = "%{$filterPhone}%";
                $table->getDataSource()->getSQLObject()->addWhere('phone', $filterPhone, 'LIKE');
            }

            // ссылка на логине
            $field = new Forms_ContentFieldControlLink('login', 'shop-admin-users-control', 'id');
            $table->addField($field);
            $table->getField('login')->setName(Shop::Get()->getTranslateService()->getTranslate('translate_login'));

            // ссылка на ID
            $field = new Forms_ContentFieldControlLink('id', 'shop-admin-users-control', 'id');
            $table->addField($field);
            $table->getField('id')->setName('#');

            // ссылка на имени
            $field = new Forms_ContentFieldControlLink('namelast', 'shop-admin-users-control', 'id');
            $table->addField($field);
            $table->getField('namelast')->setName('Фамилия');

            $field = new Forms_ContentFieldControlLink('name', 'shop-admin-users-control', 'id');
            $table->addField($field);
            $table->getField('name')->setName('Имя');

            $field = new Forms_ContentFieldControlLink('namemiddle', 'shop-admin-users-control', 'id');
            $table->addField($field);
            $table->getField('namemiddle')->setName('Отчество');

            $field = new Forms_ContentFieldControlLink('company', 'shop-admin-users-control', 'id');
            $table->addField($field);
            $table->getField('company')->setName('Компания');

            // прячем поле с паролем
            $table->removeField('password');

            $this->setValue('table', $table->render());

        } else {
            $table = new Shop_ContentTable($datasource);
            $filterPhone = $this->getArgumentSecure('filterphone');
            if ($filterPhone) {
                $filterPhone = preg_replace("/([^0-9])/ius", '', $filterPhone);
                $filterPhone = preg_replace("/\d/ius", '$0%', $filterPhone);
                $filterPhone = "%{$filterPhone}%";
                $table->getDataSource()->getSQLObject()->addWhere('phone', $filterPhone, 'LIKE');
            }
            $table->render();

            $block = Engine::GetContentDriver()->getContent('shop-user-tile');
            $block->setValue('users', $datasource->getSQLObject());
            $this->setValue('table', $block->render());
        }

        $this->setValue('userFilterCount', $datasource->getSQLObject()->getCount());


        // получаем id всех отсортированных пользователей
        $connection = ConnectionManager::Get()->getConnectionDatabase();
        $q = $connection->query('SET group_concat_max_len = 9999999;');
        $sql = "SELECT GROUP_CONCAT(`id` SEPARATOR ';') as `id` FROM `users` WHERE (" . $datasource->getSQLObject()->makeWhereString().")";
        $q = $connection->query($sql);
        $r = $connection->fetch($q);
        if ($r) {
            $this->setValue('arrUserId', $r['id']);
        }

        $groups = Shop::Get()->getUserService()->getUserGroupsAll();
        $a = array();
        while ($group = $groups->getNext()) {
            $name = $group->getName();
            $tmp = explode('::', $name, 2);
            if (count($tmp) == 1) {
                $name = trim($tmp[0]);
                $parentName = '';
            } else {
                $name = trim($tmp[1]);
                $parentName = trim($tmp[0]);
            }

            $countDiff = $group->getCnt() - $group->getCntlast();
            if ($countDiff >= 0) {
                $countDiff = '+'.$countDiff;
            }

            $a[] = array(
            'id' => $group->getId(),
            'name' => $name,
            'level' => count($tmp) > 1,
            'countNow' => $group->getCnt(),
            'countDiff' => $countDiff,
            'description' => htmlspecialchars($group->getDescription()),
            'url' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('groupid' => $group->getId(), 'companyid' => 0, 'company' => '')),
            );
        }
        $this->setValue('groupsArray', $a);

        $this->setValue('groupid', $groupID);

        $groupArr = $this->_makeGroupArray();
        $this->setValue('groupArr', $groupArr);

        $levelArr = $this->_makeLevelArray();
        $this->setValue('levelArr', $levelArr);

        $managerArr = $this->_makeManagerArray();
        $this->setValue('managerArr', $managerArr);

        // источники
        $sources = Shop::Get()->getShopService()->getSourceAll();
        $this->setValue('sourceArray', $sources->toArray());

        // список всех компаний с учетом фильтра

        if ($filterCompany) {
            $datasource->getSQLObject()->unsetField('company');
        }

        $sqlobject = clone $datasource->getSQLObject();

        $this->setValue('companyArray', $this->_makeCompanyArray($sqlobject));
        $this->setValue('selectedcompany', $this->getArgumentSecure('company'));

        $login = Shop::Get()->getSettingsService()->getSettingValue('turbosms-login');
        $pass = Shop::Get()->getSettingsService()->getSettingValue('turbosms-password');
        $sender = Shop::Get()->getSettingsService()->getSettingValue('turbosms-sender');
        if ($sender && $login && $pass) {
            $this->setValue('canSMS', true);
        }

        try {
            $companyID = $this->getArgument('companyid');
            $company = Shop::Get()->getUserService()->getUserByID($companyID);
            if (!$company->getId()) {
                throw new ServiceUtils_Exception();
            }

            $this->setValue('companyPreviewID', $company->getId());
            $this->setValue('companyPreviewName', $company->makeName());
            $this->setValue('companyPreviewLogo', $company->makeImageThumb(100, 100));
            $this->setValue('companyPreviewURL', $company->makeURLEdit());

            $this->setValue('companyPreviewEmailArray', $company->getEmailArray());
            $this->setValue('companyPreviewPhoneArray', $company->getPhoneArray());
            $this->setValue('companyPreviewAddress', $company->getAddress());
            $this->setValue('companyPreviewURLs', $company->getURLs());
            $this->setValue('companyPreviewTags', $company->getTags());
            $this->setValue('companyPreviewInfo', $company->getPost());

            try {
                $this->setValue('companyPreviewManagerName', $company->getManager()->makeName(true, false));
                $this->setValue('companyPreviewManagerURL', $company->getManager()->makeURLEdit());
            } catch (Exception $e) {

            }

            $block = Engine::GetContentDriver()->getContent('user-block-company');
            $block->setValue('company', $company);
            $this->setValue('block_company', $block->render());

            /*$block = Engine::GetContentDriver()->getContent('user-block-statistic');
            $block->setValue('user', $company);
            $this->setValue('block_statistic', $block->render());

            $block = Engine::GetContentDriver()->getContent('user-block-charts');
            $block->setValue('user', $company);
            $this->setValue('block_charts', $block->render());*/
        } catch (Exception $e) {

        }
    }

    private function _makeCompanyArray($sqlobject) {
        $companiesArray = array();
        $sqlobject->setOrder('company','ASC');
        $sqlobject->addWhere('company', '', '!=');

        while ($x = $sqlobject->getNext()) {
            $companiesArray[] = $x->getCompany();
        }
        $companiesArray = array_unique($companiesArray);

        $a = array();
        foreach ($companiesArray as $companyname) {
            try {
                $existCompany = Shop::Get()->getShopService()->getCompanyByName($companyname);

                if ($existCompany->getImage()) {
                    $image = $existCompany->makeImageThumb(200, 200);
                } else {
                    $image = false;
                }

                $a[] = array(
                'name' => $companyname,
                'url' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('company' => $companyname, 'companyid' => $existCompany->getId())),
                'urledit' => $existCompany->makeURLEdit(),
                'image' => $image,
                'description' => $existCompany->getPost(),
                );
            } catch (Exception $e) {
                $a[] = array(
                'name' => $companyname,
                'url' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('company' => $companyname, 'companyid' => 0)),
                );
            }
        }
        return $a;
    }

    private function _makeGroupArray() {
        $groups = Shop::Get()->getUserService()->getUserGroupsAll();
        $groups->setLogicclass('');
        $groupsArray = array();
        while($x = $groups->getNext()) {
            $a = array();
            $a['id'] = $x->getId();
            $a['name'] = $x->getName();
            $groupsArray[] = $a;
        }
        return $groupsArray;
    }

    private function _makeManagerArray() {
        $managers = Shop::Get()->getUserService()->getUsersManagers();
        $managersInfo = array();
        while($x = $managers->getNext()){
            $a = array();
            $a['id'] = $x->getId();
            $a['name'] = $x->makeName();
            $managersInfo[] = $a;
        }
        return $managersInfo;
    }

    private function _makeLevelArray() {
        $levelArr = array();
        for($i = 0;$i < 4; $i++){
            $b = array();
            $b['id'] = $i;
            if($i == 0){
                $b['name'] = 'Заблокирован';
            }
            if($i == 1){
                $b['name'] = 'Пользователь';
            }
            if($i == 2){
                $b['name'] = 'Менеджер';
            }
            if($i == 3){
                $b['name'] = 'Администратор';
            }
            $levelArr[] = $b;
        }
        return $levelArr;

    }

}