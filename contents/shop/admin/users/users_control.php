<?php
class users_control extends Engine_Class {

    public function process() {
        try {
            $user = Shop::Get()->getUserService()->getUserByID(
            $this->getArgument('id')
            );

            if (!Shop::Get()->getUserService()->isUserViewAllowed($user, $this->getUser())) {
                throw new ServiceUtils_Exception('user');
            }

            $canEdit = Shop::Get()->getUserService()->isUserChangeAllowed($user, $this->getUser());
            $this->setValue('canEdit', $canEdit);

            // комментарии
            PackageLoader::Get()->import('CommentsAPI');
            $commentKey = 'shop-user-control-'.$user->getId();

            // custom fields
            try {
                $customFieldArray = Engine::Get()->getConfigField('project-box-customfield-user');
            } catch (Exception $e) {
                $customFieldArray = array();
            }

            if ($canEdit && $this->getControlValue('ok')) {
                try {
                    SQLObject::TransactionStart();

                    $phones = trim($this->getControlValue('phones'));
                    $phones = str_replace(",", "\n", $phones);
                    $phoneArray = explode("\n", $phones);
                    $phone = trim($phoneArray[0]);
                    unset($phoneArray[0]);
                    $phones = implode("\n", $phoneArray);

                    $emails = trim($this->getControlValue('emails'));
                    $emails = str_replace(",", "\n", $emails);
                    $emailArray = explode("\n", $emails);
                    $email = trim($emailArray[0]);
                    unset($emailArray[0]);
                    $emails = implode("\n", $emailArray);

                    Shop::Get()->getUserService()->updateUserProfile(
                    $user,
                    $email,
                    false,
                    $this->getControlValue('name'),
                    $phone,
                    $this->getControlValue('address'),
                    $this->getControlValue('bdate'),
                    $phones,
                    $emails,
                    $this->getControlValue('urls'),
                    $this->getControlValue('time'),
                    $this->getControlValue('parentid'),
                    false, // не выполнять проверки
                    $this->getControlValue('commentadmin'),
                    $this->getControlValue('managerid'),
                    $this->getControlValue('groupid'),
                    $this->getControlValue('login'),
                    $this->getControlValue('company'),
                    $this->getControlValue('pricelevel'),
                    $this->getArgumentSecure('distribution'),
                    $this->getControlValue('tags'),
                    $this->getControlValue('cdate'),
                    $this->getControlValue('namelast'),
                    $this->getControlValue('namemiddle'),
                    $this->getControlValue('post'),
                    $this->getControlValue('typesex'),
                    $this->getControlValue('skype'),
                    $this->getControlValue('jabber'),
                    $this->getControlValue('whatsapp'),
                    $this->getArgumentSecure('employer'),
                    (int)$this->getArgumentSecure('allowreferal')
                    );

                    $image = $this->getControlValue('avatarimage');
                    if ($image) {
                        try {
                            $image = @$image['tmp_name'];
                            Shop::Get()->getShopService()->updateUserAvatarImage($user, $image);
                        } catch (Exception $imageEx) {

                        }
                    }

                    if ( $this->getControlValue('deleteimage') ){
                        $file = MEDIA_PATH.'/shop/'.$user->getImage();
                        @unlink($file);
                        $user->setImage('');
                    }

                    $user->setSourceid($this->getControlValue('sourceid'));
                    $user->update();

                    //сохранение друзей
                    //друзья которые выбраны в селекте

                    try {
                        $userDo = Shop::Get()->getUserService()->getUser();

                        CommentsAPI::Get()->addComment(
                        'shop-history-user-update'.$user->getId(),
                        Shop::Get()->getTranslateService()->getTranslate('translate_edit_by_user').' #'.$user->getId().' '.$user->makeName(),
                        $userDo->getId()
                        );
                    } catch (Exception $e) {

                    }

                    SQLObject::TransactionCommit();

                    $this->setValue('message', 'ok');
                } catch (ServiceUtils_Exception $e) {
                    SQLObject::TransactionRollback();

                    if (PackageLoader::Get()->getMode('debug')) {
                        print $e;
                    }

                    $this->setValue('message', 'error');
                    $this->setValue('errorsArray', $e->getErrorsArray());
                }
            }

            Engine::GetHTMLHead()->setTitle($user->makeName());
            $this->setValue('userid', $user->getId());
            $this->setValue('login', $user->getLogin());
            $this->setControlValue('emails', implode("\n", $user->getEmailArray()));
            $this->setControlValue('phones', implode("\n", $user->getPhoneArray()));
            $this->setControlValue('name', $user->getName());
            $this->setControlValue('address', $user->getAddress());
            $this->setControlValue('distribution', $user->getDistribution());
            $this->setControlValue('employer', $user->getEmployer());
            $this->setControlValue('level', $user->getLevel());
            $this->setControlValue('allowreferal', $user->getAllowreferal());
            $this->setControlValue('tags', $user->getTags());
            $this->setControlValue('sourceid', $user->getSourceid());
            $this->setValue('srcimage', $user->getImage());
            $this->setValue('avatarimage', $user->makeImageThumb(100, 100));

            $bdate = $user->getBdate();
            if ($bdate != "0000-00-00" && date("m-d", strtotime($bdate)) == date("m-d")) {
                $this->setValue('birthday', true);
            }

            if ($bdate == "0000-00-00") {
                $bdate = '';
            }
            $this->setControlValue('bdate', $bdate);

            $cdate = $user->getCdate();
            if ($cdate == "0000-00-00") {
                $cdate = '';
            }
            $this->setControlValue('cdate', $cdate);

            $this->setControlValue('urls', $user->getUrls());
            $this->setControlValue('time', $user->getTime());
            $this->setControlValue('parentid',$parentid = $user->getParentid());

            try {
                $recomendUser = Shop::Get()->getUserService()->getUserByID($parentid);
                $this->setControlValue('parent_href',$recomendUser->makeURLEdit());
                $this->setControlValue('parentname',$recomendUser->makeName());
            }catch(Exception $e){

            }
            $this->setControlValue('commentadmin', $user->getCommentadmin());
            $this->setControlValue('managerid', $user->getManagerid());
            $this->setControlValue('groupid', $user->getGroupid());

            $company = $user->getCompany();

            if ($company && $user->getTypesex() != 'company') {
                $companyNameArray = explode(',', $company);
                $companyArray = array();

                foreach ($companyNameArray as $tmpCompanyName) {
                    $tmpCompanyName = trim($tmpCompanyName);

                    try {
                        $existCompany = Shop::Get()->getShopService()->getCompanyByName($tmpCompanyName);

                        $companyArray[] = array(
                        'name' => $existCompany->makeName(),
                        'url' => $existCompany->makeURLEdit()
                        );

                    } catch (Exception $companyEx) {

                    }
                }

                $this->setValue('companyArray', $companyArray);
            }

            $this->setControlValue('company', $company);

            $this->setControlValue('post', $user->getPost());
            $this->setControlValue('pricelevel', $user->getPricelevel());
            $this->setControlValue('namelast', $user->getNamelast());
            $this->setControlValue('namemiddle', $user->getNamemiddle());
            $this->setControlValue('typesex', $user->getTypesex());

            // интеграция с картами
            if ($user->getAddress()) {
                PackageLoader::Get()->registerJSFile('https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false');
                $this->setValue('address', $user->getAddress());
            }

            // ---
            $managers = Shop::Get()->getUserService()->getUsersManagers();
            $a = array();
            while ($x = $managers->getNext()) {
                $a[] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(),
                );
            }
            $this->setValue('managerArray', $a);

            $groups = Shop::Get()->getUserService()->getUserGroupsAll();
            $groups->setLogicclass('');
            $a = array();
            while ($x = $groups->getNext()) {
                $a[] = array(
                'id' => $x->getId(),
                'name' => $x->getName(),
                );
            }
            $this->setValue('groupsArray', $a);

            $menu = Engine::GetContentDriver()->getContent('shop-admin-users-menu');
            $menu->setValue('selected', 'edit');
            $menu->setValue('userid', $user->getId());
            $this->setValue('menu', $menu->render());

            $block = Engine::GetContentDriver()->getContent('user-block-statistic');
            $block->setValue('user', $user);
            $this->setValue('block_statistic', $block->render());

            $this->setValue('emailArray', $user->getEmailArray());

            $canSmsPhonesArray = array();
            foreach ($user->getPhoneArray() as $phone) {
                $canSmsPhonesArray[$phone] = strlen($phone) >= 10 ? true : false;
            }
            $this->setValue('phoneArray', $user->getPhoneArray());
            $this->setValue('canSmsPhonesArray', $canSmsPhonesArray);

            $turboSmsLogin =  Shop::Get()->getSettingsService()->getSettingValue('turbosms-login');
            $turboSmsPass = Shop::Get()->getSettingsService()->getSettingValue('turbosms-password');
            $turboSmsSender = Shop::Get()->getSettingsService()->getSettingValue('turbosms-sender');
            if ($turboSmsLogin && $turboSmsPass && $turboSmsSender) {
                $this->setValue('canSMS', true);
            }

            if (Engine::Get()->getConfigFieldSecure('project-box')) {
                $this->setValue('box', true);

                // voip originate
                $this->setValue('canOriginate', !!Engine::Get()->getConfigFieldSecure('asterisk-ami'));

                if ($user->getTypesex() == 'company') {
                    $block = Engine::GetContentDriver()->getContent('user-block-company');
                    $block->setValue('company', $user);
                    $this->setValue('block_company', $block->render());
                }

                /*$block = Engine::GetContentDriver()->getContent('user-block-charts');
                $block->setValue('user', $user);
                $this->setValue('block_charts', $block->render());*/

                if ($user->getLogin()) {
                    $block = Engine::GetContentDriver()->getContent('user-block-workflow');
                    $block->setValue('user', $user);
                    $this->setValue('block_workflow', $block->render());
                }

                $this->setControlValue('skype', $user->getSkype());
                $skypeArray = explode("\n", $user->getSkype());
                $this->setValue('skypeArray', $skypeArray);

                $this->setControlValue('jabber', $user->getJabber());
                $jabberArray = explode("\n", $user->getJabber());
                $this->setValue('jabberArray', $jabberArray);

                $this->setControlValue('whatsapp', $user->getWhatsapp());
                $whatsappArray = explode("\n", $user->getWhatsapp());
                $this->setValue('whatsappArray', $whatsappArray);

                // источники
                $sources = Shop::Get()->getShopService()->getSourceAll();
                $this->setValue('sourceArray', $sources->toArray());

                // список родителей
                try {
                    $a = array();
                    $p = clone $user;

                    $a[$p->getId()] = array(
                    'name' => $p->makeName(),
                    'url' => $p->makeURLEdit(),
                    'cdate' => DateTime_Formatter::DateISO8601($p->getCdate()),
                    );

                    while (1) {
                        try {
                            $p = Shop::Get()->getUserService()->getUserByID(
                            $p->getParentid()
                            );

                            if (isset($a[$p->getId()])) {
                                break;
                            }

                            $a[$p->getId()] = array(
                            'name' => $p->makeName(),
                            'url' => $p->makeURLEdit(),
                            'cdate' => DateTime_Formatter::DateISO8601($p->getCdate()),
                            );
                        } catch (Exception $e) {
                            break;
                        }
                    }

                    if (count($a) > 1) {
                        $this->setValue('parentArray', $a);
                    }

                } catch (Exception $parentsEx) {

                }

                // список порекомендовавших
                $a = array();
                $childs = Shop::Get()->getUserService()->getUsersAll($this->getUser());
                $childs_for = clone $childs;//обьект для работы в условиях
                $childs->setId($user->getId());
                $type_sex =  $childs->getNext();
                $type_sex = $type_sex->getTypesex();//узнать чья карточка(пол)

                if ($type_sex === 'company') {
                    $users_recomend = new $user;
                    $users_recomend->setCompany($company);
                    while ($user_recomend = $users_recomend->getNext()) {
                        $childs_for->setParentid($user_recomend->getId());
                        while ($p = $childs_for->getNext()) {
                            $a[] = array(
                            'name' => $p->makeName(),
                            'url' => $p->makeURLEdit(),
                            'cdate' => DateTime_Formatter::DateISO8601($p->getCdate()),
                            );
                        }
                    }
                } else {
                    $childs_for->setParentid($user->getId());
                    while ($p = $childs_for->getNext()) {
                        $a[] = array(
                        'name' => $p->makeName(),
                        'url' => $p->makeURLEdit(),
                        'cdate' => DateTime_Formatter::DateISO8601($p->getCdate()),
                        'id' => $p->getId()
                        );
                    }
                }
                $this->setValue('childArray', $a);


                // список проблем notify
                $notify = Engine::GetContentDriver()->getContent('notify-block');
                $notify->setValue('key', 'contact-'.$user->getId());
                $this->setValue('block_notify', $notify->render());

                // Список бизнес-процессов
                $category = Shop::Get()->getShopService()->getWorkflowsActive($this->getUser());
                $a = array();
                while ($x = $category->getNext()) {
                    $p = array();
                    $p['workflowid'] = $x->getId();
                    $p['clientid'] = $user->getId();
                    $p['clientname'] = $user->makeName();

                    $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->makeName(),
                    'url' => Engine::GetLinkMaker()->makeURLByContentIDParams('issue-add', $p),
                    );
                }
                $this->setValue('workflowArray', $a);
            }

            // выводим всех друзей данного контакта
            $friendsArray = Shop::Get()->getUserService()->getFriends($this->getArgument('id'));
            $friendsArrayReturn = array();
            foreach ($friendsArray as $x) {
                try{
                    $user = Shop::Get()->getUserService()->getUserByID($x);
                    $friendsArrayReturn[] = array(
                        'id' => $user->getId(),
                        'name' => $user->makeName(true, 'lfm'),
                        'url' => $user->makeURLEdit(),
                    );
                } catch (Exception $e) {
                    $friendsArrayReturn[] = array(
                        'id' => $x,
                        'name' => $x
                    );
                }
            }

            $this->setValue('friendsArray', $friendsArrayReturn);

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }
            print $ge;

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}