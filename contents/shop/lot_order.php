<?php
class lot_order extends Engine_Class {

    public function process() {
        try {
            $lot = Shop::Get()->getLotService()->getLotByID($this->getArgument('id'));
            $game = $lot->getGame();
            $lotType = $lot->getLotType();

            $filterLots = $lot->getFiltersArray();
            $filtersArray = array();
            foreach ($filterLots as $filterId => $filterValue) {
                $filter = Shop::Get()->getFilterService()->getFilterByID($filterId);

                $filtersArray[$filter->getId()] = array(
                    'id' => $filter->getId(),
                    'name' => $filter->getName(),
                    'value' => $filterValue
                );
            }

            $this->setValue('filtersArray', $filtersArray);

            $this->setValue('lotUserName', $lot->getUserName());
            $this->setValue('lotCount', $lot->getCount());
            $this->setValue('gameName', $game->getName());
            $this->setValue('lotTypeName', $lotType->getName());

            $paymentsArray = array();
            $payments = Shop::Get()->getPaymentService()->getAllPaymentsList();

            while ($x = $payments->getNext()) {
                $paymentsArray[] = array(
                    'id' => $x->getId(),
                    'name' => $x->getName()
                );
            }

            $this->setValue('paymentsArray', $paymentsArray);
        } catch (Exception $exception) {

        }

    }

}