<?php
class orders_delete extends Engine_Class {

    public function process() {
        try {
            $order = Shop::Get()->getShopService()->getOrderByID(
            $this->getArgument('id')
            );

            $user = $this->getUser();

            $this->setValue('orderid', $order->getId());

            Engine::GetHTMLHead()->setTitle('Удаление заказа #'.$order->getId());

            // проверка прав пользователя на просмотр/управление этим заказом
            if (!Shop::Get()->getShopService()->isOrderViewAllowed($order, $user)) {
                throw new ServiceUtils_Exception();
            }

            $menu = Engine::GetContentDriver()->getContent('shop-admin-order-menu');
            $menu->setValue('order', $order);
            $menu->setValue('selected', 'delete');
            $this->setValue('block_menu', $menu->render());

            if ($this->getControlValue('ok')) {
                try {
                    Shop::Get()->getShopService()->deleteOrder($order);
                    $this->setValue('orderReferer', @$_SESSION['order-referer']);

                    $this->setValue('message', 'ok');
                } catch (ServiceUtils_Exception $e) {
                    $this->setValue('message', 'error');
                    $this->setValue('errorsArray', $e->getErrorsArray());
                }
            }

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}