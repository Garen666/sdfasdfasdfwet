<?php
class ticket_index extends Engine_Class {

    public function process() {
        if ($this->getArgumentSecure('ok')) {
            try {
                Shop::Get()->getShopService()->sendTicketSupport(
                $this->getControlValue('name'),
                $this->getControlValue('email'),
                $this->getControlValue('message')
                );

                $this->setValue('message', 'ok');
            } catch (ServiceUtils_Exception $e) {
                $this->setValue('message', 'error');
                $this->setValue('errorsArray', $e->getErrorsArray());
            }
        }
        try {
            $user = $this->getUser();

            if ($email = $user->getEmail()) {
                $this->setControlValue('email', $email);
            } else {
                $this->setControlValue('email', Shop::Get()->getSettingsService()->getSettingValue('header-email'));
            }

        } catch (Exception $e) {

        }


    }

}