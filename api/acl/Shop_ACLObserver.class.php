<?php
/**
 * WebProduction Shop (wpshop)
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Shop_ACLObserver implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $contentObject = $event->getContent();
        $role = $contentObject->getContentData();
        $rolesArray = @$role['role'];
        if ($rolesArray) {
            $user = Shop::Get()->getUserService()->getUser();
            foreach ($rolesArray as $resource) {
                if ($user->isDenied($resource)) {
                    // вычисляем путь к шаблону
                    $templateName = Engine::Get()->getConfigFieldSecure('shop-template');
                    $templatePath = PackageLoader::Get()->getProjectPath().'/templates/'.$templateName.'/';

                    $contentObject->setField('filehtml', $templatePath.'error_deny.html');
                    $contentObject->setField('filephp', false);
                    return;
                }
            }
        }
    }

}