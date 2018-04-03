<?php
class issue_list extends Engine_Class {

    /**
     * @return ShopOrder
     */
    private function _getIssues() {
        return $this->getValue('issues');
    }

    /**
     * @return Datasource_Issue
     */
    private function _getDatasource() {
        if ($this->_datasource === null) {
            $this->_datasource = $this->getValue('datasource');
            if (!$this->_datasource) {
                $this->_datasource = new Datasource_Issue();
            }
        }
        return $this->_datasource;
    }

    public function process() {
        // массовое удаление
        if ($this->getControlValue('delete')){
            if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                $activeUser = Shop::Get()->getUserService()->getUser();
                foreach ($r[1] as $issueID) {
                    try {
                        $issue = IssueService::Get()->getIssueByID($issueID);

                        try {
                            CommentsAPI::Get()->addComment(
                            'shop-history-issue-del'.$activeUser->getId(),
                            'Удалена задача'.' #'.$issue->getId().' '.$issue->makeName(),
                            $activeUser->getId()
                            );
                        } catch (Exception $e) {

                        }

                        Shop::Get()->getShopService()->deleteOrder($issue, $this->getUser());
                    } catch (Exception $pe) {

                    }
                }
            }
        }

        // массовое изменение
        if ($this->getControlValue('change')){
            if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                $category = null;
                $manager = null;
                $status = null;
                $dueDate = null;
                $action = null;

                if ( $this->getControlValue('manager') ) {
                    try {
                        $manager = Shop::Get()->getUserService()->getUserByID(
                        $this->getControlValue('manager')
                        );
                    } catch ( Exception $e ) {

                    }
                }

                if ( $this->getArgumentSecure('status') ) {
                    $status = $this->getArgumentSecure('status');
                }

                if ( $this->getArgumentSecure('dueDate') ) {
                    $dueDate = $this->getArgumentSecure('dueDate');
                }
                if ( $this->getArgumentSecure('action') ) {
                    $action = $this->getArgumentSecure('action');
                }

                foreach ($r[1] as $issueID) {
                    try {
                        SQLObject::TransactionStart();
                        $issue = IssueService::Get()->getIssueByID($issueID);

                        // обновляем менеджера заказа
                        if ( $manager != null ) {
                            Shop::Get()->getShopService()->updateOrderManager($issue, $manager);
                        }

                        // обновляем статус
                        if ( $status != null ) {
                            try{
                                $statusOrder = Shop::Get()->getShopService()->getStatusByID($status);
                                $issue->setCategoryid($statusOrder->getCategoryid());
                            } catch (Exception $e) {

                            }

                            Shop::Get()->getShopService()->updateOrderStatus(
                            $this->getUser(),
                            $issue,
                            $status
                            );

                        }

                        if ($dueDate) {
                            $issue->setDateto($dueDate);
                            $issue->update();
                        }

                        try{
                            if ($action == 'closed') {

                                Shop::Get()->getShopService()->updateOrderStatus(
                                $this->getUser(),
                                $issue,
                                $issue->getCategory()->getStatusClosed()->getId()
                                );

                            } elseif ($action == 'open') {

                                Shop::Get()->getShopService()->updateOrderStatus(
                                $this->getUser(),
                                $issue,
                                $issue->getCategory()->getStatusDefault()->getId()
                                );

                            }

                        } catch (Exception $e) {

                        }


                        SQLObject::TransactionCommit();

                    } catch (Exception $pe) {
                        SQLObject::TransactionRollback();
                    }
                }
            }
        }

        $customOrderNumber = Engine::Get()->getConfigFieldSecure('project-box-custom-order-number');
        $this->setValue('customOrderNumber', $customOrderNumber);

        $this->setValue('isBox', Engine::Get()->getConfigFieldSecure('project-box'));

        $datasource = $this->_getDatasource(); // ссылка на $this->_datasource

        $issues = $this->_getIssues();
        if ($issues) {
            $datasource->setSQLObject($issues);
        }

        $clientIDArray = $this->getArgumentSecure('filterclientid', 'array');

        foreach ($clientIDArray as $clId) {
            try{
                $user = Shop::Get()->getUserService()->getUserByID($clId);
            } catch (Exception $e) {

            }
        }
        $clientIDArray = array_unique($clientIDArray);

        $datasource->getSQLObject()->addWhereArray($clientIDArray, 'userid');

        if (!$this->getArgumentSecure('filtershowclosed')) {
            $datasource->getSQLObject()->setDateclosed('0000-00-00 00:00:00');
        }

        $filterManagerID = $this->getArgumentSecure('filtermanagerid');
        if ($filterManagerID) {
            $datasource->getSQLObject()->setManagerid($filterManagerID);
        }

        $filterAuthorID = $this->getArgumentSecure('filterauthorid');
        if ($filterAuthorID) {
            $datasource->getSQLObject()->setAuthorid($filterAuthorID);
        }

        $filterNumber = $this->getArgumentSecure('filternumber');
        if ($filterNumber) {
            $datasource->getSQLObject()->addWhere('number', '%'.$filterNumber.'%', 'LIKE');
        }

        $filterName = $this->getArgumentSecure('filtername');
        if ($filterName) {
            $datasource->getSQLObject()->addWhere('name', '%'.$filterName.'%', 'LIKE');
        }

        $filterID = $this->getArgumentSecure('filterid');
        if ($filterID) {
            $datasource->getSQLObject()->addWhere('id', '%'.$filterID.'%', 'LIKE');
        }

        $filterCdateFrom = $this->getArgumentSecure('filtercdatefrom', 'date');
        if ($filterCdateFrom) {
            $datasource->getSQLObject()->addWhere('cdate', $filterCdateFrom, '>=');
        }

        $filterCdateTo = $this->getArgumentSecure('filtercdateto', 'date');
        if ($filterCdateTo) {
            $datasource->getSQLObject()->addWhere('cdate', $filterCdateTo.' 23:59:59', '<=');
        }

        // поиск по серийному номеру
        $filterProductSerial = $this->getControlValue('filterproductserial');
        if ($filterProductSerial) {
            $filterProductSerial = ConnectionManager::Get()->getConnectionDatabase()->escapeString($filterProductSerial);
            $query = "id IN (SELECT orderid FROM shoporderproduct WHERE serial LIKE '%".$filterProductSerial."%')";
            $datasource->getSQLObject()->addWhereQuery($query);
        }

        // поиск по названию товара
        $filterProductName = $this->getControlValue('filterproductname');
        if ($filterProductName) {
            $filterProductName = ConnectionManager::Get()->getConnectionDatabase()->escapeString($filterProductName);
            $query = "id IN (SELECT orderid FROM shoporderproduct WHERE productname LIKE '%".$filterProductName."%')";
            $datasource->getSQLObject()->addWhereQuery($query);
        }

        // поиск по номеру товара
        $filterProductID = $this->getControlValue('filterproductid');
        if ($filterProductID) {
            $filterProductID = ConnectionManager::Get()->getConnectionDatabase()->escapeString($filterProductID);
            $query = "id IN (SELECT orderid FROM shoporderproduct WHERE productid LIKE '%".$filterProductID."%')";
            $datasource->getSQLObject()->addWhereQuery($query);
        }

        // получаем данные для фильтров
        // данные надо получить до фильтрации
        $issueFilter = clone $datasource->getSQLObject();

        $filterWorkflowIDArray = $this->getArgumentSecure('workflowid', 'array');
        if ($filterWorkflowIDArray) {
            $datasource->getSQLObject()->addWhereArray($filterWorkflowIDArray, 'categoryid');
        }

        $filterStatusIDArray = $this->getArgumentSecure('statusid', 'array');
        if ($filterStatusIDArray) {
            $datasource->getSQLObject()->addWhereArray($filterStatusIDArray, 'statusid');
        }

        $table = new Shop_ContentTable($datasource);

        // заменяем для разукраски строк
        $table->setRow(new Shop_ContentTableRowOrders());

        $field = new Forms_ContentFieldControlLink('id', 'shop-admin-orders-control', 'id');
        $field->setName('#');
        $table->addField($field);

        $this->setValue('table', $table->render());
        $this->setValue('dataCount', $datasource->getSQLObject()->getCount());

        // получаем id всех отсортированных пользователей
        $connection = ConnectionManager::Get()->getConnectionDatabase();
        $q = $connection->query('SET group_concat_max_len = 9999999;');
        $sql = "SELECT GROUP_CONCAT(`id` SEPARATOR ';') as `id` FROM `users` WHERE `users`.`id` IN (SELECT `userid` FROM `shoporder` WHERE (" . $datasource->getSQLObject()->makeWhereString()."))";
        $q = $connection->query($sql);
        $r = $connection->fetch($q);
        if ($r) {
            $this->setValue('arrUserId', $r['id']);
        }

        $login = Shop::Get()->getSettingsService()->getSettingValue('turbosms-login');
        $pass = Shop::Get()->getSettingsService()->getSettingValue('turbosms-password');
        $sender = Shop::Get()->getSettingsService()->getSettingValue('turbosms-sender');
        if ($sender && $login && $pass) {
            $this->setValue('canSMS', true);
        }

        $mode = $this->getArgumentSecure('mode');
        if ($mode) {
            $this->_showIssueMode($mode);
        }

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
        $this->setValue('filterClientArray', $clientArray);

        // категории
        $categories = Shop::Get()->getShopService()->getWorkflowsActive(
        $this->getUser()
        );
        $categoryArray = array();
        while($x = $categories->getNext()){
            $categoryArray[] = array(
            'id' => $x->getId(),
            'name' => $x->getName(),
            'hidden' => $x->getHidden(),
            );
        }
        $this->setValue('categoryArray', $categoryArray);

        // статусы
        $statusesArray = array();
        $statuses = Shop::Get()->getShopService()->getStatusAll();
        $statuses->setCategoryid(0);
        while ($x = $statuses->getNext()) {
            if ($this->getUser()->isDenied('orders-category-'.$x->getCategoryid().'-view')) {
                continue;
            }

            $statusesArray[] = array(
            'id' => $x->getId(),
            'name' => $x->getName()
            );
        }

        $statusesCategoryArray = array();

        $statuses = Shop::Get()->getShopService()->getStatusAll();
        $statuses->addWhereQuery("categoryid IN (SELECT id FROM shopordercategory WHERE (hidden='0'))");
        while ($x = $statuses->getNext()) {
            try{
                if ($this->getUser()->isDenied('orders-category-'.$x->getCategoryid().'-view')) {
                    continue;
                }
                $statusesCategoryArray[$x->getCategory()->getName()][] = array(
                'id' => $x->getId(),
                'name' => $x->getName()
                );
            } catch (Exception $e) {

            }

        }

        $this->setValue('statusArray', $statusesArray);
        $this->setValue('statusCategoryArray', $statusesCategoryArray);

        // менеджеры
        $managers = Shop::Get()->getUserService()->getUsersManagers($this->getUser());
        $a = array();
        while ($x = $managers->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(true, 'lfm'),
            );
        }
        $this->setValue('managerArray', $a);

        // статусы заказов
        $block = Engine::GetContentDriver()->getContent('workflow-filter-block');
        $block->setValue('issueFilter', $issueFilter);
        $this->setValue('block_workflow_filter', $block->render());
    }

    /**
     * Отображение задач в виде заданном @param $mode
     */
    private function _showIssueMode($mode) {

        switch ($mode) {
            case 'gantt':
                $this->_setShowIssueBlock('gantt-index');
                break;
            case 'stage':
                $this->_setShowIssueBlock('funnel-index');
                break;
            case 'funnel':
                $this->_setShowIssueBlock('funnel-chart-index');
                break;
            case 'status':
                $this->_setShowIssueBlock('issue-status-index');
                break;
            case 'calendar':
                $this->_setShowIssueBlock('calendar-block');
                break;
            case 'mind':
                $this->_setShowIssueBlock('mind-index');
                break;
        }

    }

    /**
     * @param $contentid
     * @param $blockid
     */
    private function _setShowIssueBlock($contentid, $blockid = 'block_show_custom') {
        $datasource = $this->_getDatasource();
        $issues = clone $datasource->getSQLObject();
        $block = Engine::GetContentDriver()->getContent($contentid);
        $block->setValue('issue', $issues);
        $this->setValue($blockid, $block->render());
    }

    private $_datasource = null;

}