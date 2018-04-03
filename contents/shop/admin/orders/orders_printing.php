<?php

class orders_printing extends Engine_Class {

    public function process() {

        try {
            $order = Shop::Get()->getShopService()->getOrderByID(
                    $this->getArgument('id')
            );

            // получаем валюту заказа
            $currencyDefault = $order->getCurrency();

            $a = array();
            $orderproducts = $order->getOrderProducts();
            while ($op = $orderproducts->getNext()) {

                if ($op->getProductid()) {

                    try {
                        $code = $op->getProduct()->makeCode();
                    } catch (Exception $e) {
                        $code = $op->getProductid();
                    }

                    $a[] = array(
                        'name' => $op->getProductname(),
                        'count' => $op->getProductcount(),
                        'price' => $op->makePrice($currencyDefault),
                        'productid' => $code,
                        'sum' => $op->makeSum($currencyDefault),
                        'comment' => $op->getComment(),
                    );
                }
            }

            $this->setValue('basketsArray', $a);
            $this->setValue('clientname', htmlspecialchars($order->getClientname()));
            $this->setValue('clientemail', htmlspecialchars($order->getClientemail()));
            $this->setValue('clientphone', htmlspecialchars($order->getClientphone()));
            $this->setValue('clientaddress', htmlspecialchars($order->getClientaddress()));
            $this->setValue('clientcontacts', nl2br(htmlspecialchars($order->getClientcontacts())));
            $this->setValue('comments', nl2br(htmlspecialchars($order->getComments())));
            $this->setValue('date', DateTime_Formatter::DateTimeRussianGOST($order->getCdate()));
            $this->setValue('orderid', $order->getId());
            $this->setValue('shopname', Shop::Get()->getSettingsService()->getSettingValue('shop-name'));
            $phones = trim(strip_tags(Shop::Get()->getSettingsService()->getSettingValue('header-phone')));
            $phones = explode(',', $phones);
            $this->setValue('shopfhones', $phones);


            // сумма и валюта заказа
            $this->setValue('ordersum', $order->getSum()); // c учетом доставки
            $this->setValue('discountSum', $order->getDiscountsum()); // скидка
            $this->setValue('ordercurrency', $currencyDefault->getSymbol());
        } catch (Exception $e) {
             $this->setValue('message', 'error');
            
        }
    }

}
