<?php
class calendar_block extends Engine_Class {

    public function process() {

        // сохранение настроек этапа
        if ($this->getArgumentSecure('setting-info-ok')) {
            try{
                $status = Shop::Get()->getShopService()->getStatusByID(
                    $this->getArgument('setting-status-id')
                );

                $order = Shop::Get()->getShopService()->getOrderByID($this->getArgument('setting-order-id'));
                if ($new_issue = $this->getArgumentSecure('new_issue')) {
                    $new_issue = explode("\n", $new_issue);
                    foreach ($new_issue as $issueName) {
                        if (!$issueName) {
                            continue;
                        }
                        $worlflowId = 0;
                        try{
                            // Бизнесс-процесс по умолчанию.
                            $default = Shop::Get()->getShopService()->getOrderCategoryAll();
                            $default->setDefault(1);
                            if ($default->select()) {
                                $worlflowId = $default->getId();
                            }
                            // создаем задачу
                            $issue = IssueService::Get()->addIssue(
                                $this->getUser(),
                                $issueName,
                                false,
                                $this->getArgumentSecure('manager_status'),
                                $worlflowId,
                                false,
                                false,
                                $order->getId()
                            );

                            $issue->setParentstatusid($status->getId());
                            $issue->update();
                        } catch (Exception $e) {

                        }

                    }


                }

                $employer = new XShopOrderEmployer();
                $employer->setOrderid($order->getId());
                $employer->setStatusid($status->getId());
                if ($employer->select()) {
                    $employer->setTerm($this->getArgumentSecure('statusTerm'));
                    $employer->setManagerid($this->getArgumentSecure('manager_status'));
                    $employer->update();
                } else {
                    $employer = new XShopOrderEmployer();
                    $employer->setOrderid($order->getId());
                    $employer->setStatusid($status->getId());
                    $employer->setTerm($this->getArgumentSecure('statusTerm'));
                    $employer->setManagerid($this->getArgumentSecure('manager_status'));
                    $employer->insert();
                }
            } catch (Exception $e) {

            }
            // отлавливаем удаление и изменение
            foreach ($this->getArguments() as $key => $item) {
                if (strpos($key, 'issueClosed_') === 0) {
                    $orderId = str_replace('issueClosed_', '', $key);
                    try{
                        $orderDelete = Shop::Get()->getShopService()->getOrderByID($orderId);
                        Shop::Get()->getShopService()->deleteOrder($orderDelete);
                    } catch (Exception $e) {

                    }

                }

                if (strpos($key, 'manager_') === 0) {
                    $orderId = str_replace('manager_', '', $key);
                    try{
                        $order = Shop::Get()->getShopService()->getOrderByID($orderId);
                        $order->setDateto($this->getArgumentSecure('date_to_'.$orderId));
                        $order->setManagerid($this->getArgumentSecure('manager_'.$orderId));
                        $order->update();
                    } catch (Exception $e2) {

                    }
                }
            }

        }

        // Что показываем по умолчанию (Месяц или неделю)
        $weekMonth = false;
        if (!isset($_COOKIE['calendarTypeCookie'])) {
            $weekMonth = 'week';
        } else {
            if ($show = $this->getArgumentSecure('show')) {
                $weekMonth = $show;
            } else {
                $weekMonth = $_COOKIE['calendarTypeCookie'] == 'js-by-month' ? 'month' : 'week';
            }
        }

        $this->setValue('weekMonth', $weekMonth);

        $this->setValue('dateCurrent', date('Y-m-d'));

        $m = $this->getArgumentSecure('month') ? $this->getArgumentSecure('month') : 'm';
        $y = $this->getArgumentSecure('year') ? $y = $this->getArgumentSecure('year') : 'Y';

        if (is_numeric($m) && $m < 10) {
            $m = '0'.$m;
        }

        // Даты начала, и конца месяца
        $dateMonthStart = date("{$y}-{$m}-01");
        $dateMonthEnd = date("{$y}-{$m}")."-".date('t', strtotime($dateMonthStart));

        $this->setValue('dataMonth', date("n", strtotime($dateMonthStart)));
        $this->setValue('dataYear', date("Y", strtotime($dateMonthStart)));

        $user = $this->getUser();

        // Задачи на месяц, день, alert's
        $monthArray = array();
        $weekArray = array();
        $alertArray = array();

        // Необходимо выполнить на это время
        $orders = $this->_getIssues();

        $this->setValue('whereArray', $orders->getWhere());
        $this->setValue('valueArray', $orders->getValues());

        $managerID = $this->getValue('managerid', 'int');
        if (!$managerID) {
            $managerID = $this->getUser()->getId();
        }
        $this->setControlValue('managerid', $managerID);
        
        // Все менеджера (Для создания задачи)
        $managers = Shop::Get()->getUserService()->getUsersManagers();
        $a = array();
        while ($x = $managers->getNext()) {
            $a[] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(),
            );
        }
        $this->setValue('managerArray', $a);

        // бизнес-процессы
        $workflows = Shop::Get()->getShopService()->getWorkflowsAll();
        $workflowArray = array();
        while ($x = $workflows->getNext()) {
            $workflowArray[] = array(
                'id' => $x->getId(),
                'name' => $x->getName()
            );
        }
        $this->setValue('workflowArray', $workflowArray);

        // Выбираем заказы за выбранный месяц
        $orders->addWhere('dateto', $dateMonthStart, '>=');
        $orders->addWhere('dateto', $dateMonthEnd.' 23:59:59', '<=');
        $orders->setOrder('dateto', 'ASC');
        $orders->setLimit(0, 0);

        while ($x = $orders->getNext()) {
            $d = DateTime_Object::FromString($x->getDateto())->setFormat('Y-m-d')->__toString();

            try {
                if ($x->getStatus()->getClosed()) {
                    // для закрытых задач проверяем можно ли открыть
                    $status = $x->getStatus()->getWorkflow()->getStatusDefault();
                } else {
                    // для открытых задач проверяем можно ли закрыть
                    $status = $x->getStatus()->getWorkflow()->getStatusClosed();
                }

                $canChange = !$status->getOnlyauto();

                // проверка, можно ли перейти в этот статус (issue #61622)
                if ($canChange && !$x->getStatus()->canChangeTo($status)) {
                    $canChange = false;
                }
            } catch (Exception $statusEx) {
                $canChange = false;
            }

            $time = DateTime_Formatter::TimeISO8601($x->getDateto());
            if ($time == '00:00') {
                $time = false;
            }

            $smart = false;
            $smartContent = false;
            try{
                $workflow  = $x->getWorkflow();
            } catch (Exception $e) {

            }

            $infoArray = array(
            'name' => $x->makeName(),
            'url' => $x->makeURLEdit(),
            'closed' => $x->isClosed(),
            'id' => $x->getId(),
            'canChange' => $canChange,
            'time' => $time,
            'smart' => $smart,
            'smartContent' => $smartContent,
            'project' => $x->getParentid() ? false:true
            );



            $weekArray[date("W", strtotime($d))][$d][] = $infoArray;
            $monthArray[$d][] = $infoArray;

            // если задача не закрыта - в уведомления ее
            if (!$x->isClosed()) {
                @$alertArray[$d]++;
            }
        }

        $managerID = $this->getArgumentSecure('filtermanagerid');
        try{
            $this->getArgument('filtermanagerid');
            $managerIdEmployer = $managerID;
        } catch (Exception $e2) {
            $managerIdEmployer = $this->getUser()->getId();
        }

        // этапы
        $employer = new XShopOrderEmployer();
        if ($managerIdEmployer) {
            $employer->setManagerid($managerIdEmployer);
        }
        $employer->addWhere('term', $dateMonthStart, '>=');
        $employer->addWhere('term', $dateMonthEnd.' 23:59:59', '<=');
        $employer->setOrder('term', 'ASC');

        while ($em = $employer->getNext()) {
            try{
                $emStatus = Shop::Get()->getShopService()->getStatusByID($em->getStatusid());

                $subIssue = Shop::Get()->getShopService()->getOrdersAll($this->getUser(), true);
                $subIssue->setParentid($em->getOrderid());
                $subIssue->setParentstatusid($em->getStatusid());

                $allClosed = true;
                $subIssueCount = 0;
                while ($sub = $subIssue->getNext()) {
                    $subIssueCount++;
                    if ($sub->getDateclosed() == '0000-00-00 00:00:00') {
                        $allClosed = false;
                        break;
                    }
                }

                $d2 = DateTime_Object::FromString($em->getTerm())->setFormat('Y-m-d')->__toString();

                $time = DateTime_Formatter::TimeISO8601($em->getTerm());
                if ($time == '00:00') {
                    $time = false;
                }

                try{
                    $emOrder = Shop::Get()->getShopService()->getOrderByID($em->getOrderid());
                } catch (Exception $e2) {
                    $emOrder = false;
                }

                $employerArray = array(
                    'employerId' => $em->getId(),
                    'statusName' => $emStatus->makeName(),
                    'statusId' => $emStatus->getId(),
                    'id' => $em->getOrderid(),
                    'name' => $emOrder ? $emOrder->makeName():$em->getId(),
                    'closed' => $emOrder ? $emOrder->isClosed():false,
                    'url' => $emOrder ? $emOrder->makeURLEdit():false,
                    'time' => $time,
                    'colour' => $emStatus->getColour(),
                    'allClosed' => $subIssueCount ? $allClosed:false,
                    'fireIssue' => $em->getTerm() < DateTime_Object::Now() ? true:false
                );

                $weekArray[date("W", strtotime($d2))][$d2][] = $employerArray;
                $monthArray[$d2][] = $employerArray;

            } catch (Exception $e2) {

            }

        }


        // Встреча
        $meetings = new ShopEvent();
        $meetings->setType('meeting');
        $meetings->addWhere('cdate', $dateMonthStart, '>=');
        $meetings->addWhere('cdate', $dateMonthEnd.' 23:59:59', '<=');
        $meetings->setOrder('cdate', 'ASC');
        while ($x = $meetings->getNext()) {
            $d = DateTime_Object::FromString($x->getCdate())->setFormat('Y-m-d')->__toString();

            try {
                $from = $x->getFromContact();
                $to = $x->getToContact();

                if ($managerID) {
                    if ($from->getId() != $managerID && $to->getId() != $managerID) {
                        continue;
                    }
                }

                $name = 'Встреча '.$from->makeName().' и '.$to->makeName();
                if ($x->getLocation()) {
                    $name .= " ({$x->getLocation()})";
                }

                $infoArray = array(
                'id' => $x->getId(),
                'name' => $name,
                'url' => $from->makeURLEdit(),
                );

                $weekArray[date("W", strtotime($d))][$d][] = $infoArray;
                $monthArray[$d][] = $infoArray;

                // если встреча еще не прошла - в уведомления ее
                if (!$x->getCdate() < date('Y-m-d H:i:s')) {
                    @$alertArray[$d]++;
                }
            } catch (Exception $e) {

            }
        }

        // Дни рождения

        $users = new User();
        $users->addWhereQuery('DAYOFYEAR(`bdate`) BETWEEN DAYOFYEAR(\''.$dateMonthStart.'\') AND DAYOFYEAR(\''.$dateMonthEnd.'\')');
        $users->setOrder('bdate', 'ASC');
        while ($x = $users->getNext()) {
            $d = date('Y').DateTime_Object::FromString($x->getBdate())->setFormat('-m-d')->__toString();

            try {
                $infoArray = array(
                'id' => $x->getId(),
                'name' => 'Birthday '.$x->makeName(false, 'lfm'),
                'url' => $x->makeURLEdit(),
                'type' => 'user'
                );

                $weekArray[date("W", strtotime($d))][$d][] = $infoArray;
                $monthArray[$d][] = $infoArray;

            } catch (Exception $e) {

            }

            // если др еще не прошло - в уведомления ее
            if (!($d < date('Y-m-d'))) {
                @$alertArray[$d]++;
            }
        }

        $this->setValue('calendarMonthArray', $monthArray);
        $this->setValue('calendarWeekArray', $weekArray);
        $this->setValue('calendarAlertArray', $alertArray);

        $monthDays = array();
        $weekDays = array();
        $weekArray = array();
        $from = DateTime_Object::FromString($dateMonthStart)->setFormat('Y-m-d');
        while ($from->__toString() <= $dateMonthEnd) {
            $date = $from->__toString();
            $monthDays[] = array('date' => $date, 'dayName' => $this->getDayNameByDate($date));
            $weekDays[date("W", strtotime($date))][] = array('date' => $date, 'dayName' => $this->getDayNameByDate($date));
            $weekArray[] = date("W", strtotime($date));

            $from->addDay(+1);
        }

        $currentWeek = $weekArray[0];
        if (in_array(date('W'), $weekArray) && !$this->getArgumentSecure('year')) {
            $currentWeek = date('W');
        }

        if ($this->getArgumentSecure('lastWeek')) {
            $currentWeek = $weekArray[count($weekArray) - 1];
        }

        $this->setValue('calendarMonthDateArray', $monthDays);
        $this->setValue('calendarWeekDateArray', $weekDays);
        $this->setValue('calendarCurrentWeek', $currentWeek);


        $this->setValue('calendarMonth', $this->createCurrMonthName($dateMonthStart));

        // сколько дней нужно пропустить в начале месяца?
        $date = DateTime_Object::FromString($dateMonthStart);
        $skipDay = $date->setFormat('N')->__toString() - 1;
        $this->setValue('skipDay', $skipDay);
    }

    private function getDayNameByDate ($date) {
        $dayNumber = date("w", strtotime($date));
        $daysNameArray = array('вс', 'пн', 'вт', 'ср', 'чт', 'пт', 'сб');

        return $daysNameArray[$dayNumber];
    }

    private function createCurrMonthName ($date) {
        $monthRuNamesArray = array(
        '',
        'Январь',
        'Февраль',
        'Март',
        'Апрель',
        'Май',
        'Июнь',
        'Июль',
        'Август',
        'Сентябрь',
        'Октябрь',
        'Ноябрь',
        'Декабрь',
        );
        $monthNumber = date('n', strtotime($date));

        return array("month" => $monthRuNamesArray[$monthNumber], "year" => date("Y", strtotime($date)));

    }

    /**
     * @return ShopOrder
     */
    private function _getIssues() {
        return $this->getValue('issue');
    }

}