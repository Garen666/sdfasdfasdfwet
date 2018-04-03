<?php
class users_delete extends Engine_Class {

    public function process() {
        try {
            $user = Shop::Get()->getUserService()->getUserByID(
                $this->getArgument('id')
            );

            $currentUser = $this->getUser();

            $this->setValue('userid', $user->getId());

            Engine::GetHTMLHead()->setTitle('Удаление пользователя #'.$user->getId());

            // проверка прав пользователя на управление пользователем
            if (!Shop::Get()->getUserService()->isUserChangeAllowed($user,$currentUser)) {
                throw new ServiceUtils_Exception();
            }

            if ($this->getControlValue('ok')) {
                try {
                    // если это не текущий пользователь
                    if($currentUser->getId() !=  $user->getId()){
                        $user->delete();
                    } else {
                        throw new ServiceUtils_Exception('You can not delete yourself');
                    }

                    // записываем данные об активности пользователя
                    try {
                        CommentsAPI::Get()->addComment(
                            'shop-history-user-del'.$user->getId(),
                            Shop::Get()->getTranslateService()->getTranslate('translate_user_deleted').' #'.$user->getId().' '.$user->makeName(),
                            $currentUser->getId()
                        );
                    } catch (Exception $e) {

                    }

                    $this->setValue('message', 'ok');
                } catch (ServiceUtils_Exception $e) {
                    $this->setValue('message', 'error');
                    $this->setValue('errorsArray', $e->getErrorsArray());
                }
            }

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}