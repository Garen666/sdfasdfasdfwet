<?php
class order_menu extends Engine_Class {

    /**
     * @return ShopOrder
     */
    private function _getOrder() {
        return $this->getValue('order');
    }

    public function process() {
        $order = $this->_getOrder();

        $urlFrom = @$_SERVER['HTTP_REFERER'];
        if ($urlFrom && @$_SESSION['orderRefererID'] != $order->getId()) {
            $_SESSION['orderRefererURL'] = $urlFrom;
            $_SESSION['orderRefererID'] = $order->getId();
        }
        $this->setValue('urlBack', @$_SESSION['orderRefererURL']);

        // текущий авторизированный пользователь
        $user = $this->getUser();

        // проверка прав пользователя на просмотр/управление этим заказом
        if (!Shop::Get()->getShopService()->isOrderViewAllowed($order, $user)) {
            throw new ServiceUtils_Exception();
        }

        if ($this->getArgumentSecure('watch')) {
            try {
                if ($this->getArgumentSecure('watchvalue')) {
                    Shop::Get()->getShopService()->addOrderEmployer($order, $user);
                } else {
                    Shop::Get()->getShopService()->deleteOrderEmployer($order, $user);
                }
            } catch (ServiceUtils_Exception $se) {

            }
        }

        $canEdit = Shop::Get()->getShopService()->isOrderChangeAllowed($order, $user);
        $this->setValue('canEdit', $canEdit);

        // режим box?
        $isBox = Engine::Get()->getConfigFieldSecure('project-box');
        $this->setValue('box', $isBox);

        $this->setValue('orderid', $order->getId());
        $this->setValue('orderNumber', $order->getNumber());
        $name = htmlspecialchars($order->getName());
        if (!$name) {
            $name = $order->getNumber();
        }
        $this->setValue('orderName', $name);
        $this->setValue('number', $order->getNumber());

        $description = '';

        // последний комментарий
        $commentKey = 'shop-order-'.$order->getId();
        $comments = CommentsAPI::Get()->getComments($commentKey);
        $comments->setLimitCount(1);
        $comments->setOrder('id', 'DESC');
        if ($x = $comments->getNext()) {
            try {
                $description .= Shop::Get()->getUserService()->getUserByID($x->getId_user())->makeName(true, 'lfm');
                $description .= ': ';
            } catch (Exception $commentEx) {

            }
            try {
                $description .= StringUtils_Limiter::LimitWordsSmart(strip_tags($x->getContent()), 50);
                if ($description) {
                    $description .= nl2br("\n");
                }
            } catch (Exception $commentEx) {

            }
        }

        try {
            $client = $order->getClient();

            if ($client->getImage()) {
                $this->setValue('image', $client->makeImageThumb());
                $this->setValue('bigImage', '/media/shop/'.$client->getImage());
            }

            $description .= $client->makeName().'. ';
        } catch (Exception $e) {

        }

        try {
            if ($order->getStatus()->getPrepayed() || $order->getStatus()->getPayed()) {
                $balance = $order->makeSumBalance();
                if ($balance < 0) {
                    $description .= 'Долг: '.$balance.' '.$order->getCurrency()->getSymbol().' ';
                } elseif ($balance > 0) {
                    $description .= 'Переплата: '.$balance.' '.$order->getCurrency()->getSymbol().' ';
                }
            }
        } catch (Exception $e) {

        }

        $this->setValue('description', $description);

        $isWatcher = Shop::Get()->getShopService()->isEmployer($order, $user);
        $this->setValue('isWatcher', $isWatcher);
        $this->setValue('urlWatch', Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('watch' => 1, 'watchvalue' => !$isWatcher)));

        if ($isBox) {
            try {
                $project = $order->getParent();
                $this->setValue('projectID', $project->getId());
                $this->setValue('projectName', $project->makeName());
                $this->setValue('projectURL', $project->makeURLEdit());
            } catch (Exception $projectEx) {

            }

            // количество открытых задач
            $issues = IssueService::Get()->getIssuesAll($this->getUser());
            $issues->setParentid($order->getId());
            $issues->setDateclosed('0000-00-00 00:00:00');
            $this->setValue('issueCount', $issues->getCount());
        }

        // дополнительные табы от модулей
        $moduleTabArray = Shop_ModuleLoader::Get()->getOrderTabArray();
        foreach ($moduleTabArray as $k => $moduleTabInfo) {
            $moduleTabArray[$k]['url'] = Engine::GetLinkMaker()->makeURLByContentIDParam($moduleTabInfo['contentID'], $order->getId());
        }
        $this->setValue('moduleTabArray', $moduleTabArray);

        $this->setValue('isIssue', $order->getIssue());
    }

}