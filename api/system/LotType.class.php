<?php

class LotType extends XLotType {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return LotType
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return LotType
     */
    public static function Get($key) {
        return self::GetObject('LotType', $key);
    }

    public function getGame() {
        return Shop::Get()->getGameService()->getGameByID(
            $this->getGameId()
        );
    }


    public function buildUrl() {
        $game = Shop::Get()->getGameService()->getGameByID($this->getGameId());

        return Shop::Get()->getShopService()->buildURL($game->makeName()). "/".Shop::Get()->getShopService()->buildURL($this->getName());
    }

    /**
     * @return string
     */
    public function makeURL($friendlyURL = true) {
        $fullurl = '';
        if ($friendlyURL) {
            if (@isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
                $h = 'https://';
            } else {
                $h = 'http://';
            }
            if (Engine::Get()->getProjectHost()) {
                $fullurl = $h.Engine::Get()->getProjectHost();
            }
        }
        if ($friendlyURL && $this->getUrl()) {
            $url = '/'.$this->getUrl();
            return $fullurl.$url;
        } else {
            return $fullurl.Engine::GetLinkMaker()->makeURLByContentIDParam(
                'shop-lot-type',
                $this->getId()
            );
        }
    }


}