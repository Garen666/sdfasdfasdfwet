<?php
class users_add extends Engine_Class {

    public function process() {
        if ($this->getControlValue('ok') || $this->getControlValue('okClear')) {
            try {
                SQLObject::TransactionStart();

                $name =  trim($this->getControlValue('name'));
                $namelast = trim($this->getControlValue('namelast'));
                $company =  trim($this->getControlValue('company'));

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

                $skype =  trim($this->getControlValue('skype'));
                $jabber =  trim($this->getControlValue('jabber'));
                $whatsapp = trim($this->getControlValue('whatsapp'));
                $typesex = trim($this->getControlValue('typesex'));

                $isCompany = ($typesex == 'company');

                $ex = new ServiceUtils_Exception();

                if (empty($name) && empty($company) && empty($namelast)) {
                    $ex->addError('noname');
                }

                if (empty($phone) && empty($email) && empty($skype) && empty($jabber) && empty($whatsapp) && !$isCompany) {
                    $ex->addError('nocontact');
                }

                if ($ex->getCount()) {
                    throw $ex;
                }

                $user = Shop::Get()->getUserService()->addUserClient(
                $name,
                false,
                false,
                $email,
                $phone,
                trim($this->getControlValue('address')),
                trim($this->getControlValue('company')),
                trim($this->getControlValue('time')),
                trim($this->getControlValue('commentadmin')),
                false,
                $namelast,
                trim($this->getControlValue('namemiddle')),
                trim($this->getControlValue('post')),
                $typesex
                );

                // дописываем остальные не добавленные поля.
                Shop::Get()->getUserService()->updateUserProfile(
                $user,
                $email,
                false,
                trim($this->getControlValue('name')),
                $phone,
                trim($this->getControlValue('address')),
                trim($this->getControlValue('bdate')),
                $phones,
                $emails,
                trim($this->getControlValue('urls')),
                trim($this->getControlValue('time')),
                trim($this->getControlValue('parentid')),
                false, // не выполнять проверки
                $this->getControlValue('commentadmin'),
                $this->getControlValue('managerid'),
                $this->getControlValue('groupid'),
                $this->getControlValue('login'),
                $company,
                $this->getControlValue('pricelevel'),
                $this->getArgumentSecure('distribution'),
                $this->getControlValue('tags'),
                date("y-m-d H:i:s"),
                $this->getControlValue('namelast'),
                $this->getControlValue('namemiddle'),
                $this->getControlValue('post'),
                $this->getControlValue('typesex'),
                $skype,
                $jabber,
                $whatsapp,
                $this->getArgumentSecure('employer'),
                $this->getArgumentSecure('allowreferal')
                );

                $image = $this->getControlValue('avatarimage');
                $image = @$image['tmp_name'];

                if ($image) {
                    Shop::Get()->getShopService()->updateUserAvatarImage($user, $image);
                    $user->update();
                }

                $callComment = $this->getArgumentSecure('callcomment');
                $callFrom = $this->getArgumentSecure('callfrom');
                $callTo = $this->getArgumentSecure('callto');
                $callDate = $this->getArgumentSecure('calldate');

                if ($callComment && $callFrom && $callTo && $callDate) {
                    EventService::Get()->addCallComment(
                    $callFrom,
                    $callTo,
                    $callDate,
                    $callComment,
                    $this->getControlValue('projectid'),
                    $this->getControlValue('workflowid')
                    );
                }

                SQLObject::TransactionCommit();

                $this->setValue('message', 'ok');

                if ($this->getControlValue('ok')){
                    $this->setValue('urlredirect', $user->makeURLEdit());
                }

            } catch (ServiceUtils_Exception $addEx) {
                SQLObject::TransactionRollback();

                if (PackageLoader::Get()->getMode('debug')) {
                    print $addEx;
                }

                $this->setValue('message', 'error');
                $this->setValue('errorsArray', $addEx->getErrorsArray());
            }

        }


        $managers = Shop::Get()->getUserService()->getUsersManagers();
        $a = array();
        while ($x = $managers->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(),
            );
        }
        $this->setValue('managerArray', $a);
        // устанавливаем менеджером текущего пользователя
        $this->setControlValue('managerid',Shop::Get()->getUserService()->getUser()->getId());

        if (Engine::Get()->getConfigFieldSecure('project-box')) {
            $this->setValue('box', true);
            // источники
            $sources = Shop::Get()->getShopService()->getSourceAll();
            $this->setValue('sourceArray', $sources->toArray());
        }

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
    }

}