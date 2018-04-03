<?php
class shop_login extends Engine_Class {

    public function process() {
        if ($this->getArgumentSecure('auth_login') && $this->getArgumentSecure('auth_password')) {
            try {
                $user = Shop::Get()->getUserService()->login(
                    $this->getArgumentSecure('auth_login'),
                    $this->getArgumentSecure('auth_password'),
                    true // cookie
                );

                header('Location: /');
                exit();

            } catch (Exception $e) {
            }
        }
    }

}