<?php
class shop_game extends Engine_Class {

    public function process() {

        $game = Shop::Get()->getGameService()->getGameByID(
            $this->getArgument('id')
        );

        $lotType = $game->getAllLotType();

        $lotType = $lotType->getNext();

        if ($lotType && $lotType->makeURL()) {
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: '.$lotType->makeURL());
            exit();
        } else {
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: /');
            exit();
        }

    }

}