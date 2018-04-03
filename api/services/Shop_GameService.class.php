<?php
class Shop_GameService extends ServiceUtils_AbstractService {

    /**
     * @param int $id
     * @return ShopGame
     */
    public function getGameByID($id) {
        return $this->getObjectByID($id, 'ShopGame');
    }





    /**
     * Найти категорию по URL-префиксу
     *
     * @param string $url
     * @return ShopGame
     */
    public function getGameByURL($url) {
        $url = trim($url);
        if (!$url) {
            throw new ServiceUtils_Exception('Empty url');
        }

        return $this->getObjectByField('url', $url, 'ShopGame', false);
    }

    /**
     * @return ShopGame
     */
    public function getAllGames() {
        $games = new ShopGame();
        $games->setDeleted(0);
        return $games;
    }

    /**
     * @return ShopGame
     */
    public function getAllPublicGames() {
        $games = new ShopGame();
        $games->setHidden(0);
        $games->setDeleted(0);
        return $games;
    }




    /**
     * @param $name
     * @param $description
     * @param $image
     * @param $hidden
     * @param $seodescription
     * @param $seotitle
     * @param $seoh1
     * @param $seocontent
     * @param $seokeywords
     * @param $linkkey
     * @return ShopGame
     */
    public function addGame($name) {
        try {
            SQLObject::TransactionStart();

            // �������� ����-�������
            $name = str_replace(array("\n", "\r", "\t"), ' ', $name);
            // ������� ��������� ��������
            $name = preg_replace('/(\s+)/ius', ' ', $name);
            $name = trim($name);
            if (!$name) {
                throw new ServiceUtils_Exception('name');
            }

            $url = Shop::Get()->getShopService()->buildURL($name);


            $game = new ShopGame();
            $game->setName($name);
            $game->setHidden(1);
            $game->setUrl($url);
            $game->insert();

            /*$event = Events::Get()->generateEvent('shopProductAddAfter');
            $event->setProduct($product);
            $event->notify();*/

            SQLObject::TransactionCommit();

            return $game;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }


    /**
     * @param ShopGame $game
     * @param $name
     * @param $description
     * @param $image
     * @param $hidden
     * @param $seodescription
     * @param $seotitle
     * @param $seoh1
     * @param $seocontent
     * @param $seokeywords
     * @param $linkkey
     * @param $deleteImage
     * @throws Exception
     * @throws SQLObject_Exception
     */
    public function updateGame(
        ShopGame $game, $name, $description, $image, $hidden, $seodescription, $seotitle, $seoh1,
        $seocontent, $seokeywords, $deleteImage
    ) {
        try {
            SQLObject::TransactionStart();

            /*$event = Events::Get()->generateEvent('shopProductEditBefore');
            $event->setProduct($product);
            $event->notify();*/

            $name = trim($name);
            $description = trim($description);
            $seocontent = trim($seocontent);

            $ex = new ServiceUtils_Exception();
            if (!$name) {
                $ex->addError('name');
            }

            if ($ex->getCount()) {
                throw $ex;
            }

            $url = Shop::Get()->getShopService()->buildURL($name);
            $game->setUrl($url);
            $game->setHidden($hidden);
            $game->setName($name);
            $game->setDescription($description);
            $game->setHidden($hidden);
            $game->setSeodescription($seodescription);
            $game->setSeotitle($seotitle);
            $game->setSeoh1($seoh1);
            $game->setSeocontent($seocontent);
            $game->setSeokeywords($seokeywords);
            //$game->setLinkkey($linkkey);

            if ($deleteImage) {
                $game->setImage('');
            } elseif ($image) {
                // ����������� ����������� � ����������� ������
                // � ���������� ������
                $image = Shop::Get()->getShopService()->convertImage($image);

                $file = Shop::Get()->getShopService()->makeImagesUploadUrl(
                    $image,
                    '/shop/',
                    false,
                    'product-'.$name
                );
                copy($image, MEDIA_PATH.'shop/'.$file);
                $game->setImage($file);
            }


            $game->update();

            /*$event = Events::Get()->generateEvent('shopProductEditAfter');
            $event->setProduct($product);
            $event->notify();*/

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }
}