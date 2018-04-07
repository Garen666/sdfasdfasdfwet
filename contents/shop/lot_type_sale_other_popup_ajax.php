<?php
class lot_type_sale_other_popup_ajax extends Engine_Class {

    public function process() {
        $lotType = Shop::Get()->getLotTypeService()->getLotTypeByID($this->getArgumentSecure('id'));
        $game = $lotType->getGame();

        if ($this->getArgumentSecure('lotId')) {
            $lot = Shop::Get()->getLotService()->getLotByID($this->getArgumentSecure('lotId'));

            $this->setValue('lotId', $lot->getId());
            $this->setValue('descriptionShort', $lot->getDescriptionShort());
            $this->setValue('description', $lot->getDescription());
            $this->setValue('price', $lot->getPrice());
            $this->setValue('count', $lot->getCount());
            $this->setValue('active', $lot->getActive());

            $lotFilterSelected = array();

            for ($i = 1; $i<=5; $i++) {
                $filterId = $lot->getField('filterId'.$i);
                $filterValue = $lot->getField('filterValue'.$i);

                if ($filterId && $filterValue) {
                    $lotFilterSelected[$filterId] = $filterValue;
                }
            }

            $this->setValue('lotFilterSelected', $lotFilterSelected);
        }

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