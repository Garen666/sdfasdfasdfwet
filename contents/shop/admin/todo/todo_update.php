<?php
class todo_update extends Engine_Class {

    public function process() {
        try {
            $order = Shop::Get()->getShopService()->getOrderByID(
            $this->getArgument('issueid')
            );

            $status = Shop::Get()->getShopService()->getStatusByID(
            $this->getArgument('statusid')
            );

            Shop::Get()->getShopService()->updateOrderStatus(
            $this->getUser(),
            $order,
            $status->getId()
            );

            print 'success';
            exit();
        } catch (Exception $e) {
            print $e;
            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}