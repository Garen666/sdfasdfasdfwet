<?php
class users_menu extends Engine_Class {

    public function process() {
        $contact = Shop::Get()->getUserService()->getUserByID(
        $this->getValue('userid')
        );

        $this->setValue('urlEdit', $contact->makeURLEdit());

        $this->setValue('urlDelete', './delete/');

        $this->setValue('id', $contact->getId());
        $this->setValue('image', $contact->makeImageThumb());
        if ($contact->getImage()) {
            $this->setValue('bigImage', '/media/shop/'.$contact->getImage());
        }

        $description = '';
        if ($contact->getTypesex() == 'company') {
            $this->setValue('name', $contact->getCompany(), true);
            $description .= $contact->getPost();
        } else {
            $this->setValue('name', $contact->makeName(true, 'lfm'));
            $description .= $contact->getCompany();
            if ($description && $contact->getPost()) {
                $description .= ', '.$contact->getPost();
            }
        }
        if ($description) {
            $description .= "\n";
        }
        $description .= $contact->getCommentadmin();
        $this->setValue('description', nl2br(htmlspecialchars($description)));


        if (Engine::Get()->getConfigFieldSecure('project-box')) {
            $this->setValue('box', true);

            $this->setValue('urlEvent', $contact->makeURLEvent());

            $urlGraphics = Engine::GetLinkMaker()->makeURLByContentIDParam('shop-admin-users-graphics', $contact->getId(), 'id');
            $this->setValue('urlGraphics', $urlGraphics);

            $urlIssue = Engine::GetLinkMaker()->makeURLByContentIDParam('shop-admin-users-issue', $contact->getId(), 'id');
            $this->setValue('urlIssue', $urlIssue);
        }

        if ($this->getUser()->getLevel() >= 3) {
            $urlpermissions = Engine::GetLinkMaker()->makeURLByContentIDParam('shop-admin-users-permissions', $contact->getId(), 'id');
            $this->setValue('urlPermissions', $urlpermissions);
        }

        // дополнительные табы от модулей
        $moduleTabArray = Shop_ModuleLoader::Get()->getUserTabArray();
        foreach ($moduleTabArray as $k => $moduleTabInfo) {
            $moduleTabArray[$k]['url'] = Engine::GetLinkMaker()->makeURLByContentIDParam($moduleTabInfo['contentID'], $contact->getId());
        }
        $this->setValue('moduleTabArray', $moduleTabArray);
    }

}