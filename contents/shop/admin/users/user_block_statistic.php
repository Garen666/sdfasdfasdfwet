<?php
class user_block_statistic extends Engine_Class {

    /**
     * @return User
     */
    private function _getUser() {
        return $this->getValue('user');
    }

    public function process() {
        $user = $this->_getUser();

        $this->setValue('userID', $user->getId());

        // кто автор
        try {
            $author = $user->getAuthor();
            $this->setValue('authorName', $author->makeName());
            $this->setValue('authorURL', $author->makeURLEdit());
            $this->setValue('authorId', $author->getId());
        } catch (Exception $e) {

        }

        // список контактов по которым собираем статистику
        $userIDArray = array($user->getId());
        if ($user->getTypesex() == 'company' && $user->getCompany()) {
            $other = Shop::Get()->getUserService()->getUsersAll();
            $other->setCompany($user->getCompany());
            while ($x = $other->getNext()) {
                $userIDArray[] = $x->getId();
            }
        }

        // статистика
        $orders = Shop::Get()->getShopService()->getOrdersAll($this->getUser());
        $orders->addWhereArray($userIDArray, 'userid');
        $totalOrdersIn = 0;
        $totalOrdersOut = 0;
        $totalSumIn = 0;
        $totalSumOut = 0;
        $totalSumPayed = 0;
        $totalProduct = 0;
        $currencySystem = Shop::Get()->getCurrencyService()->getCurrencySystem();
        while ($x = $orders->getNext()) {

            try {
                $totalSum = Shop::Get()->getCurrencyService()->convertCurrency(
                $x->getSum(),
                $x->getCurrency(),
                $currencySystem
                );

                if ($x->getOutcoming()) {
                    $totalSumOut += $totalSum;
                    $totalOrdersOut ++;

                    if ($x->getStatus()->getPayed() || $x->getStatus()->getPrepayed()) {
                        $totalSumPayed += $totalSum;
                    }
                } else {
                    $totalSumIn += $totalSum;
                    $totalOrdersIn ++;
                    $totalProduct += $x->getOrderProductsCount($x->getId());

                    if ($x->getStatus()->getPayed() || $x->getStatus()->getPrepayed()) {
                        $totalSumPayed -= $totalSum;
                    }
                }
            } catch (Exception $ex) {

            }
        }

        $this->setValue('totalOrdersIn', $totalOrdersIn);
        $this->setValue('totalOrdersOut', $totalOrdersOut);
        $totalOrder = $totalOrdersIn + $totalOrdersOut;
        $this->setValue('totalOrder', $totalOrder);

        $this->setValue('totalProduct', $totalProduct);

        $this->setValue('totalSumIn', $totalSumIn);
        $this->setValue('totalSumOut', $totalSumOut);

        // статистика (Создал заказов)
        $orders = Shop::Get()->getShopService()->getOrdersAll($this->getUser());
        $orders->addWhereArray($userIDArray, 'authorid');
        $createOrderCount = 0;
        $createOrderSum = 0;
        while ($x = $orders->getNext()) {

            $createOrderCount++;
            $createOrderSum += Shop::Get()->getCurrencyService()->convertCurrency(
            $x->getSum(),
            $x->getCurrency(),
            $currencySystem
            );
        }
        $this->setValue('createOrderSum', $createOrderSum);
        $this->setValue('createOrderCount', $createOrderCount);

        $this->setValue('totalCurrency', $currencySystem->getSymbol());

        $callbacks = Shop::Get()->getCallbackService()->getCallbackAll();
        $callbacks->addWhereArray($userIDArray, 'userid');
        $this->setValue('totalCallback', $callbacks->getCount());

        $feedbacks = Shop::Get()->getFeedbackService()->getFeedbackAll();
        $feedbacks->addWhereArray($userIDArray, 'userid');
        $this->setValue('totalFeedback', $feedbacks->getCount());

        $comments = Shop::Get()->getShopService()->getProductCommentsAll();
        $comments->addWhereArray($userIDArray, 'userid');
        $this->setValue('totalComment', $comments->getCount());

        $this->setValue('lastAdate', DateTime_Formatter::DateTimePhonetic($user->getAdate()));
        $this->setValue('lastIP', $user->getIp());

        // информация о платежах
        if (Shop_ModuleLoader::Get()->isImported('finance')) {
            $payments = new FinancePayment();
            $payments->addWhereArray($userIDArray, 'clientid');
            $sumIn = 0;
            $sumOut = 0;
            $cntIn = 0;
            $cntOut = 0;
            while ($x = $payments->getNext()) {
                if ($x->getAmountbase() > 0) {
                    $sumIn += $x->getAmountbase();
                    $cntIn ++;
                } else {
                    $sumOut += $x->getAmountbase();
                    $cntOut ++;
                }
            }

            $sumIn = round($sumIn, 2);
            $sumOut = round($sumOut, 2);

            $this->setValue('paymentInCount', $cntIn);
            $this->setValue('paymentOutCount', $cntOut);

            $this->setValue('paymentInSum', $sumIn);
            $this->setValue('paymentOutSum', $sumOut);

            // баланс = сумма входящих платежей
            // - сумма входящих заказов
            // + сумма исходящих заказов
            // + сумма исходящих платежей

            //$balance = $sumIn - $totalSumIn + $totalSumOut + $sumOut;
            $balance = $sumIn + $sumOut + $totalSumPayed;
            $this->setValue('balance', $balance);
            $this->setValue('balanceColor', ($balance >= 0)?'green':'red');
        }

        if (Engine::Get()->getConfigFieldSecure('project-box')) {
            $this->setValue('box', true);

            // last events (one month)
            $events = $user->getEvents($user->getTypesex() == 'company');
            $events->setOrder('cdate', 'DESC');
            $events->setHidden(0);
            $events->setLimitCount(50);
            $ratingSum = 0;
            $ratingCount = 0;
            while ($x = $events->getNext()) {
                if ($x->getRating() > 0) {
                    $ratingCount ++;
                    $ratingSum += $x->getRating();
                }
            }

            if ($ratingCount > 0) {
                $this->setValue('rating', round($ratingSum / $ratingCount));
                $this->setValue('ratingValue', round($ratingSum / $ratingCount, 2));
            }
        }
    }

    private function _makeBalance() {
        // баланс = сумма входящих платежей
        // - сумма входящих заказов
        // + сумма исходящих заказов
        // - сумма исходящих платежей
    }

}