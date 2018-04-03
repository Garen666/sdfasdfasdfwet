<?php
class event_list_block extends Engine_Class {

    /**
     * @return ShopEvent
     */
    private function _getEvents() {
        return $this->getValue('events');
    }

    public function process() {
        $events = $this->_getEvents();

        // накладываем фильтра

        $datefrom = $this->getArgumentSecure('datefrom', 'date');
        $dateto = $this->getArgumentSecure('dateto', 'date');

        if (!$this->getArgumentSecure('showhidden') && !$this->getValue('showhidden')) {
            $events->setHidden(0);
            $events->addWhere('cdate', date('Y-m-d H:i:s'), '<=');
        }

        $direction = $this->getControlValue('direction');
        if ($direction == 'in') {
            $events->setDirection(-1);
        } elseif ($direction == 'out') {
            $events->setDirection(+1);
        } elseif ($direction == 'our') {
            $events->setDirection(0);
        }

        if ($datefrom) {
            $events->addWhere('cdate', $datefrom, '>=');
        }
        if ($dateto) {
            $events->addWhere('cdate', $dateto.' 23:59:59', '<=');
        }

        // условия фильтрации
        $from = $this->getControlValue('from');
        if ($from) {
            $events->addWhere('from', '%'.$from.'%', 'LIKE');
        }

        $to = $this->getControlValue('to');
        if ($to) {
            $events->addWhere('to', '%'.$to.'%', 'LIKE');
        }

        $channel = $this->getControlValue('channel');
        if ($channel) {
            $events->addWhere('channel', '%'.$channel.'%', 'LIKE');
        }

        $sourceID = $this->getControlValue('sourceid');
        if ($sourceID > 0) {
            $events->setSourceid($sourceID);
        }

        $type = $this->getControlValue('type');
        if ($type) {
            $events->setType($type);
        }

        $status = $this->getControlValue('status');
        if ($status) {
            $events->setStatus(strtoupper($status));
        }

        $subject = $this->getControlValue('subject');
        if ($subject) {
            $events->addWhere('subject', '%'.$subject.'%', 'LIKE');
        }

        $content = $this->getControlValue('content');
        if ($content) {
            $events->addWhere('content', '%'.$content.'%', 'LIKE');
        }

        // ---

        $onPage = 50;
        $page = $this->getArgumentSecure('page', 'int');

        $events->setLimit($page * $onPage, $onPage);

        $a = array();
        while ($x = $events->getNext()) {
            $fileSound = false;
            $hidden = false;

            if ($x->getType() == 'call' && $x->getFile()) {
                try {
                    $fileSound = '/media/call/';
                    $fileSound .= $x->getFile();

                    if (!file_exists(PackageLoader::Get()->getProjectPath().$fileSound)) {
                        $fileSound = 'load';
                    }
                } catch (Exception $e) {

                }
            }

            $access = true;
            $accessRating = true;

            // по полю from определяем юзера
            try {
                $tmp = $x->getFromContact();

                $nameFrom = $tmp->makeName();
                $urlFrom = $tmp->makeURLEdit();
                $idFrom = $tmp->getId();

                // проверка ACL
                if ($tmp->getLevel() >= 2
                && $this->getUser()->isDenied('users-manager-'.$tmp->getId().'-history')) {
                    $access = false;
                }
                if ($tmp->getLevel() >= 2
                && $this->getUser()->isDenied('users-manager-'.$tmp->getId().'-history-rating')) {
                    $accessRating = false;
                }

                // свое видно
                if ($tmp->getId() == $this->getUser()->getId()) {
                    $access = true;
                }
            } catch (Exception $e) {
                $nameFrom = false;
                $urlFrom = false;
                $idFrom = false;
            }

            // по полю to определяем юзера
            try {
                $tmp = $x->getToContact();

                $nameTo = $tmp->makeName();
                $urlTo = $tmp->makeURLEdit();
                $idTo = $tmp->getId();

                // проверка ACL
                if ($tmp->getLevel() >= 2
                && $this->getUser()->isDenied('users-manager-'.$tmp->getId().'-history')) {
                    $access = false;
                }
                if ($tmp->getLevel() >= 2
                && $this->getUser()->isDenied('users-manager-'.$tmp->getId().'-history-rating')) {
                    $accessRating = false;
                }

                // свое видно
                if ($tmp->getId() == $this->getUser()->getId()) {
                    $access = true;
                }
            } catch (Exception $e) {
                $nameTo = false;
                $urlTo = false;
                $idTo = false;
            }

            // если ничего не известно - то прячем событие
            // если известно все - показываем
            if (!$nameFrom && !$nameTo) {
                $hidden = true;
            } elseif ($nameFrom && $nameTo) {
                $hidden = false;
            }

            // вложения
            $attachmentArray = array();
            $attachs = new XShopEventAttachment();
            $attachs->setEventid($x->getId());
            while ($y = $attachs->getNext()) {
                $fileName = trim($y->getName());
                if (!$fileName) {
                    $fileName = '(no name)';
                }

                $filePath = PackageLoader::Get()->getProjectPath().'media/email/'.$y->getFile();
                $size = @round(filesize($filePath) / 1024 / 1024, 2);

                $url = Engine::GetLinkMaker()->makeURLByContentIDParam(
                'event-download',
                $y->getId()
                );

                $attachmentArray[] = array(
                'name' => $fileName,
                'type' => $y->getContenttype(),
                'url' => $url,
                'size' => $size,
                );
            }

            $content = $this->_processContent($x->getContent());

            if (!$access) {
                $fileSound = false;
                $attachmentArray = false;
                $content = 'Доступ к информации запрещен.';
            }

            if ($x->getType() != 'email' || $x->getId() == $x->getReplyid()) {
                $replyDate = false;
                $replyDiff = false;
            } else {
                if (Checker::CheckDate($x->getReplydate())) {
                    $replyDate = $x->getReplydate();
                    $replyDiff = $this->_makeDiff($replyDate, $x->getCdate());
                } else {
                    $replyDate = false;
                    $replyDiff = $this->_makeDiff('now', $x->getCdate());
                }
            }
            //проверить если событие моложе 10 минут, не выводить сообщение
            $filter_replyDiff = false;
            if ($replyDiff) {
                $time = explode(' ', $replyDiff);
                if ($time[0] <= 10 && $time[1] === 'мин.') {
                    $filter_replyDiff = true;
                }
            }

            try {
                $sourceName = Shop::Get()->getShopService()->getSourceByID(
                $x->getSourceid()
                )->getName();
            } catch (Exception $sourceEx) {
                $sourceName = false;
            }

            $status = false;
            if ($x->getStatus() == 'NOANSWER' || $x->getStatus() == 'CHANUNAVAIL' || $x->getStatus() == 'CANCEL' || $x->getStatus() == 'BUSY' || $x->getStatus() == 'INVALID' || $x->getStatus() == 'CONGESTION') {
                $status = 'fail';
            } elseif ($x->getStatus() == 'TRANSFER' || $x->getStatus() == 'AUTOTRANSFER') {
                $status = 'transfer';
            }

            $a[] = array(
            'id' => $x->getId(),
            'type' => $x->getType(),
            'subject' => trim($x->getSubject()),
            'cdate' => $x->getCdate(),
            'from' => $x->getFrom(),
            'to' => $x->getTo(),
            'location' => $x->getLocation(),
            'hidden' => $hidden,
            'nameFrom' => $nameFrom,
            'idFrom' => $idFrom,
            'urlFrom' => $urlFrom,
            'nameTo' => $nameTo,
            'idTo' => $idTo,
            'urlTo' => $urlTo,
            'content' => $content,
            'fileSound' => $fileSound,
            'attachmentArray' => $attachmentArray,
            'replyDate' => $replyDate,
            'filter_replyDiff' => $filter_replyDiff,
            'replyDiff' => $replyDiff,
            'inFuture' => $x->getCdate() > date('Y-m-d H:i:s'),
            'rating' => $x->getRating(),
            'accessRating' => $accessRating,
            'statusName' => $x->getStatus(),
            'status' => $status,
            'meetingUrl' => $x->makeURL(),
            'duration' => $this->_makeDuration($x->getDuration()),
            'channel' => $x->getChannel(),
            'sourceName' => $sourceName,
            'url' => $x->makeURL(),
            );
        }
        $this->setValue('eventArray', $a);

        $this->setValue('project_box_events_nocallrecord', Engine::Get()->getConfigFieldSecure('project-box-events-nocallrecord'));

        if ($a) {
            $nextURL = Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(
            array('page' => $page + 1)
            );

            $this->setValue('nextPageURL', $nextURL);
        }
        if ($page > 0) {
            $prevURL = Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(
            array('page' => $page - 1)
            );

            $this->setValue('prevPageURL', $prevURL);
        }

        // источники
        $sources = Shop::Get()->getShopService()->getSourceAll();
        $sources->addWhere('address', '', '<>');
        $a = array();
        while ($x = $sources->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(),
            );
        }
        $this->setValue('sourceArray', $a);
    }

    private function _processContent($content) {
        PackageLoader::Get()->import('TextProcessor');
        $processor = new TextProcessor_ActionTextToHTML();
        return $processor->process($content);
    }

    private function _makeDiff($a, $b) {
        $replyDiff = DateTime_Differ::DiffMinute($a, $b);
        if ($replyDiff < 60) {
            return $replyDiff.' мин.';
        }

        $replyDiff = DateTime_Differ::DiffHour($a, $b);
        if ($replyDiff < 24) {
            return $replyDiff.' ч.';
        }

        $replyDiff = DateTime_Differ::DiffDay($a, $b);
        if ($replyDiff < 30) {
            return $replyDiff.' д.';
        }

        $replyDiff = DateTime_Differ::DiffMonth($a, $b);
        return $replyDiff.' мес.';
    }

    /**
     * Превратить секунды в h:m:s
     *
     * @param int $s
     * @return string
     */
    private function _makeDuration($s) {
        if (!$s) {
            return false;
        }

        if ($s < 10) {
            return '00:0'.$s;
        }
        if ($s < 60) {
            return '00:'.$s;
        }
        $x = floor($s/60);
        $y = ($s - $x * 60);
        if ($y < 10) {
            $y = '0'.$y;
        }
        return $x.':'.$y;
    }

}