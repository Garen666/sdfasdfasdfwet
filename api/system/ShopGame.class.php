<?php

class ShopGame extends XShopGame {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopGame
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return ShopGame
     */
    public static function Get($key) {
        return self::GetObject('ShopGame', $key);
    }

    public function getAllLotType() {
        $lotType = new LotType();
        $lotType->setGameId($this->getId());

        return $lotType;
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
                'shop-game',
                $this->getId()
            );
        }
    }

    public function makeURLFirstLot($friendlyURL = true) {

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

        $lots = $this->getAllLotType();
        $lots = $lots->getNext();

        if ($friendlyURL && $lots && $lots->getUrl()) {
            $url = '/'.$lots->getUrl();
            return $fullurl.$url;
        } else if ($friendlyURL && $this->getUrl()) {
            $url = '/'.$this->getUrl();
            return $fullurl.$url;
        } else {
            return $fullurl.Engine::GetLinkMaker()->makeURLByContentIDParam(
                'shop-game',
                $this->getId()
            );
        }
    }

    public function makeName($hidden = false) {
        $name = $this->getName();

        if ($this->getDescriptionshort()) {
            $name .= " ".$this->getDescriptionshort();
        }

        if ($hidden && $this->getHidden()) {
            $name .= " (Скрытая)";
        }
        return $name;
    }

    public function makeImageThumb($width = 200, $height = false, $method = 'prop') {
        $src = MEDIA_PATH.'/shop/'.$this->getImage();
        if (!file_exists($src) || is_dir($src)) {
            return false;
        }

        // �������� ������
        $format = Shop::Get()->getSettingsService()->getSettingValue('image-format');
        $format = strtolower($format);
        if ($format != 'png' && $format != 'jpg') {
            $format = 'jpg';
        }

        // ������ ������ 100px ������ �� �����
        if ($width <= 100) {
            $width = 100;
        }

        // �������� ������ ����������� � ��������� 100px (� ������� �������)
        //$width = round(ceil($width / 100) * 100);

        return ImageProcessor_Thumber::makeThumbUniversal($src, $width, $height, $method, PROJECT_PATH, $format);
    }

    public function makeURLEdit() {
        return Engine::GetLinkMaker()->makeURLByContentIDParam(
            'shop-admin-games-control',
            $this->getId()
        );
    }

}