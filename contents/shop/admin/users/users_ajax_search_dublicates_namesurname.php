<?php
class users_ajax_search_dublicates_namesurname extends Engine_Class {

    public function process() {
        try {

            $name = $this->getArgumentSecure('name');
            $surname = $this->getArgumentSecure('namelast');
            $dublicates = Shop::Get()->getShopService()->searchDublicatesByNameSurname($name,$surname);
            echo json_encode($dublicates);
            exit;
        } catch (Exception $e) {

        }
    }

}