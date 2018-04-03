<?php
class users_ajax_search_dublicates_name extends Engine_Class {

    public function process() {
        try {
            $name = $this->getArgumentSecure('name');
            $dublicates = array();
            $dublicates = Shop::Get()->getShopService()->searchDublicatesByName($name);
            echo json_encode($dublicates);
            exit;
        } catch (Exception $e) {

        }

    }

}