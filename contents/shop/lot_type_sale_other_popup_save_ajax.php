<?php
class lot_type_sale_other_popup_save_ajax extends Engine_Class {

    public function process() {
        try {
            $data = $this->getArgumentSecure('data');


            $argumentsArray = array();
            $filtersValue = array();
            $filtersValue[0] = false;
            $filtersId = array();
            $filtersId[0] = false;

            foreach ($data as $value) {
                $argumentsArray[$value['name']] = $value['value'];

                if (strpos($value['name'], 'filter') === 0) {
                    $filtersValue[] = $value['value'];
                    $filtersId[] = str_replace('filter', '', $value['name']);
                }
            }

            $user = $this->getUser();
            $lotType = Shop::Get()->getLotTypeService()->getLotTypeByID($argumentsArray['lotTypeId']);

            Shop::Get()->getLotService()->addLot(
                $user->getId(),
                $user->makeName(),
                $lotType->getId(),
                $lotType->getGameId(),
                @$argumentsArray['active'],
                @$argumentsArray['price'],
                @$argumentsArray['count'],
                @$argumentsArray['descriptionshort'],
                @$argumentsArray['description'],
                @$filtersId[1],
                @$filtersValue[1],
                @$filtersId[2],
                @$filtersValue[2],
                @$filtersId[3],
                @$filtersValue[3],
                @$filtersId[4],
                @$filtersValue[4],
                @$filtersId[5],
                @$filtersValue[5]
            );
        } catch (Exception $exception) {
            throw new Exception('fail');
        }

    }

}