<?php

class users_ajax_search_dublicates_email extends Engine_Class {

    public function process() {
        try {
            $email = $this->getArgumentSecure('email');
            $emails = str_replace(",", "\n", $email);
            $emailArray = explode("\n", $emails);

            $dublicates = array();
            $merge = array();
            foreach ($emailArray as $value) {
                if (strlen($value) < 5)
                    continue;
                $merge = Shop::Get()->getShopService()->searchDublicatesByEmail($value);
                $dublicates = array_merge($dublicates, $merge);
            }
            echo json_encode($dublicates);
            exit;
        } catch (Exception $e) {
            
        }
    }

}
