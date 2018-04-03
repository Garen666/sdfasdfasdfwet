<?php
class shop_index extends Engine_Class {

    public function process() {
        // SEO текст на главную
        try {
            $this->setValue(
            'seotextinindexpage',
            Shop::Get()->getSettingsService()->getSettingValue('seo-text-in-index-page')
            );
        } catch (Exception $e) {

        }


        $games = Shop::Get()->getGameService()->getAllPublicGames();

        $gamesArray = array();
        while ($x = $games->getNext()) {
            $gamesArray[] = array(
                'id' => $x->getId(),
                'name' => $x->getName(),
                'descriptionshort' => $x->getDescriptionshort(),
                'url' => $x->makeURLFirstLot()
            );
        }

        $this->setValue("gamesArray", $gamesArray);

        $gamesTypeArray = array();

        $gamesType = new LotType();
        $gamesType->setDeleted(0);
        $gamesType->setHidden(0);
        while ($x = $gamesType->getNext()) {
            $gamesTypeArray[$x->getGameId()][] = array(
                'name' => $x->getName(),
                'url' => $x->makeURL()
            );
        }

        $this->setValue("gamesTypeArray", $gamesTypeArray);

    }



}