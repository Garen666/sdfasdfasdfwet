<?php

class auth_registration extends Engine_Class
{

    public function process() {
        if ($this->isUserAuthorized()) {
            header('Location: /');
        }
        if ($this->getControlValue('ok')) {
            try {
                if ($this->getControlValue('ajs') != 'ready') {
                    throw new ServiceUtils_Exception('bot');
                }

                $bdateYear = $this->getArgumentSecure('bdate_year');
                $bdateMonth = $this->getArgumentSecure('bdate_month');
                $bdateDay = $this->getArgumentSecure('bdate_day');
                if (!$bdateYear) {
                    $bdateYear = 0000;
                }
                if (!$bdateMonth) {
                    $bdateMonth = 00;
                }
                if (!$bdateDay) {
                    $bdateDay = 00;
                }
                $bdate = $bdateYear . '-' . $bdateMonth . '-' . $bdateDay;

                $user = Shop::Get()->getUserService()->addUser(
                    $this->getControlValue('login'),
                    $this->getControlValue('password'),
                    $this->getControlValue('email'),
                    $this->getControlValue('name'),
                    $this->getControlValue('phone'),
                    $this->getControlValue('address'),
                    $bdate,
                    '',
                    '',
                    '',
                    '',
                    '',
                    $this->getArgumentSecure('zakon'), // distribution
                    false,
                    $this->getControlValue('namelast'),
                    $this->getControlValue('namemiddle')
                );

                if (Shop::Get()->getSettingsService()->getSettingValue('user-account-activate')) {
                    $this->setValue('message', 'activate');
                } else {

                    $login = $user->getLogin();
                    if (!$login) {
                    	$login = $user->getEmail();
                    }

                    Shop::Get()->getUserService()->login(
                    $login,
                    $this->getControlValue('password')
                    );
                    $this->setValue('message', 'ok');
                }

                $this->setValue('registration_good_message', Shop::Get()->getSettingsService()->getSettingValue('registration-good-message'));
            } catch (ServiceUtils_Exception $e) {
                $this->setValue('message', 'error');
                $this->setValue('errorsArray', $e->getErrorsArray());
            }
        }

        $this->setValue('used_user_info', Shop::Get()->getSettingsService()->getSettingValue('used-user-info'));
    }

}