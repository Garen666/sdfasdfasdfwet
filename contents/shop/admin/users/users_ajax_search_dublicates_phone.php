<?php

class users_ajax_search_dublicates_phone extends Engine_Class {

    public function process() {
        try {
            $phone = $this->getArgumentSecure('phone');
            $phones = str_replace(",", "\n", $phone);
            $phoneArray = explode("\n", $phones);

            $dublicates = array();
            $merge = array();
            foreach ($phoneArray as $value) {
                if (strlen($value) < 4)
                    continue;
                $merge = Shop::Get()->getShopService()->searchDublicatesByPhone($value);
                $dublicates = array_merge($dublicates, $merge);
            }
            echo json_encode($dublicates);
            exit;
        } catch (Exception $e) {
            
        }
    }

}
