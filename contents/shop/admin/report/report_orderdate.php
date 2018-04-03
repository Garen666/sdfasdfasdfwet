<?php
class report_orderdate extends Engine_Class {

    public function process() {
        $dateFrom = $this->getArgumentSecure('datefrom', 'date');
        $dateTo = $this->getArgumentSecure('dateto', 'date');

        if (!$dateFrom) {
            $dateFrom = DateTime_Object::Now()->setFormat('Y-m-01')->__toString();

            $this->setControlValue('datefrom', $dateFrom);
        }
        if (!$dateTo) {
            $dateTo = DateTime_Object::Now()->setFormat('Y-m-d')->__toString();

            $this->setControlValue('dateto', $dateTo);
        }

        $groupBy = $this->getControlValue('groupby');
        if (!$groupBy) {
            $groupBy = 'day';
        }

        $orderCategoryID = $this->getArgumentSecure('ordercategoryid', 'int');
        $sourceID = $this->getArgumentSecure('sourceid', 'int');
        $managerID = $this->getArgumentSecure('managerid', 'int');
        $authorID = $this->getArgumentSecure('authorid', 'int');
        $contractorID = $this->getArgumentSecure('contractorid', 'int');
        $statusID = $this->getArgumentSecure('statusid');
        $direction = $this->getArgumentSecure('direction', 'string');

        // -------

        $currencySystem = Shop::Get()->getCurrencyService()->getCurrencySystem();
        $this->setValue('currency', $currencySystem->getSymbol());

        $orders = Shop::Get()->getShopService()->getOrdersAll($this->getUser());
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
        $dateArray = array();
        $dateNameArray = array();

        if ($groupBy == 'day') {
            $d = DateTime_Object::FromString($dateFrom)->setFormat('Y-m-d');
            $dateToFormatted = DateTime_Object::FromString($dateTo)->setFormat('Y-m-d');
        } elseif ($groupBy == 'week') {
            $d = DateTime_Object::FromString($dateFrom)->setFormat('Y-W');
            $dateToFormatted = DateTime_Object::FromString($dateTo)->setFormat('Y-W');
        } elseif ($groupBy == 'month') {
            $d = DateTime_Object::FromString($dateFrom)->setFormat('Y-m');
            $dateToFormatted = DateTime_Object::FromString($dateTo)->setFormat('Y-m');
        }

        while ($d->__toString() <= $dateToFormatted) {
            // формируем дату начала/конца периода
            if ($groupBy == 'day') {
                $dateStart = $d->__toString();
                $dateEnd = $d->__toString();

                $dateNameArray[$d->__toString()] = $this->_nameDate($d, 'd M Y');
            } elseif ($groupBy == 'week') {
                $tmp = explode('-', $d->__toString());
                $dateStart = DateTime_Object::FromString($tmp[0].'-01-01')->addDay(+$tmp[1]*7-7)->setFormat('Y-m-d')->__toString();
                $dateEnd = DateTime_Object::FromString($tmp[0].'-01-01')->addDay(+$tmp[1]*7)->setFormat('Y-m-d')->__toString();

                $dateNameArray[$d->__toString()] = $this->_nameDate($d, 'W/Y');
            } elseif ($groupBy == 'month') {
                $dateStart = $d->__toString().'-01';
                $dateEnd = DateTime_Object::FromString($dateStart)->setFormat('Y-m-t')->__toString();

                $dateNameArray[$d->__toString()] = $this->_nameDate($d, 'M Y');
            }

            // запоминаем дату
            $dateArray[] = $d->__toString();

            // на заданный интервал дату считаем статистику
            $tmp = clone $orders;
            $tmp->addWhere('cdate', $dateStart, '>=');
            $tmp->addWhere('cdate', $dateEnd.' 23:59:59', '<=');
            while ($order = $tmp->getNext()) {
                try {
                    $sum = $order->getSumbase();
                    if ($order->getOutcoming()) {
                        @$reportArray[$d->__toString()]['sumOut'] -= $sum;
                        @$reportArray[$d->__toString()]['countOut'] ++;

                    } else {
                        @$reportArray[$d->__toString()]['sumIn'] += $sum;
                        @$reportArray[$d->__toString()]['margin'] += $order->makeMargin();
                        @$reportArray[$d->__toString()]['countIn'] ++;

                    }
                    @$reportArray[$d->__toString()]['count'] ++;

                } catch (Exception $e) {

                }
            }

            if ($groupBy == 'day') {
                $d->addDay(+1);
            } elseif ($groupBy == 'week') {
                $d->addDay(+7);
            } elseif ($groupBy == 'month') {
                $d->addMonth(+1);
            }

        }

        $this->setValue('reportArray', $reportArray);
        $this->setValue('dateArray', $dateArray);

        // -------

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

    private function _nameDate($d, $format) {
        $tmp = clone $d;
        $name = $tmp->setFormat($format)->__toString();

        $name = str_replace('Jan', 'Январь', $name);
        $name = str_replace('Feb', 'Февраль', $name);
        $name = str_replace('Mar', 'Март', $name);
        $name = str_replace('Apr', 'Апрель', $name);
        $name = str_replace('May', 'Май', $name);
        $name = str_replace('Jun', 'Июнь', $name);
        $name = str_replace('Jul', 'Июль', $name);
        $name = str_replace('Aug', 'Август', $name);
        $name = str_replace('Sep', 'Сентябрь', $name);
        $name = str_replace('Oct', 'Октябрь', $name);
        $name = str_replace('Nov', 'Ноябрь', $name);
        $name = str_replace('Dec', 'Декабрь', $name);

        return $name;
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