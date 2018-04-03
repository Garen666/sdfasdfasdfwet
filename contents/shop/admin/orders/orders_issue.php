<?php
class orders_issue extends Engine_Class {

    public function process() {
        try {
            $order = Shop::Get()->getShopService()->getOrderByID(
            $this->getArgument('id')
            );

            $user = $this->getUser();

            $this->setValue('orderid', $order->getId());
            $this->setValue('orderName', $order->makeName());

            Engine::GetHTMLHead()->setTitle('Задачи '.$order->makeName());

            // проверка прав пользователя на просмотр/управление этим заказом
            if (!Shop::Get()->getShopService()->isOrderViewAllowed($order, $user)) {
                throw new ServiceUtils_Exception();
            }

            $menu = Engine::GetContentDriver()->getContent('shop-admin-order-menu');
            $menu->setValue('order', $order);
            $menu->setValue('selected', 'issue');
            $this->setValue('block_menu', $menu->render());

            // блок быстрого добавления задачи
            $block = Engine::GetContentDriver()->getContent('issue-add-quick');
            $block->setValue('projectid', $order->getId());
            if (!$this->getArgumentSecure('newmanagerid')) {
                $block->setControlValue('newmanagerid', $order->getManagerid());
            }
            $this->setValue('block_issue_add_quick', $block->render());

            // задачи
            $issues = IssueService::Get()->getIssuesAll($user);
            $issues->setParentid($order->getId());

            $list = Engine::GetContentDriver()->getContent('issue-list');
            try {
                $this->getArgument('filtershowclosed');
            } catch (Exception $e) {
                Engine::GetURLParser()->setArgument('filtershowclosed', true);
            }
            $list->setValue('issues', $issues);
            $this->setValue('block_issue', $list->render());

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}