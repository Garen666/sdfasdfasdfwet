<?php
class report_eventdate extends Engine_Class {

    public function process() {
        $dateFrom = $this->getArgumentSecure('datefrom', 'date');
        $dateTo = $this->getArgumentSecure('dateto', 'date');

        $groupBy = $this->getControlValue('groupby');
        if (!$groupBy) {
            $groupBy = 'day';
        }

        $showBy = $this->getControlValue('showby');
        if (!$showBy) {
            $showBy = 'summary';
        }

        if (!$dateFrom) {
            if ($groupBy == 'month') {
                $dateFrom = DateTime_Object::Now()->setFormat('Y-01-01')->__toString();
            } else {
                $dateFrom = DateTime_Object::Now()->setFormat('Y-m-01')->__toString();
            }

            $this->setControlValue('datefrom', $dateFrom);
        }
        if (!$dateTo) {
            $dateTo = DateTime_Object::Now()->setFormat('Y-m-d')->__toString();

            $this->setControlValue('dateto', $dateTo);
        }

        $from = $this->getArgumentSecure('from', 'string');
        $to = $this->getArgumentSecure('to', 'string');
        $callDuration = $this->getArgumentSecure('callduration', 'int');

        if (!$callDuration) {
            $callDuration = 10;
        }

        $groupCompany = $this->getArgumentSecure('groupcompany', 'bool');

        // ---

        $reportArray = array();
        $reportManagerArray = array();
        $reportClientArray = array();
        $dateArray = array();
        $dateNameArray = array();

        $managerArray = array();
        $clientArray = array();

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

            // на указанную дату считаем количество событий
            $events = new ShopEvent();
            $events->setHidden(0);
            $events->addWhere('cdate', $dateStart, '>=');
            $events->addWhere('cdate', $dateEnd.' 23:59:59', '<=');
            if ($from) {
                $events->setFrom($from);
            }
            if ($to) {
                $events->setTo($to);
            }
            while ($e = $events->getNext()) {
                if ($e->getType() == 'call' && $callDuration > 0) {
                    if ($e->getDuration() > 0 && $e->getDuration() > $callDuration) {
                        continue;
                    }
                }

                $direction = $e->makeDirection();
                @$reportArray[$d->__toString()][$e->getType().'_All'] ++;
                @$reportArray[$d->__toString()][$e->getType().'_'.$direction] ++;

                // определяем менеджера или клиента
                if ($showBy == 'manager' || $showBy == 'client') {
                    try {
                        $userFrom = $e->getFromContact();

                        if ($userFrom->isManager()) {
                            @$reportManagerArray[$userFrom->getId()][$d->__toString()][$e->getType().'All'] ++;
                            @$reportManagerArray[$userFrom->getId()][$d->__toString()][$e->getType().$direction] ++;

                            $managerArray[$userFrom->getId()] = $this->_escapeString($userFrom->makeName());
                        } else {
                            $company = $userFrom->getCompany();
                            if (!$company) {
                                $company = $userFrom->makeName();
                            }

                            if ($groupCompany) {
                                @$reportClientArray[$company][$d->__toString()][$e->getType().'All'] ++;
                                @$reportClientArray[$company][$d->__toString()][$e->getType().$direction] ++;

                                $clientArray[$company] = $this->_escapeString($company);
                            } else {
                                @$reportClientArray[$userFrom->getId()][$d->__toString()][$e->getType().'All'] ++;
                                @$reportClientArray[$userFrom->getId()][$d->__toString()][$e->getType().$direction] ++;

                                $clientArray[$userFrom->getId()] = $this->_escapeString($userFrom->makeName());
                            }
                        }
                    } catch (Exception $ex) {

                    }

                    try {
                        $userTo = $e->getToContact();

                        if ($userTo->isManager()) {
                            @$reportManagerArray[$userTo->getId()][$d->__toString()][$e->getType().'All'] ++;
                            @$reportManagerArray[$userTo->getId()][$d->__toString()][$e->getType().$direction] ++;

                            $managerArray[$userTo->getId()] = $this->_escapeString($userTo->makeName());
                        } else {
                            $company = $userTo->getCompany();
                            if (!$company) {
                                $company = $userTo->makeName();
                            }

                            if ($groupCompany) {
                                @$reportClientArray[$company][$d->__toString()][$e->getType().'All'] ++;
                                @$reportClientArray[$company][$d->__toString()][$e->getType().$direction] ++;

                                $clientArray[$company] = $this->_escapeString($company);
                            } else {
                                @$reportClientArray[$userTo->getId()][$d->__toString()][$e->getType().'All'] ++;
                                @$reportClientArray[$userTo->getId()][$d->__toString()][$e->getType().$direction] ++;

                                $clientArray[$userTo->getId()] = $this->_escapeString($userTo->makeName());
                            }
                        }
                    } catch (Exception $ex) {

                    }
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
        $this->setValue('monthNameArray', $dateNameArray);

        if ($showBy == 'client') {
            $this->setValue('reportClientArray', $reportClientArray);
            $this->setValue('clientArray', $clientArray);
        }

        if ($showBy == 'manager') {
            $this->setValue('reportManagerArray', $reportManagerArray);
            $this->setValue('managerArray', $managerArray);
        }

        $this->setValue('showBy', $showBy);
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