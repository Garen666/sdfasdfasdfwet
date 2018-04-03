<?php
class issue_add extends Engine_Class {

    public function process() {
        PackageLoader::Get()->registerJSFile('/_js/jsPlumb.js');

        try {
            $documentsArray = array();

            if ($this->getArgumentSecure('ok')
            || $this->getArgumentSecure('oknext')
            ) {
                try {
                    SQLObject::TransactionStart();

                    // контактная информация клиента
                    if ($clientId = $this->getControlValue('clientid')) {
                        try{
                            $client = Shop::Get()->getUserService()->getUserByID($clientId);
                            $client->setPhone($this->getArgumentSecure('contact_phone'));
                            $client->setEmail($this->getArgumentSecure('contact_email'));
                            $client->setSkype($this->getArgumentSecure('contact_skype'));
                            $client->setWhatsapp($this->getArgumentSecure('contact_whatsapp'));
                            $client->update();
                        } catch (Exception $e2) {

                        }
                    }

                    // собираем описание
                    $content = '';

                    if ($this->getControlValue('content')) {
                        $content .= $this->getControlValue('content')."\n";
                        $content .= "\n";
                    }

                    if ($this->getControlValue('result')) {
                        $content .= "Результат:\n";
                        $content .= $this->getControlValue('result')."\n";
                        $content .= "\n";
                    }

                    if ($this->getControlValue('resource')) {
                        $content .= "Доступные ресурсы:\n";
                        $content .= $this->getControlValue('resource')."\n";
                        $content .= "\n";
                    }

                    $parentid = false;
                    if (preg_match('/^#?([\d]+)/iusD', trim($this->getControlValue('parentid')), $r)) {
                        $parentid = $r[1];
                    }

                    // создаем задачу
                    $issue = IssueService::Get()->addIssue(
                    $this->getUser(),
                    $this->getControlValue('name'),
                    $content,
                    $this->getControlValue('managerid'),
                    $this->getControlValue('workflowid'),
                    $this->getControlValue('dateto'),
                    $this->getControlValue('clientid'),
                    $parentid
                    );

                    // устанавливаем валюту от бизнес-процесса
                    try{
                        if ($this->getControlValue('workflowid')) {
                            $workflow = Shop::Get()->getShopService()->getOrderCategoryByID($this->getControlValue('workflowid'));
                            if ($workflow->getCurrencyid()) {
                                $issue->setCurrencyid($workflow->getCurrencyid());
                                $issue->update();
                            }

                        }
                    } catch (Exception $e) {

                    }

                    // устанавливаем статус
                    if ($this->getArgumentSecure('statusIdDefaultIssue')) {
                        try{
                            Shop::Get()->getShopService()->updateOrderStatus($this->getUser(), $issue, $this->getArgumentSecure('statusIdDefaultIssue'));
                        } catch (Exception $e) {

                        }
                    }

                    // Устанавливаем источник.
                    if ($sourceId = $this->getArgument('source')) {
                        $issue->setSourceid($sourceId);
                        $issue->update();
                    }

                    $cdate = $this->getArgumentSecure('datefrom', 'datetime');
                    if ($cdate) {
                        $issue->setCdate($cdate);
                        $issue->update();
                    }

                    $estimateTime = $this->getArgumentSecure('estimatetime', 'float');
                    if ($estimateTime) {
                        $issue->setEstimate($estimateTime);
                        $issue->update();
                    }

                    $estimateMoney = $this->getArgumentSecure('estimatemoney', 'float');
                    if ($estimateMoney) {
                        $issue->setMoney($estimateMoney);
                        $issue->update();
                    }

                    // продукты из таблицы в заказ
                    foreach ($this->getArguments() as $key => $item) {
                        if (preg_match('#add_product_([\d]+)#uisD', $key, $r)) {
                            $id = $r[1];
                            try {
                                $orderProduct = Shop::Get()->getShopService()->addOrderProduct($issue, $id);
                                $orderProduct->setProductcount($this->getArgumentSecure('count_product_'.$id));
                                $orderProduct->setSerial($this->getArgumentSecure('serial_product_'.$id));
                                $orderProduct->setProductprice($this->getArgumentSecure('price_product_'.$id));

                                $orderProduct->update();
                            } catch (Exception $productEx) {

                            }
                        }

                    }

                    // скидка
                    $issue->setDiscountid($this->getArgumentSecure('discount'));
                    // доставка
                        // оплата
                    $issue->setPaymentid($this->getArgumentSecure('payment'));

                    // контактная инф.
                    $issue->setClientemail($this->getArgumentSecure('contact_email'));
                    $issue->setClientphone($this->getArgumentSecure('contact_phone'));

                    $issue->update();
                    Shop::Get()->getShopService()->recalculateOrderSums($issue);

                    // назначаем исполнителей
                    $workflow = $issue->getCategory();
                    $status = $workflow->getStatuses();
                    while ($s = $status->getNext()) {
                        $statusID = $s->getId();
                        $employerID = $this->getArgumentSecure('manager_status_'.$statusID);
                        $term = $this->getArgumentSecure('status_term_'.$statusID);
                        if (!$term && $s->getTerm()) {
                            if ($s->getTermperiod()=='hour') {
                                $term = DateTime_Object::Now()->addHour($s->getTerm())->__toString();
                            } elseif ($s->getTermperiod()=='day') {
                                $term = DateTime_Object::Now()->addDay($s->getTerm())->__toString();
                            } elseif ($s->getTermperiod()=='week') {
                                $term = DateTime_Object::Now()->addDay($s->getTerm()*7)->__toString();
                            } elseif ($s->getTermperiod()=='month') {
                                $term = DateTime_Object::Now()->addMonth($s->getTerm())->__toString();
                            }

                        }

                        if ($statusID && ($employerID || $term)) {
                            $oes = new XShopOrderEmployer();
                            $oes->setOrderid($issue->getId());
                            $oes->setManagerid($employerID);
                            $oes->setStatusid($statusID);
                            $oes->setTerm($term);
                            $oes->insert();
                        }
                    }

                    // custom fields
                    try {
                        $customFieldArray = Engine::Get()->getConfigField('project-box-customfield-order');

                        foreach ($customFieldArray as $index => $x) {
                            if (!empty($x['workflowid'])) {
                                if ($x['workflowid'] != $workflow->getId()) {
                                    unset($customFieldArray[$index]);
                                }
                            }
                        }
                    } catch (Exception $e) {
                        $customFieldArray = array();
                    }


                    SQLObject::TransactionCommit();

                    // создание документов
                    if (Shop_ModuleLoader::Get()->isImported('document')) {
                        foreach ($this->getArguments() as $key => $item) {
                            if (preg_match('/document_([\d]+)/iusD', $key, $res)) {
                                try {
                                    $object = DocumentService::Get()->getObjectByID($issue->getId(), $issue->getClassname());
                                    if (!method_exists($object, 'makeAssignArrayForDocument')) {
                                        throw new ServiceUtils_Exception();
                                    }
                                    $document = DocumentService::Get()->addDocument(
                                        $this->getUser(),
                                        false,
                                        $res[1],
                                        $issue->getClassname().'-'.$issue->getId(),
                                        false,
                                        false,
                                        false,
                                        false,
                                        false,
                                        $object->makeAssignArrayForDocument()
                                    );
                                    $documentsArray[] = $document->getId();
                                } catch (ServiceUtils_Exception $ee) {

                                }
                            }
                        }
                    }

                    $this->setValue('documentsArray', $documentsArray);
                    $this->setValue('message', 'ok');
                    $this->setValue('messageIssueInfo', array('id' => $issue->getId(), 'url' => $issue->makeURLEdit()));

                    if ($this->getArgumentSecure('ok')) {
                        $this->setValue('urlredirect', $issue->makeURLEdit());
                    } else {
                        $this->setValue('clearFields', true);
                    }
                } catch (Exception $ge) {
                    SQLObject::TransactionRollback();

                    $this->setValue('message', 'error');
                }
            }

            try {
                $eventID = $this->getArgument('eventid');
                $events = EventService::Get()->getEventsAll();
                $events->setId($eventID);

                $block = Engine::GetContentDriver()->getContent('event-list-block');
                $block->setValue('events', $events);
                $block->setValue('showhidden', true);
                $block->setValue('noFilter', true);
                $this->setValue('block_event', $block->render());
            } catch (Exception $eventEx) {

            }

            // менеджеры
            $user = $this->getUser();
            $this->setValue('userId', $user->getId());
            $managers = Shop::Get()->getUserService()->getUsersManagers($user);
            $a = array();
            if ( $this->getControlValue('managerid') ) {
                $selectedManagerId = $this->getControlValue('managerid');
            } else {
                $selectedManagerId = $user->getId();
            }

            while ($x = $managers->getNext()) {
                $selected = false;
                if( $selectedManagerId == $x->getId() ){
                    $selected = true;
                }
                $a[] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(),
                'selected' => $selected
                );
            }
            $this->setValue('managerArray', $a);

            // список источников
            $source = Shop::Get()->getShopService()->getSourceAll();
            $a = array();
            while ($x = $source->getNext()) {
                $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->makeName(),
                );
            }
            $this->setValue('sourceArray', $a);

            // какой таб?
            if ($this->getArgumentSecure('workflowid')) {
                $this->setValue('workflowid', $this->getArgumentSecure('workflowid'));
                try{
                    $workflow = Shop::Get()->getShopService()->getOrderCategoryByID($this->getArgumentSecure('workflowid'));

                        $this->setValue('tabIssueSelected', 'order');
                } catch (Exception $e2) {
                    $this->setValue('tabIssueSelected', @$_COOKIE['issue-add-tab']);
                }

            } else {
                $this->setValue('tabIssueSelected', @$_COOKIE['issue-add-tab']);
            }

            // список шаблонов
            if (Shop_ModuleLoader::Get()->isImported('document')) {
                $templates = DocumentService::Get()->getDocumentTemplatesByClassname('ShopOrder');
                $templateArray = array();
                while ($x = $templates->getNext()) {
                    if ($this->getUser()->isAllowed('document-print-'.$x->getId())) {
                        $templateArray[] = array(
                            'id' => $x->getId(),
                            'name' => htmlspecialchars($x->getName()),
                        );
                    }
                }
                $this->setValue('templateArray', $templateArray);
            }

            // способы оплаты
            $paymentArray = array();
            $payment = Shop::Get()->getShopService()->getPaymentAll();
            $payment->filterHidden(0);
            while ($x = $payment->getNext()) {
                $paymentArray[] = array(
                    'id' => $x->getId(),
                    'name' => $x->getName(),
                );
            }
            $this->setValue('paymentArray', $paymentArray);

            // скидки
            $discountArray = array();
            $discount = Shop::Get()->getShopService()->getDiscountAll();
            while ($x = $discount->getNext()) {
                if ($x->getType() == 'percent') {
                    $currencyType = '%';
                } else {
                    try{
                        $currencyType = $x->getCurrency()->getSymbol();
                    } catch (Exception $e2) {
                        $currencyType = false;
                    }
                }

                $discountArray[] = array(
                    'id' => $x->getId(),
                    'name' => $x->getName(),
                    'type' => $currencyType,
                    'amount' => $x->getValue(),
                    'started' => $x->getMinstartsum()
                );
            }
            $this->setValue('discountArray', $discountArray);

            $this->setValue('docsListCookie', $_COOKIE['docs-list']);

            // категории
            $category = Shop::Get()->getShopService()->makeCategoryTree();
            $a = array();
            foreach ($category as $x) {
                $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->makeName(),
                    'level' => $x->getField('level'),
                );
            }
            $this->setValue('categoryArray', $a);

        } catch (Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

    private function _makeCategoryArray() {
        $category = Shop::Get()->getShopService()->getCategoryAll();
        $category->setHidden(0);
        $a = array();
        while ($x = $category->getNext()) {
            $a[$x->getParentid()][] = array(
                'id' => $x->getId(),
                'name' => $x->getName(),
            );
        }
        return $this->_makeCategoryTree(0, 0, $a);
    }

    private function _makeCategoryTree($parentID, $level, $categoryArray) {
        $a = array();

        if (empty($categoryArray[$parentID])) {
            return $a;
        }

        foreach ($categoryArray[$parentID] as $x) {
            $b = array();
            $x['level'] = $level;

            $childs = $this->_makeCategoryTree($x['id'], $level + 1, $categoryArray);

            foreach ($childs as $y) {
                $b[] = $y;
            }

            $x['childsArray'] = $b;

            $a[] = $x;
        }
        return $a;
    }

}