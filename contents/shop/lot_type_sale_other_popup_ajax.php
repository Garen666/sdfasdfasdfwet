<?php
class lot_type_sale_other_popup_ajax extends Engine_Class {

    public function process() {
        $lotType = Shop::Get()->getLotTypeService()->getLotTypeByID($this->getArgumentSecure('id'));
        $game = $lotType->getGame();

        $gameFilter = $lotType->getAllFilterName();
        $gameFilterNameArray = array();
        while ($x = $gameFilter->getNext()) {
            $gameFilterNameArray[] = array(
                'id' => $x->getId(),
                'name' => $x->getName(),
                'additionally' => $x->getAdditionally()
            );
        }

        $gameFilterValue = $game->getAllFilterValue();
        $gameFilterValueArray = array();

        while ($x = $gameFilterValue->getNext()) {
            $gameFilterValueArray[$x->getGameFilterId()][] = array(
                'id' => $x->getId(),
                'value' => $x->getValue()
            );
        }

        $this->setValue('gameFilterNameArray', $gameFilterNameArray);
        $this->setValue('gameFilterValueArray', $gameFilterValueArray);
    }

}