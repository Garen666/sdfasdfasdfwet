<?php
/**
 * WebProduction Shop (wpshop)
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

/**
 * Система авторизации wpshop
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Shop_AuthMachine implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $query = Engine::Get()->getRequest();

        $arguments = Engine::GetURLParser()->getArguments();

        if (isset($arguments['auth_logout'])
            || $query->getContentID() == 'logout') {
            try {
                Shop::Get()->getUserService()->logout();
                return false;
            } catch (Exception $e) {

            }
        }

        // проверка прав
        $pageData = Engine::GetContentDataSource()->getDataByID(
            $query->getContentID()
        );

        if ($pageData['level']) {
            try {
                $user = Shop::Get()->getUserService()->getUser();

                if ($user->getLevel() < $pageData['level']) {
                    throw new ServiceUtils_Exception();
                }
//var_dump(PackageLoader::Get()->isImported('CKFinder'));
                // даем юзеру доступ к CKFinder
                if (PackageLoader::Get()->isImported('CKFinder')
                && $user->isAdmin()) {
                    CKFinder_Configuration::Get()->setAuthorized(true);
                }
            } catch (Exception $e) {
                $query->setContentID(403);
                return false;
            }
        }
    }

}