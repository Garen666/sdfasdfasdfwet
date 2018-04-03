<?php
class shop_payment_interkassa extends Engine_Class {

    public function process() {
        try {
            $ikShopID = Shop::Get()->getSettingsService()->getSettingValue('interkassa-shopid');
            $ikSecretKey = Shop::Get()->getSettingsService()->getSettingValue('interkassa-secretkey');

            $this->setValue('ikShopID', $ikShopID);

            $orderID = $this->getArgumentSecure('orderid');
            if ($orderID) {
                $order = Shop::Get()->getShopService()->getOrderByID($orderID);

                $this->setValue('orderID', $order->getId());
                $this->setValue('orderSum', $order->getSum());
                $this->setValue('orderCurrency', $order->getCurrency()->getSymbol());
            }

            $result = $this->getArgumentSecure('result');
            if ($result == 'result') {
                // принимаем платеж
                $orderID = $this->getArgument('ik_payment_id');
                $paymentState = $this->getArgument('ik_payment_state');
                $paymentAmount = $this->getArgument('ik_payment_amount');
                $paymentSignHash = $this->getArgument('ik_sign_hash');

                $status_data = $this->getArguments();
                $paymentSignHash2 = $status_data['ik_shop_id'].':'.
                $status_data['ik_payment_amount'].':'.
                $status_data['ik_payment_id'].':'.
                $status_data['ik_paysystem_alias'].':'.
                $status_data['ik_baggage_fields'].':'.
                $status_data['ik_payment_state'].':'.
                $status_data['ik_trans_id'].':'.
                $status_data['ik_currency_exch'].':'.
                $status_data['ik_fees_payer'].':'.
                $ikSecretKey;
                $paymentSignHash2 = strtoupper(md5($paymentSignHash2));

                // если все успешно - принимаем деньги за заказ
                if ($paymentSignHash == $paymentSignHash2
                && $paymentState == 'success') {
                    Shop::Get()->getShopService()->payOrder(
                    $orderID,
                    $paymentAmount,
                    true // не проверять ACL
                    );
                }

                exit();
            } elseif ($result == 'success') {
                $this->setValue('message', 'success');

                // выдаем ссылки на скачивание товаров
                try {
                    $orderID = $this->getArgument('ik_payment_id');
                    $order = Shop::Get()->getShopService()->getOrderByID($orderID);

                    // если статус заказа позволяет качать товары
                    if ($order->getStatus()->getDownloadable()) {
                        $orderProducts = $order->getOrderProducts();
                        $a = array();
                        while ($op = $orderProducts->getNext()) {
                            try {
                                $url = Shop::Get()->getShopService()->makeProductDownloadURL($op->getProduct());
                                $url = Engine::Get()->getProjectURL().'/'.$url;

                                $a[] = array(
                                'name' => $op->getProductname(),
                                'url' => $url,
                                );
                            } catch (Exception $e) {

                            }
                        }
                        $this->setValue('downloadArray', $a);
                    }
                } catch (Exception $e) {

                }
            } elseif ($result == 'fail') {
                $this->setValue('message', 'fail');
            }

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::GetQuery()->setContentNotFound();
        }
    }

}