<?php
class shop_tpl extends Engine_Class {

    public function process() {
        PackageLoader::Get()->registerJSFile('/_js/shop.loading.js');
        $this->setValue('shopname', "mixFun");
        $this->setValue('favicon', Shop::Get()->getSettingsService()->getSettingValue('favicon'));

        $user = false;

        $menuArray1 = array();
        $menuArray2 = array();
        try {
            $user = $this->getUser();
            $this->setValue("userId", $user->getId());

            $menuArray1[] = array(
                "name" => "Мои покупки",
                "selected" => 0,
                "url" => "/buy/"
            );
            $menuArray1[] = array(
                "name" => "Мои продажи",
                "selected" => 0,
                "url" => "/sale/"
            );
            $menuArray1[] = array(
                "name" => "Сообщения",
                "selected" => 0,
                "url" => "/chat/"
            );
            $menuArray1[] = array(
                "name" => "Кабинет",
                "selected" => 0,
                "url" => "/profile/"
            );


            $menuArray2[] = array(
                "name" => $user->makeLogin(),
                "selected" => 0,
                "url" => ""
            );

            $menuArray2[] = array(
                "name" => "Exit",
                "selected" => 0,
                "url" => "/logout/"
            );


            if ($user->getLogin()){
                $this->setValue('userlogin', $user->getLogin());
            } else {
                $this->setValue('userlogin', $user->getEmail());
            }
            $this->setValue('userName',  $user->makeName(true, false));
            $this->setValue('avatar', $user->makeImageGravatar());

            if ($user->isAdmin()) {
                $this->setValue('admin', true);
            }
        } catch (Exception $e) {
            $menuArray2[] = array(
                "name" => "Войти",
                "selected" => 0,
                "url" => "/login/"
            );

            $menuArray2[] = array(
                "name" => "Зарегистрироваться",
                "selected" => 0,
                "url" => "/registration/"
            );
        }

        $menuArray1[] = array(
            "name" => "Помощь",
            "selected" => 0,
            "url" => ""
        );

        $this->setValue("menuArray1", $menuArray1);
        $this->setValue("menuArray2", $menuArray2);

        //////////////////////////////////////////////////////////////////////////////////


        // редиректы
        $host = Engine::GetURLParser()->getHost();
        $projecthost = Engine::Get()->getProjectHost();
        if ($host != $projecthost
        && (Engine::Get()->getRequest()->getContentID() != 'shop-category'
        && Engine::Get()->getRequest()->getContentID() != 'shop-product')
        ) {
            $url = Engine::Get()->getProjectURL().Engine::GetURLParser()->getTotalURL();
            header('Location: '.$url);
            exit();
        }

        // интеграции (настройки)
        $contentID = Engine::Get()->getRequest()->getContentID();

        // интеграции
        $content = Engine::GetContentDriver()->getContent($contentID);
        if ($content->getField('moveto') != 'shop-client-tpl'
        && $content->getField('id') != 'shop-order') {
            $this->setValue('integration_cloudim', Shop::Get()->getSettingsService()->getSettingValue('integration-cloudim'));
            $this->setValue('integration_ga', Shop::Get()->getSettingsService()->getSettingValue('integration-googleanalytics'));
            $this->setValue('integration_google_wmt', Shop::Get()->getSettingsService()->getSettingValue('integration-google-wmt'));
            $this->setValue('integration_yandex_wmt', Shop::Get()->getSettingsService()->getSettingValue('integration-yandex-wmt'));
            $this->setValue('integration_liveinternet', Shop::Get()->getSettingsService()->getSettingValue('integration-liveinternet'));
        }

        // ------------------------------------------------- //

        // показывать или нет ссылку на админ панель
        // показываем информацию о юзере


        // настройки
        $phones = trim(strip_tags(Shop::Get()->getSettingsService()->getSettingValue('header-phone')));
        $phones = explode(',', $phones);
        shuffle($phones);
        for ($i = 1; $i < count($phones)+1; $i++){
            $this->setValue("phone$i", $phones[$i-1]);
        }

        $this->setValue('icq', trim(strip_tags(Shop::Get()->getSettingsService()->getSettingValue('header-icq'))));
        $this->setValue('skype', trim(strip_tags(Shop::Get()->getSettingsService()->getSettingValue('header-skype'))));
        $this->setValue('address', Shop::Get()->getSettingsService()->getSettingValue('company-address'));
        $this->setValue('worktime', Shop::Get()->getSettingsService()->getSettingValue('work-time'));
        $this->setValue('email', trim(strip_tags(Shop::Get()->getSettingsService()->getSettingValue('header-email'))));
        $this->setValue('logo', Shop::Get()->getSettingsService()->getSettingValue('header-logo'));
        $this->setValue('shopName', htmlspecialchars(Shop::Get()->getSettingsService()->getSettingValue('shop-name')));
        $this->setValue('copyright', Shop::Get()->getSettingsService()->getSettingValue('copyright'));
        $this->setValue('background', Shop::Get()->getSettingsService()->getSettingValue('background-image'));


        // SEO
        try {
            $seo = Shop::Get()->getSEOService()->getSEOByURL(
            Engine::GetURLParser()->getTotalURL()
            );

            if ($seo->getSeotitle()) {
                Engine::GetHTMLHead()->setTitle(
                $seo->getSeotitle()
                );
            }

            if ($seo->getSeokeywords()) {
                Engine::GetHTMLHead()->setMetaKeywords(
                $seo->getSeokeywords()
                );
            }

            if ($seo->getSeodescription()) {
                Engine::GetHTMLHead()->setMetaDescription(
                $seo->getSeodescription()
                );
            }

            if ($seo->getSeocontent()) {
                $this->setValue('seocontent', $seo->getSeocontent());
            }

        } catch (Exception $seoEx) {

        }

        // если title нет - по умочанию ставим название магазина
        if (!Engine::GetHTMLHead()->getTitle()) {
            Engine::GetHTMLHead()->setTitle(Shop::Get()->getSettingsService()->getSettingValue('shop-name'));
        }

        $this->setValue('paymentUrl', $this->_makePagesUrlByLogicclass('shop-payment'));

        $this->setValue('main', Engine::Get()->getProjectURL());

        $this->setValue('favicon', Shop::Get()->getSettingsService()->getSettingValue('favicon'));
        $this->setValue('integration_yandex_counter', Shop::Get()->getSettingsService()->getSettingValue('integration-yandex-counter'));


        $title = Engine::GetHTMLHead()->getTitle();
        $title = $this->_processKeywords($title);
        $title = str_replace('&quot;', '', $title);
        $title = preg_replace('/[^a-zA-ZА-Яа-я0-9їЇіІєЄёЁ\+\-\,\.\#\№\:\;\|\(\)]/u', ' ', $title);

        // автоматическая транслитерация en->ru для всех русских фраз
        if (Engine::Get()->getConfigFieldSecure('seo-transliterate-en2ru-auto')) {
            $title = preg_replace_callback("/([a-z-\.\s]+)/ius", array($this, '_seoTitle_en2ru'), $title);
        }

        $description = Engine::GetHTMLHead()->getMetaDescription();
        $description = $this->_processKeywords($description);
        $keywords = Engine::GetHTMLHead()->getMetaKeywords();
        $keywords = $this->_processKeywords($keywords);

        Engine::GetHTMLHead()->setMetaDescription($description);
        Engine::GetHTMLHead()->setMetaKeywords($keywords);

        // если нет seo контента - то строим его автоматически
        if (!$this->getValue('seocontent')) {
            $metaDescription = Engine::GetHTMLHead()->getMetaDescription();
            $metaKeywords = Engine::GetHTMLHead()->getMetaKeywords();

            if ($metaDescription || $metaKeywords) {
                $this->setValue('seocontent', $metaKeywords.' '.$metaDescription);
            }
        }

        // !!! эти строки должны быть в самом конце !!!
        $this->setValue('title', $title);
        $this->setValue('engine_includes', Engine::GetHTMLHead()->render());
        // !!! после этой строки ничего не дописывать !!!

        //-------------------Вывод склееных и сжатых css и js файлов----------------------------//
        /* $rev = false;
        $revInfoFile = PackageLoader::Get()->getProjectPath().'rev.info';
        if (file_exists($revInfoFile)) {
            $rev = file_get_contents($revInfoFile);
        }
        $jsCacheDir = '/_js/cache/';
        $cssCacheDir = '/_css/cache/';

        $cssUrl = "/{$cssCacheDir}client-{$rev}.min.css";
        $cssUrl = str_replace('//', '/', $cssUrl);
        $this->setValue('cssUrl', $cssUrl);

        $jsUrl = "/{$jsCacheDir}client-{$rev}.min.js";
        $jsUrl = str_replace('//', '/', $jsUrl);
        $this->setValue('jsUrl', $jsUrl);*/

        //-------------------Конец вывода склееных и сжатых css и js файлов-----------------------//
    }


    /**
     * @param $logicclass
     * @return bool|string
     */
    private function _makePagesUrlByLogicclass($logicclass) {
        try {
            return Shop::Get()->getTextPageService()->getTextPageByLogicclass($logicclass)->makeURL();
        } catch (Exception $e) {
            return false;
        }
    }

    private function _seoTitle_en2ru($s) {
        $s = $s[1];

        if (preg_match("/[a-z]+/ius", $s)) {
            // если найдены буквы
            if (preg_match("/\s+$/ius", $s)) {
                // если в конце есть пробел

                $t = StringUtils_Transliterate::TransliterateEnToRu($s);

                $s .= ''.$t.' ';
            } elseif (preg_match("/^\s+/ius", $s)) {
                // в начале есть пробел

                $t = StringUtils_Transliterate::TransliterateEnToRu($s);

                $s .= ' '.$t.'';
            }
        }

        return $s;
    }

    /**
     * Заменить ключевые слова
     */
    private function _processKeywords($s) {
        $s = str_replace('[phones]', Shop::Get()->getSettingsService()->getSettingValue('header-phone'), $s);
        $s = str_replace('[slogan]', Shop::Get()->getSettingsService()->getSettingValue('shop-slogan'), $s);
        $s = str_replace('[shopname]', Shop::Get()->getSettingsService()->getSettingValue('shop-name'), $s);
        return $s;
    }

}