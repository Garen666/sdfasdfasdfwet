<?php
class todo_index extends Engine_Class {

    public function process() {
        $managerID = $this->getControlValue('managerid');
        if (!$managerID) {
            $managerID = $this->getUser()->getId();
            $this->setControlValue('managerid', $managerID);
        }

        // кто
        $manager = Shop::Get()->getUserService()->getUserByID($managerID);

        // список ролей
        $roleID = $this->getControlValue('roleid');
        if ($roleID) {
            $roleArray = array($roleID);
        } else {
            $titleArray = $manager->getRoleArray();
            $titleArray[] = -1;

            $role = RoleService::Get()->getRoleAll();
            $role->addWhereArray($titleArray, 'name');
            $roleArray = array(-1);
            while ($x = $role->getNext()) {
                $roleArray[] = $x->getId();
            }
        }

        // мои статусы
        $statuses = Shop::Get()->getShopService()->getStatusAll();
        $statuses->addWhereArray($roleArray, 'roleid');
        $statusIDArray = array(-1);
        while ($x = $statuses->getNext()) {
            $statusIDArray[] = $x->getId();
        }

        // список задач
        $issues = IssueService::Get()->getIssuesAll();
        $issues->addWhereArray($statusIDArray, 'statusid');
        $issues->setOrder('cdate', 'DESC');
        $a = array();
        $statisticArray = array();
        while ($x = $issues->getNext()) {
            @$statisticArray[$x->getStatusid()] ++;
            $statusNameArray[$x->getStatusid()] = array(
            'name' => $x->getStatus()->makeName(),
            'todo' => nl2br($x->getStatus()->getContent()),
            );

            try {
                $client = $x->getClient();
                $clientID = $client->getId();
                $clientName = $client->makeName();
                $clientURL = $client->makeURLEdit();
                $clientPhone = $client->getPhone();
                $clientEmail = $client->getEmail();
            } catch (Exception $e) {
                $clientName = false;
                $clientID = false;
                $clientURL = false;
                $clientPhone = false;
                $clientEmail = false;
            }

            $productArray = array();
            $ops = $x->getOrderProducts();
            while ($op = $ops->getNext()) {
                $productArray[] = array(
                'id' => $op->getId(),
                'name' => $op->getProductname(),
                'price' => $op->getProductprice(),
                'count' => $op->getProductcount(),
                'currency' => $op->getCurrency()->getSymbol(),
                );
            }

            // возможные варианты куда переходить заказу
            $nextStatusArray = array();
            try {
                $workflow = $x->getWorkflow();
                $workflowStatuses = $workflow->getStatuses();
                $workflowStatuses->setOnlyauto(0);
                while ($s = $workflowStatuses->getNext()) {
                    $tmp = new XShopOrderStatusChange();
                    $tmp->setCategoryid($workflow->getId());
                    $tmp->setElementfromid($x->getStatusid());
                    $tmp->setElementtoid($s->getId());
                    if ($tmp->select()) {
                        $nextStatusArray[$s->getId()] = $s->makeName();
                    }
                }
            } catch (Exception $e) {

            }

            // через какие статусы уже прошел заказ
            $historyArray = array();
            $change = new XShopOrderChange();
            $change->setOrderid($x->getId());
            $change->setKey('statusid');
            $change->setOrder('cdate', 'ASC');
            while ($c = $change->getNext()) {
                try {
                    $tmp = Shop::Get()->getShopService()->getStatusByID($c->getValue());
                    $historyArray[$tmp->getId()] = $tmp->getName();
                } catch (Exception $changeEx) {

                }
            }

            // комментарии
            $commentArray = array();
            $commentKey = 'shop-order-'.$x->getId();
            $comments = CommentsAPI::Get()->getComments($commentKey);
            while ($c = $comments->getNext()) {
                try {
                    $commentArray[] = array(
                    'content' => $c->getContent(),
                    'name' => Shop::Get()->getUserService()->getUserByID($c->getId_user())->getLogin(),
                    'cdate' => DateTime_Formatter::DateTimePhonetic($c->getCdate()),
                    );
                } catch (Exception $commentEx) {

                }
            }

            $a[$x->getStatusid()][] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(),
            'cdate' => DateTime_Formatter::DateISO8601($x->getCdate()),
            'url' => $x->makeURLEdit(),
            'clientName' => $clientName,
            'clientEmail' => $clientEmail,
            'clientPhone' => $clientPhone,
            'clientID' => $clientID,
            'clientURL' => $clientURL,
            'status' => $x->getStatus()->makeName(),
            'comment' => nl2br($x->getComments()),
            'productArray' => $productArray,
            'productSum' => $x->makeSum(),
            'paidSum' => $x->makeSumPaid(),
            'balanceSum' => $x->makeSumBalance(),
            'productSumCurrency' => $x->getCurrency()->getSymbol(),
            'nextStatusArray' => $nextStatusArray,
            'statusID' => $x->getStatusid(),
            'historyArray' => $historyArray,
            'commentArray' => $commentArray,
            );
        }
        $this->setValue('issueArray', $a);

        $this->setValue('statisticArray', $statisticArray);
        $this->setValue('statusNameArray', $statusNameArray);

        // список ролей
        $a = array();
        $role = RoleService::Get()->getRoleAll();
        while ($x = $role->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->getName(),
            );
        }
        $this->setValue('roleArray', $a);

        // список сотрудников с ролями
        $a = array();
        $manager = Shop::Get()->getUserService()->getUsersManagers($this->getUser());
        $manager->addWhere('post', '', '!=');
        while ($x = $manager->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(true, 'lfm'),
            );
        }
        $this->setValue('managerArray', $a);
    }

}