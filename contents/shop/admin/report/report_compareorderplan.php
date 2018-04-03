<?php
class report_compareorderplan extends Engine_Class {

    public function process() {
        $dateFrom = $this->getArgumentSecure('datefrom');
        $dateTo = $this->getArgumentSecure('dateto');

        if (!$dateFrom) {
            $dateFrom = DateTime_Object::Now()->addDay(+0)->setFormat('Y-m-01')->__toString();

            $this->setControlValue('datefrom', $dateFrom);
        } else {
            $dateFrom = DateTime_Object::FromString($dateFrom)->setFormat('Y-m-d')->__toString();
        }
        if (!$dateTo) {
            $dateTo = DateTime_Object::Now()->addMonth(+1)->setFormat('Y-m-t')->__toString();

            $this->setControlValue('dateto', $dateTo);
        } else {
            $dateTo = DateTime_Object::FromString($dateTo)->setFormat('Y-m-d')->__toString();
        }

        $orderCategoryID = $this->getArgumentSecure('ordercategoryid', 'int');
        $sourceID = $this->getArgumentSecure('sourceid', 'int');
        $managerID = $this->getArgumentSecure('managerid', 'int');
        $authorID = $this->getArgumentSecure('authorid', 'int');
        $contractorID = $this->getArgumentSecure('contractorid', 'int');
        $statusID = $this->getArgumentSecure('statusid');
        $direction = $this->getArgumentSecure('direction', 'string');

        // -------

        // идем по всем заказам и считаем статистику

        $orders = Shop::Get()->getShopService()->getOrdersAll($this->getUser());
        $orders->addWhere('cdate', $dateFrom, '>=');
        $orders->addWhere('cdate', $dateTo.' 23:59:59', '<=');
        if ($direction == 'in') {
            $orders->setOutcoming(0);
        }
        if ($direction == 'out') {
            $orders->setOutcoming(1);
        }
        if ($orderCategoryID) {
            $orders->setCategoryid($orderCategoryID);
        }
        if ($sourceID) {
            $orders->setSourceid($sourceID);
        }
        if ($managerID) {
            $orders->setManagerid($managerID);
        }
        if ($authorID) {
            $orders->setAuthorid($authorID);
        }
        if ($contractorID) {
            $orders->setContractorid($contractorID);
        }
        if ($statusID) {
            $orders->setStatusid($statusID);
        }

        $reportArray = array();

        $currencySystem = Shop::Get()->getCurrencyService()->getCurrencySystem();
        $this->setValue('currency', $currencySystem->getSymbol());

        while ($order = $orders->getNext()) {
            try {
                $sum = $order->getSumbase();
                    $reportArray[] = array(
                    'name' => $order->makeName(),
                    'orderId' => $order->getId(),
                    'orderUrl' => $order->makeURLEdit(),
                    'client' =>$order->getClient()->makeName(),
                    'clientUrl' =>$order->getClient()->makeURLEdit(),
                    'clientId' =>$order->getClient()->getId(),
                    'sum' => $sum,
                    'money' => $order->getMoney(),
                    'diference' =>$order->getMoney() - $sum,
                    'paid' => $order->getSumpaid(),
                    'balance' => $order->getSumpaid() - $sum,
                    );

            } catch (Exception $e) {

            }

        }

        $this->setValue('reportArray', $reportArray);

        // менеджеры
        $a = array();
        $managers = Shop::Get()->getUserService()->getUsersManagers();
        while ($x = $managers->getNext()) {
            $a[] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(),
            );
        }
        $this->setValue('managerArray', $a);

        // источники заказов
        $sources = Shop::Get()->getShopService()->getSourceAll();
        $this->setValue('sourceArray', $sources->toArray());

        // категории заказов
        $category = Shop::Get()->getShopService()->getOrderCategoryAll();
        $this->setValue('orderCategoryArray', $category->toArray());

        // юридические лица
        $contractors = Shop::Get()->getShopService()->getContractorsActive();
        $this->setValue('contractorArray', $contractors->toArray());

        // статусы заказов
        $this->setValue('statusArray', $this->_getOrderStatus());
    }

    private function _escapeString($s) {
        $s = trim($s);
        $s = str_replace("\n", '', $s);
        $s = str_replace("\r", '', $s);
        $s = str_replace("\t", '', $s);
        $s = str_replace("'", '', $s);
        $s = str_replace("\"", '', $s);
        return $s;
    }

    private function _getOrderStatus() {
        $orderStatus = Shop::Get()->getShopService()->getStatusAll();
        $status = array();
        while ($x = $orderStatus->getNext()) {
            try {
                $category = Shop::Get()->getShopService()->getOrderCategoryByID(
                    $x->getCategoryid()
                );

                if ($category->getIssue()) {
                    continue;
                }

                $categoryName = $category->makeName();
            } catch (Exception $e) {
                $categoryName = 'Без категории';
            }

            $status[$categoryName][] = array(
                'id' => $x->getId(),
                'name' => $x->getName(),
                'color' => $x->getColour(),
            );
        }
        return $status;
    }

}