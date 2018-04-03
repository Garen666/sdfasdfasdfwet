<?php

class users_permissions extends Engine_Class
{

    public function process()
    {
        try {
            $user = Shop::Get()->getUserService()->getUserByID(
                $this->getArgument('id')
            );

            Engine::GetHTMLHead()->setTitle($user->makeName());

            if ($this->getControlValue('ok')) {
                try {
                    Shop::Get()->getUserService()->updateUserAuth(
                        $user,
                        $this->getControlValue('userlogin'),
                        $this->getControlValue('userpassword')
                    );

                    Shop::Get()->getUserService()->updateUserACL(
                        $user,
                        $this->getControlValue('level'),
                        $this->getControlValue('acl'),
                        $this->getControlValue('edate')
                    );

                    $this->setValue('message', 'ok');
                } catch (ServiceUtils_Exception $e) {

                    if (PackageLoader::Get()->getMode('debug')) {
                        print $e;
                    }

                    $this->setValue('message', 'error');
                    $this->setValue('errorsArray', $e->getErrorsArray());
                }
            }

            $acl = Shop::Get()->getUserService()->getACLPermissions();
            $a = array();
            foreach ($acl as $x) {
                try {
                    $key = $x['key'];

                    $selected = $user->isAllowed($key);

                    $tmp = explode('::', $x['name']);
                    $tmpIndex = 0;
                    $pathArray = array();
                    foreach ($tmp as $xtmp) {
                        $xtmp = trim($xtmp);
                        if (!$xtmp) {
                            continue;
                        }
                        $tmpIndex++;
                        $pathArray[] = $xtmp;

                        $path = implode('/', $pathArray);

                        // это последний элемент?
                        $isLeaf = count($tmp) == $tmpIndex;

                        if (!isset($a[$path])) {
                            $a[$path] = array(
                                'name' => $xtmp,
                                'level' => $tmpIndex - 1,
                                'key' => $isLeaf ? $key : false,
                                'selected' => $isLeaf ? $selected : false,
                            );
                        }
                    }
                } catch (Exception $e) {

                }
            }

            if ($this->getControlValue('generatepassword')) {
                Shop::Get()->getUserService()->generateUserPassword($user);
            }
            $this->setValue('aclArray', $a);

            $this->setControlValue('userlogin', $user->getLogin());
            $this->setControlValue('edate', $user->getEdate());
            $this->setControlValue('level', $user->getLevel());

            $menu = Engine::GetContentDriver()->getContent('shop-admin-users-menu');
            $menu->setValue('selected', 'permissions');
            $menu->setValue('userid', $user->getId());
            $this->setValue('menu', $menu->render());

            // список менеджеров для копирования прав
            $users = Shop::Get()->getUserService()->getUsersManagers();
            $a = array();
            while ($x = $users->getNext()) {
                $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->makeName(),
                );
            }
            $this->setValue('userArray', $a);

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}