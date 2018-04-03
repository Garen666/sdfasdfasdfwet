<?php
class report_clientbalance extends Engine_Class {

    public function process() {
        $dateFrom = $this->getArgumentSecure('datefrom', 'date');
        $dateTo = $this->getArgumentSecure('dateto', 'date');

        // client id
        $clientIDArray = array();
        if ($this->getArgumentSecure('clientid')) {
            $clientIDArray = explode(',', $this->getArgumentSecure('clientid'));
        }

        $contractorID = $this->getArgumentSecure('contractorid', 'int');
        $groupCompany = $this->getArgumentSecure('groupcompany', 'bool');
        // -------

        $currencySystem = Shop::Get()->getCurrencyService()->getCurrencySystem();
        $this->setValue('currency', $currencySystem->getSymbol());

        // список статусов предполагающих оплату
        $statuses = Shop::Get()->getShopService()->getStatusAll();
        $statuses->addWhereQuery("(payed=1 OR prepayed=1)");;
        $statusIDArray = array(-1);
        while ($x = $statuses->getNext()) {
            $statusIDArray[] = $x->getId();
        }

        // идем по всем клиентам и считаем сумму заказов
        // (в статусах предполагающих оплату)
        // и сумму платежей (без привязки к заказам).
        // Если разница 0, то пропускаем.

        $reportArray = array();

        $totalOrder = 0;
        $totalPayment = 0;
        $totalDiff = 0;

        $contacts = Shop::Get()->getUserService()->getUsersAll($this->getUser());
        while ($contact = $contacts->getNext()) {
            $show = false;
            // сумма заказов
            $orders = Shop::Get()->getShopService()->getOrdersAll($this->getUser());
            $orders->addWhereArray($statusIDArray, 'statusid');
            $orders->addWhereArray($clientIDArray, 'userid');
            $orders->setUserid($contact->getId());
            if ($dateFrom) {
                $orders->addWhere('cdate', $dateFrom, '>=');
            }
            if ($dateTo) {
                $orders->addWhere('cdate', $dateTo.' 23:59:59', '<=');
            }
            if ($contractorID) {
                $orders->setContractorid($contractorID);
            }

            $orderSum = 0;
            while ($x = $orders->getNext()) {
                $tmp = $x->getSumbase();

                // считаем сумму заказов
                if ($x->getOutcoming()) {
                    $orderSum -= $tmp;
                } else {
                    $orderSum += $tmp;
                }

                $show = true;
            }

            // сумма платежей
            $paymentSum = 0;
            $payments = new FinancePayment();
            $payments->setClientid($contact->getId());
            $payments->addWhere('pdate', 0, '>');
            if ($dateFrom) {
                $orders->addWhere('pdate', $dateFrom, '>=');
            }
            if ($dateTo) {
                $orders->addWhere('pdate', $dateTo.' 23:59:59', '<=');
            }
            while ($x = $payments->getNext()) {
                $paymentSum += $x->getAmountbase();

                $show = true;
            }

            $diff = round($paymentSum - $orderSum, 2);

            if (!$show) {
                continue;
            }

            // totals
            $totalOrder += $orderSum;
            $totalPayment += $paymentSum;
            $totalDiff += $diff;

            // отправляем данные
            $reportArray[$contact->getId()] = array(
            'clientName' => $this->_escapeString($contact->makeName()),
            'clientURL' => $contact->makeURLEdit(),
            'clientId' => $contact->getId(),
            'orderSum' => $orderSum,
            'paymentSum' => $paymentSum,
            'diff' => $diff,
            );
        }

        if ($groupCompany) {
            $reportCompanyArray = array();
            foreach ($reportArray as $clientID => $a) {
                try {
                    $client = Shop::Get()->getUserService()->getUserByID($clientID);
                } catch (Exception $e) {
                    continue;
                }

                $company = $client->getCompany();
                if (!$company) {
                    $company = $client->makeName();
                }

                $reportCompanyArray[$company]['clientName'] = $company;
                $reportCompanyArray[$company]['clientURL'] = $client->makeURLEdit();
                $reportCompanyArray[$company]['clientId'] = $client->getId();
                @$reportCompanyArray[$company]['orderSum'] += $a['orderSum'];
                @$reportCompanyArray[$company]['paymentSum'] += $a['paymentSum'];
                @$reportCompanyArray[$company]['diff'] += $a['diff'];
            }

            $this->setValue('reportArray', $reportCompanyArray);
        } else {
            $this->setValue('reportArray', $reportArray);
        }

        $this->setValue('totalOrder', $totalOrder);
        $this->setValue('totalPayment', $totalPayment);
        $this->setValue('totalDiff', $totalDiff);

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

        // юридические лица
        $contractors = Shop::Get()->getShopService()->getContractorsActive();
        $this->setValue('contractorArray', $contractors->toArray());

        // Выбранные из клиентов
        $clientArray = array();
        foreach ($clientIDArray as $clientID) {
            try {
                $client = Shop::Get()->getUserService()->getUserByID($clientID);

                $clientArray[] = array(
                    'id' => $clientID,
                    'text' => $client->makeName()
                );
            } catch (ServiceUtils_Exception $pe) {

            }
        }
        $this->setValue('clientArray', $clientArray);
        if (empty($clientArray)){
            $this->setValue('clientempty', true);
        }

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

}