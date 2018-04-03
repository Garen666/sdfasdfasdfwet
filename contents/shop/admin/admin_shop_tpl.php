<?php
class admin_shop_tpl extends Engine_Class {

    public function process() {
        PackageLoader::Get()->registerJSFile('/_js/jQueryTabs.js');
        PackageLoader::Get()->registerJSFile('/_js/select2.js');
        PackageLoader::Get()->registerJSFile('/_js/jquery.caret.js');
        PackageLoader::Get()->registerCSSFile('/_css/select2-modern.css');
        PackageLoader::Get()->registerJSFile('/_js/jquery.tablesorter.js');
        PackageLoader::Get()->registerJSFile('/_js/jquery.autosize.js');
        PackageLoader::Get()->registerJSFile('/_js/jquery.dataTables.min.js');
        PackageLoader::Get()->registerJSFile('/_js/FixedColumns.min.js');
        PackageLoader::Get()->registerJSFile('/_js/perfect-scrollbar.js');
        PackageLoader::Get()->registerCSSFile('/_css/perfect-scrollbar.css');
        PackageLoader::Get()->registerJSFile('/_js/jquery.ui.timepicker.addon.js');
        PackageLoader::Get()->registerCSSFile('/_css/jquery.ui.timepicker.addon.css');
        PackageLoader::Get()->registerJSFile('/_js/jquery.tag.it.js');
        PackageLoader::Get()->registerCSSFile('/_css/jquery.tagit.css');
        PackageLoader::Get()->registerJSFile('/_js/jquery.tooltipster.js');
        PackageLoader::Get()->registerCSSFile('/_css/jquery.tooltipster.css');
        PackageLoader::Get()->registerJSFile('/_js/jquery.textcomplete.js');
        PackageLoader::Get()->registerCSSFile('/_css/jquery.textcomplete.css');
        PackageLoader::Get()->registerJSFile('/_js/jQueryFilter.js');
        PackageLoader::Get()->registerJSFile('/_js/jquery-ui.js');
        PackageLoader::Get()->registerCSSFile('/_css/jquery-ui.css');

        // подключение JS API и SelectWindow
        PackageLoader::Get()->registerJSFile('/contents/shop/api/api.js');
        PackageLoader::Get()->registerJSFile('/contents/shop/admin/selectwindow/selectwindow.js');

        $isBox = Engine::Get()->getConfigFieldSecure('project-box');

        $acl = array();
        try {
            $user = $this->getUser();
            $this->setValue('user', $user->makeInfoArray());
            $this->setValue('avatar', $this->getUser()->makeImageGravatar());

            // передаем все ACL user'a
            $acl = Shop::Get()->getUserService()->getUserACLArray(
            $this->getUser()
            );
            $this->setValue('acl', $acl);
        } catch (Exception $e) {

        }

        // добавить пункты меню раздела "Настройки"
        $this->_makeSettingMenu($acl);

        // добавить пункты меню раздела "Отчеты"
        $this->_makeReportMenu($acl);

        $this->setValue('menuTopArray', Shop_ModuleLoader::Get()->getTopMenuArray());
        $this->setValue('menuReportArray', Shop_ModuleLoader::Get()->getReportMenuArray());
        $this->setValue('menuSettingArray', Shop_ModuleLoader::Get()->getSettingMenuArray());

        try {
            $this->setValue('branding', Engine::Get()->getConfigField('project-branding'));
        } catch (Exception $brandEx) {

        }

        // переопределение меню
        try {
            $this->setValue('menuArray', Engine::Get()->getConfigField('project-menu'));
        } catch (Exception $e) {

        }

        // включить box-пункты или нет
        $this->setValue('box', $isBox);

        $this->setValue('favicon', Shop::Get()->getSettingsService()->getSettingValue('favicon'));
        $this->setValue('title', Engine::GetHTMLHead()->getTitle());
        $this->setValue('year', date('Y'));
        $this->setValue('engine_includes', Engine::GetHTMLHead()->render());

        // отступы для right sidebar
        $contentID = Engine::Get()->getRequest()->getContentID();
        $contentArray = array();
        $contentArray[] = 'shop-admin-orders';
        $contentArray[] = 'shop-admin-manage';
        $contentArray[] = 'shop-admin-orders-report-servicebusy';
        $contentArray[] = 'shop-admin-products-in-list';
        $contentArray[] = 'shop-admin-products';
        $contentArray[] = 'shop-admin-products-inlist';
        $contentArray[] = 'shop-admin-users';
        $contentArray[] = 'shop-admin-users-mass-mailing';
        $contentArray[] = 'issue-view';
        $contentArray[] = 'issue-index';
        $contentArray[] = 'project-index';

        if (in_array($contentID, $contentArray)) {
            $this->setValue('sidebarPlace', true);
        }

        if ($isBox) {
            $this->setValue('isProjectBox', true);
            if (Engine::Get()->getConfigFieldSecure('oneclick-enable')) {
                $this->setValue('showOrders', true);
            }
        } else {
            $this->setValue('showOrders', true);
        }

        // issue #49459 - full history in admin
        try {
            $history = new XShopHistory();
            $history->setUserid($this->getUser()->getId());
            $history->setCdate(date('Y-m-d H:i:s'));
            $history->setUrl(Engine::GetURLParser()->getTotalURL());

            $post = '';
            $a = Engine::GetURLParser()->getArguments();
            foreach ($a as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $v) {
                        $post .= $key.'='.$v."\n";
                    }
                } else {
                    $post .= $key.'='.$value."\n";
                }
            }

            $history->setPost($post);
            $history->insert();
        } catch (Exception $historyEx) {

        }

        if ($isBox) {
            // список категорий (workflow)
            $category = Shop::Get()->getShopService()->getWorkflowsActive($this->getUser());
            $a = array();
            while ($x = $category->getNext()) {
                $a[] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(),
                'url' => Engine::GetLinkMaker()->makeURLByContentIDParam('issue-add', $x->getId(), 'workflowid'),
                );
            }
            $this->setValue('workflowArray', $a);

            $this->setValue('commentTemplateArray', Shop::Get()->getShopService()->getCommentTemplatesArray());

        }

        // менеджеры
        $user = $this->getUser();
        $managers = Shop::Get()->getUserService()->getUsersManagers($this->getUser());
        $a = array();
        $currentUserId = $user->getId();
        while ($x = $managers->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(),
            'selected' => $currentUserId == $x->getId(),
            );
        }
        $this->setValue('managerArray', $a);

        // список всех сотрудников для подсказок в textcomplete
        $a = array();
        $managers = Shop::Get()->getUserService()->getUsersManagers();
        while ($x = $managers->getNext()) {
            $name = $x->makeName(false, 'fl');
            if ($name) {
                $a[] = $name.' #'.$x->getId();
            }
        }
        $this->setValue('mentionsJSON', json_encode($a));

        // включение AMI
        $allowAMI = Engine::Get()->getConfigFieldSecure('project-box-call-window') && Engine::Get()->getConfigFieldSecure('asterisk-ami');
        $this->setValue('allowAMI', $allowAMI);
    }

    /**
     * Добавить пункты меню раздела "Настройки"
     *
     */
    private function _makeSettingMenu($acl) {
        $isBox = Engine::Get()->getConfigFieldSecure('project-box');

        Shop_ModuleLoader::Get()->registerSettingMenuItem(
        Shop::Get()->getTranslateService()->getTranslate('translate_shop_settings'),
        '/admin/shop/settings/'
        );

        if (isset($acl['block'])) {
            Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslate('translate_blocks_control'),
            '/admin/shop/block/'
            );
        }

        if (isset($acl['faq'])) {
            Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslate('translate_faq'),
            '/admin/shop/faq/'
            );
        }

        if (isset($acl['settings'])) {
            Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslate('translate_currency'),
            '/admin/shop/currency/'
            );
        }

        if (isset($acl['box'])) {
            Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslate('translate_boxes'),
            '/admin/shop/box/'
            );
        }

        if (isset($acl['feedback'])) {
            Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslate('translate_feedback'),
            '/admin/shop/feedback/'
            );
        }

        if (isset($acl['guestbook'])) {
            Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslate('translate_reviews_of_the_store'),
            '/admin/shop/guestbook/'
            );
        }

        if (isset($acl['payment'])) {
            Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslate('translate_payment'),
            '/admin/shop/payment/'
            );
        }

        if (isset($acl['settings'])) {
            Shop_ModuleLoader::Get()->registerSettingMenuItem(
            'Бизнес-процессы',
            '/admin/shop/workflow/'
            );

            if ($isBox) {
                Shop_ModuleLoader::Get()->registerSettingMenuItem(
                'Источники заказов и клиентов',
                '/admin/shop/source/'
                );
                Shop_ModuleLoader::Get()->registerSettingMenuItem(
                'Ограничения событий',
                '/admin/ignore/'
                );
            }
        }

        if (isset($acl['discount'])) {
            Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslate('translate_discounts'),
            '/admin/shop/discount/'
            );
        }

        if (isset($acl['redirect'])) {
            Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslate('translate_URL_and_redirects'),
            '/admin/shop/redirect/'
            );
        }

        if (isset($acl['seo'])) {
            Shop_ModuleLoader::Get()->registerSettingMenuItem(
            'SEO',
            '/admin/shop/seo/'
            );
        }

        if (isset($acl['role'])) {
            Shop_ModuleLoader::Get()->registerSettingMenuItem(
            'Дерево ролей',
            '/admin/role/'
            );
        }

        if (isset($acl['users_groups'])) {
            Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslate('translate_users_groups'),
            '/admin/shop/usergroups/'
            );
        }

        if (isset($acl['settings'])) {
            Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslate('translate_textpages'),
            '/admin/shop/textpages/'
            );
        }
    }

    private function _makeReportMenu($acl) {
        if (isset($acl['report-summary'])) {
            Shop_ModuleLoader::Get()->registerReportMenuItem(
            'Сводный отчет',
            '/admin/shop/report/summary/'
            );
        }

        if (isset($acl['report-topproducts'])) {
            Shop_ModuleLoader::Get()->registerReportMenuItem(
            'Самые заказываемые товары',
            '/admin/shop/report/topproducts/'
            );
        }

        if (isset($acl['report-productmatrix'])) {
            Shop_ModuleLoader::Get()->registerReportMenuItem(
            Shop::Get()->getTranslateService()->getTranslate('translate_matrix_products_customers'),
            '/admin/shop/orders/report/'
            );
        }

        if (isset($acl['activity'])) {
            Shop_ModuleLoader::Get()->registerReportMenuItem(
            Shop::Get()->getTranslateService()->getTranslate('translate_activity'),
            '/admin/shop/activity/'
            );
        }

        if (isset($acl['statistic'])) {
            Shop_ModuleLoader::Get()->registerReportMenuItem(
            Shop::Get()->getTranslateService()->getTranslate('translate_statistics_search'),
            '/admin/shop/statistics/search/'
            );
        }

        if (isset($acl['users-online'])) {
            Shop_ModuleLoader::Get()->registerReportMenuItem(
            Shop::Get()->getTranslateService()->getTranslate('translate_users_online'),
            '/admin/shop/online/'
            );
        }
    }

}