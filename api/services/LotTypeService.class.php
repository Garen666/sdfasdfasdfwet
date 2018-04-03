<?php
class LotTypeService extends ServiceUtils_AbstractService {

    /**
     * @param int $id
     * @return LotType
     */
    public function getLotTypeByID($id) {
        return $this->getObjectByID($id, 'LotType');
    }

    /**
     * Найти lotType по URL-префиксу
     *
     * @param string $url
     * @return LotType
     */
    public function getLotTypeByURL($url) {
        $url = trim($url);
        if (!$url) {
            throw new ServiceUtils_Exception('Empty url');
        }

        return $this->getObjectByField('url', $url, 'LotType', false);
    }

    /**
     * @return LotType
     */
    public function getAllLotType() {
        $games = new LotType();
        $games->setDeleted(0);
        return $games;
    }

}