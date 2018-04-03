<?php
class report_orderprobation extends Engine_Class {

    public function process() {
        try{
            if ($this->getArgumentSecure('ok')) {
                $dateFrom = $this->getArgumentSecure('datefrom', 'date');
                $dateTo = $this->getArgumentSecure('dateto', 'date');
            } else {
                // даты платежей по умолчанию
                $dateFrom = DateTime_Object::Now()->setFormat('Y-m-01')->__toString();
                $this->setControlValue('datefrom', $dateFrom);

                $dateTo = DateTime_Object::Now()->setFormat('Y-m-d')->__toString();
                $this->setControlValue('dateto', $dateTo);
            }

            $payments = new XFinanceProbation();
            $payments->addWhere('pdate', $dateFrom, '>=');
            $payments->addWhere('pdate', $dateTo, '<=');
            $payments->setOrder('pdate', 'DESC');

            $reportArray = array();
            $balanceSum = 0;

            while ($payment = $payments->getNext()) {
                try{
                    $currency = SHop::Get()->getCurrencyService()->getCurrencyByID($payment->getCurrencyid());
                } catch (Exception $e) {
                    $currency = false;
                }

                try{
                    $order = Shop::Get()->getShopService()->getOrderByID($payment->getOrderid());
                } catch (Exception $e) {
                    $order = false;
                }

                try{
                    $user = Shop::Get()->getUserService()->getUserByID($payment->getManagerid());
                } catch (Exception $e) {
                    $user = false;
                }

                $reportArray[] = array(
                    'id' => $payment->getId(),
                    'pdate' => $payment->getPdate(),
                    'amount' => $payment->getAmount(),
                    'currency' => $currency ? $currency->getName():false,
                    'orderId' => $payment->getOrderid(),
                    'orderName' => $order ? $order->makeName(false):'#'.$payment->getOrderid(),
                    'orderUrl' => $order ? $order->makeURLEdit():false,
                    'userId' => $payment->getManagerid(),
                    'userName' => $user ? $user->makeName(false, 'lfm'):'#'.$payment->getManagerid(),
                    'userUrl' => $user ? $user->makeURLEdit():false
                );
                if ($currency) {
                    $balanceSum+= Shop::Get()->getCurrencyService()->convertCurrency($payment->getAmount(), $currency, Shop::Get()->getCurrencyService()->getCurrencySystem());
                }
            }

            $this->setValue('currencyName', Shop::Get()->getCurrencyService()->getCurrencySystem()->getName());
            $this->setValue('reportArray', $reportArray);
            $this->setValue('balanceSum', $balanceSum);
        } catch (Exception $e) {
            Engine::Get()->getRequest()->setContentNotFound();
        }



    }

}