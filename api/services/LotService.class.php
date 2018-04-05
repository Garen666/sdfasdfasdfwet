<?php
class LotService extends ServiceUtils_AbstractService {

    /**
     * @param int $id
     * @return Lot
     */
    public function getLotByID($id) {
        return $this->getObjectByID($id, 'Lot');
    }

    public function getMinSum($userId, $lotTypeId) {
        $lotTypeMinSum = new XLotTypeMinSum();
        $lotTypeMinSum->setUserId($userId);
        $lotTypeMinSum->setLotTypeId($lotTypeId);

        if ($lotTypeMinSum->select()) {
            return $lotTypeMinSum->getSum();
        } else {
            return 0;
        }
    }

    public function updateMinSum($userId, $lotTypeId, $sum) {
        $lotTypeMinSum = new XLotTypeMinSum();
        $lotTypeMinSum->setUserId($userId);
        $lotTypeMinSum->setLotTypeId($lotTypeId);
        if (!$lotTypeMinSum->select()) {
            $lotTypeMinSum->setSum($sum);
            $lotTypeMinSum->insert();
        } else {
            $lotTypeMinSum->setSum($sum);
            $lotTypeMinSum->update();
        }
    }

    public function getLots3($userId, $gameId, $lotTypeId) {
        $lot = new Lot();

        $lot->setUserId($userId);
        $lot->setGameId($gameId);
        $lot->setLotTypeId($lotTypeId);

        return $lot;
    }

    public function addLot(
        $userId, $gameId, $lotTypeId, $active, $price, $count,
        $filterId1, $filterValue1,
        $filterId2, $filterValue2,
        $filterId3, $filterValue3,
        $filterId4, $filterValue4,
        $filterId5, $filterValue5
    ) {
        $lot = new Lot();
        $lot->setUserId($userId);
        $lot->setGameId($gameId);
        $lot->setLotTypeId($lotTypeId);

        $lot->setFilterId1($filterId1);
        $lot->setFilterValue1($filterValue1);
        $lot->setFilterId2($filterId2);
        $lot->setFilterValue2($filterValue2);
        $lot->setFilterId3($filterId3);
        $lot->setFilterValue3($filterValue3);
        $lot->setFilterId4($filterId4);
        $lot->setFilterValue4($filterValue4);
        $lot->setFilterId5($filterId5);
        $lot->setFilterValue5($filterValue5);

        if ($lot->select()) {
            if (!$active && !$price && !$count) {
                $lot->delete();
            } else {
                $lot->setActive($active);
                $lot->setPrice($price);
                $lot->setCount($count);
                $lot->update();
            }

        } else {
            if ($active || $price || $count) {
                $lot->setActive($active);
                $lot->setPrice($price);
                $lot->setCount($count);
                $lot->insert();
            }
        }

    }

}