<?php
class users_mailing extends Engine_Class {

    public function process() {
        ini_set('max_input_vars', 100000);
        ini_set('suhosin.post.max_vars', 100000);
        ini_set('suhosin.request.max_vars', 100000);
        ini_set('memory_limit', '512M');
        set_time_limit(5 * 60); // 5 min

        PackageLoader::Get()->registerJSFile('/_js/jQueryFilter.js');
        PackageLoader::Get()->import('CKFinder');
        CKFinder_Configuration::Get()->setAuthorized(true);

        // ловим всех отмеченных юзеров
        $usersArray = $this->getControlValue('user');

        // отправляем письма
        if ($this->getControlValue('ok')) {
            $sendsArray = false;
            try {
                $text = $this->getControlValue('text');
                $subject = $this->getControlValue('subject');
                $mail = $this->getControlValue('mail');

                $filesArray = array();
                for ( $i = 1; $i <= 5; $i++ ) {
                    $file = $this->getControlValue('file'.$i);
                    if ( file_exists( $file['tmp_name']) ){
                        $filesArray[] = $file;
                    }
                }
                $content = '';
                if ($des = $this->getControlValue('design')) {
                    $des = iconv('utf-8', 'windows-1251', $des);
                    $content = file_get_contents(PackageLoader::Get()->getProjectPath().'/media/mail-design/'.$des);
                }

                $cnt = 0;


                if ($this->getArgumentSecure('arrUserId')) {
                    $usersIdArray = explode(';', $this->getArgumentSecure('arrUserId'));
                    foreach ($usersIdArray as $userID) {
                        if (!$userID) {
                            continue;
                        }
                        try {
                            $us = Shop::Get()->getUserService()->getUserByID($userID);
                            if (!$us->getDistribution()) {
                                continue;
                            }
                            if (!Checker::CheckEmail($us->getEmail())) {
                                continue;
                            }

                            $sendsArray[$userID] = array(
                                'id' => $userID,
                                'url' => $us->makeURLEdit(),
                                'email' => $us->getEmail()
                            );
                            $sendsArray[$userID]['send'] = 1;

                            $this->_sendEmail($userID, $text, $subject, $mail, $filesArray, $newsArray2, $content);
                            $cnt ++;
                        } catch (Exception $sendEx) {
                            $sendsArray[$userID]['send'] = 0;

                        }

                    }

                } else {
                    //если get запроса нету берем всех
                    if (!$usersArray) {
                        $AllUsers = Shop::Get()->getUserService()->getUsersAll();
                        //$AllUsers->setDistribution(1);
                        //$AllUsers->addWhere('email', '','<>');
                        while ($x = $AllUsers->getNext()) {
                            $usersArray[] = $x->getId();
                        }

                    }
                    foreach ($usersArray as $userID) {
                        try {
                            $us = Shop::Get()->getUserService()->getUserByID($userID);
                            $sendsArray[$userID] = array(
                                'id' => $userID,
                                'url' => $us->makeURLEdit(),
                                'email' => $us->getEmail()
                            );
                            $this->_sendEmail($userID, $text, $subject, $mail, $filesArray, $newsArray2, $content);
                            $sendsArray[$userID]['send'] = 1;

                            $cnt ++;
                        } catch (Exception $sendEx) {
                            $sendsArray[$userID]['send'] = 0;
                        }

                    }
                }
                $this->setValue('message', 'ok');
                $this->setValue('sendsArray', $sendsArray);
                $this->setValue('cnt', $cnt);
            } catch (Exception $se) {
                $this->setValue('message', 'error');
            }
        } else {

            if ($this->getControlValue('test')) {
                try{
                    $userID = $this->getUser()->getId();
                    $text = $this->getControlValue('text');
                    $subject = $this->getControlValue('subject');
                    $mail = $this->getControlValue('mail');

                    $filesArray = array();
                    for ( $i = 1; $i <= 5; $i++ ) {
                        $file = $this->getControlValue('file'.$i);
                        if ( file_exists( $file['tmp_name']) ){
                            $filesArray[] = $file;
                        }
                    }


                    $content = '';
                    if ($des = $this->getControlValue('design')) {
                        $des = iconv('utf-8', 'windows-1251', $des);
                        $content = file_get_contents(PackageLoader::Get()->getProjectPath().'/media/mail-design/'.$des);
                    }

                    $this->_sendEmail($userID,$text,$subject,$mail,$filesArray, $newsArray2, $content);
                    $this->setValue('message', 'ok');
                    $this->setValue('cnt', 1);
                } catch (Exception $se) {
                    $this->setValue('message', 'error');
                }
            }

        }
        // заполняем обратный адрес по умолчанию
        $this->setControlValue('mail', Shop::Get()->getSettingsService()->getSettingValue('header-email'));




        // шаблоны писем

        $designArray = scandir(PackageLoader::Get()->getProjectPath().'/media/mail-design');
        $designs = array();
        foreach ($designArray as $val) {
            if ($val == '.' || $val == '..') {
                continue;
            }

            if (strtolower(end(explode(".", $val))) == 'html') {
                $val = iconv('windows-1251','utf-8' ,$val);
                $designs[] = array(
                    'name' => $val
                );
            }
        }

        $this->setValue('designArray', $designs);

        if ($this->getArgumentSecure('arrUserId')) {
            $userIdArray = explode(';', $this->getArgumentSecure('arrUserId'));
            $emailCount = 0;
            $disCount = 0;
            foreach ($userIdArray as $userId) {
                try{
                    $user = Shop::Get()->getUserService()->getUserByID($userId);

                    if (Checker::CheckEmail($user->getEmail())) {
                        $emailCount++;
                        if ($user->getDistribution()) {
                            $disCount++;
                        }
                    }
                } catch (Exception $e) {

                }

            }
            $this->setValue('disCount', $disCount);
            $this->setValue('emailCount', $emailCount);
            $this->setValue('arrUserId', $this->getArgumentSecure('arrUserId'));

        } else {
            // если нету get
            if (!$usersArray) {
                $AllUsers = Shop::Get()->getUserService()->getUsersAll();
                $AllUsers->addWhere('email', '','<>');
                $emailCount = 0;
                $disCount = 0;
                while ($x = $AllUsers->getNext()) {
                    if (Checker::CheckEmail($x->getEmail())) {
                        $emailCount++;
                        if ($x->getDistribution()) {
                            $disCount++;
                        }

                    }

                }
                $this->setValue('disCount', $disCount);
                $this->setValue('emailCount', $emailCount);

            } else {
                // get
                $emailCount = 0;
                $disCount = 0;
                foreach ($usersArray as $us) {
                    try{
                         $user = Shop::Get()->getUserService()->getUserByID($us);
                        if (Checker::CheckEmail($user->getEmail())) {
                            $emailCount++;
                            if ($user->getDistribution()) {
                                $disCount++;
                            }

                        }

                    } catch (Exception $e) {

                    }

                }

                $this->setValue('disCount', $disCount);
                $this->setValue('emailCount', $emailCount);
            }

        }
    }

    private function _sendEmail($userID, $text, $subject, $emailFrom, $filesArray, $newsArray = false, $content = false){
        $user = Shop::Get()->getUserService()->getUserByID($userID);
        if (!$user->getDistribution()) {
            throw new Exception();
        }

        $nameFirst =  trim($user->getName());
        $nameLast = trim($user->getNamelast());
        $nameMiddle = trim($user->getNamemiddle());

        $prefix = '';
        if ($user->getTypesex() == 'man') {
            $prefix = Shop::Get()->getTranslateService()->getTranslate('translate_dear_man');
        } else if($user->getTypesex() == 'woman') {
            $prefix = Shop::Get()->getTranslateService()->getTranslate('translate_dear_woman');
        }

        if ($user->getTypesex() == 'company') {
            $nameSmart = $user->getCompany();
        } else {
            $nameSmart = trim($nameFirst.' '.$nameMiddle);
        }

        $urlUnsubscribe = Engine::Get()->getProjectURL().'/unsubscribe/';
        $urlUnsubscribe .= '?email='.$user->getEmail().'&code='.$user->getId();

        if ($content) {
            $text = str_replace('[content]', $text, $content);
        }

        $text = str_replace('[name]', $user->makeName(), $text);
        $text = str_replace('[name_smart]', $nameSmart, $text);
        $text = str_replace('[name_first]',$nameFirst, $text);
        $text = str_replace('[name_last]',$nameLast, $text);
        $text = str_replace('[name_middle]', $user->getNamemiddle(), $text);
        $text = str_replace('[name_first_last]', $nameFirst.'_'.$nameLast, $text);
        $text = str_replace('[company]', $user->getCompany(), $text);
        $text = str_replace('[email]', $user->getEmail(), $text);
        $text = str_replace('[phone]', $user->getPhone(), $text);
        $text = str_replace('[perfix]', $prefix, $text);
        $text = str_replace('[url_unsubscribe]', $urlUnsubscribe, $text);


        // убираем лишние вставки
        $text = str_replace('[news]', '', $text);

        // отправка письма
        Shop::Get()->getUserService()->sendEmail(
        $emailFrom,
        $user->getEmailArray(),
        $subject,
        $text,
        $filesArray
        );
    }

}