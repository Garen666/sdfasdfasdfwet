<?php
class block_feedback extends Engine_Class {

    public function process() {
        // прием обратной связи
        if ($this->getArgumentSecure('feedback')) {
            try {
                if ($this->getControlValue('ajs') != 'ready') {
                    throw new ServiceUtils_Exception('bot');
                }

                try {
                    $user = $this->getUser();
                } catch (Exception $e) {
                    $user = Shop::Get()->getUserService()->addUserClient(
                    $this->getControlValue('fbname'),
                    false,
                    false,
                    $this->getControlValue('fbemail'),
                    $this->getControlValue('fbphone'),
                    false, // address
                    false, // company
                    false, // time
                    false, // comment admin
                    'feedback', // group type
                    $this->getControlValue('fbnamelast'),
                    $this->getControlValue('fbnamemiddle')
                    );
                }
                $fullname =  $this->getControlValue('fbnamelast')." ".$this->getControlValue('fbname')." ".$this->getControlValue('fbnamemiddle');
                $url = Engine::Get()->getProjectURL().Engine_URLParser::Get()->getTotalURL();

                Shop::Get()->getFeedbackService()->addFeedback(
                $fullname,
                $this->getControlValue('fbphone'),
                $this->getControlValue('fbemail'),
                $this->getControlValue('fbmessage'),
                $user,
                $url
                );

                // добавляем комментарий в заказ
                $orders = Shop::Get()->getShopService()->getOrdersAll();
                $orders->setUserid($user->getId());
                $orders->setDateclosed('0000-00-00 00:00:00');
                $ok = false;
                while ($x = $orders->getNext()) {
                    $ok = true;
                    Shop::Get()->getShopService()->addOrderComment($x, $user, "Клиент написал письмо: ".$this->getControlValue('fbmessage')."<br />Ф.И.О.: ".$fullname."<br />Телефон: ".$this->getControlValue('fbphone')."<br /> Со страницы: <a href=\"".$url."\">".$url."</a>", false, false);
                    break;
                }

                if (!$ok) {
                    // создаем новый заказ
                    $order = Shop::Get()->getShopService()->makeOrderEmpty();
                    $order->setUserid($user->getId());
                    $order->setClientname($user->makeName(false, 'lfm'));
                    $order->setClientphone($user->getPhone());
                    $order->setClientemail($user->getEmail());
                    $order->setClientaddress($user->getAddress());
                    $order->update();

                    Shop::Get()->getShopService()->addOrderComment($order, $user, "Клиент написал письмо: ".$this->getControlValue('fbmessage')."<br />Ф.И.О.: ".$fullname."<br />Телефон: ".$this->getControlValue('fbphone')."<br /> Со страницы: <a href=\"".$url."\">".$url."</a>", false, false);
                }

                $this->setValue('feedbackmessage', 'ok');
            } catch (ServiceUtils_Exception $e) {
                $this->setValue('feedbackmessage', 'error');
                $this->setValue('feedbackArray', $e->getErrorsArray());
            }
        }

        // заполняем по умолчанию данными форму feedback'a
        try {
            $u = $this->getUser();

            if (!$this->getValue('feedbackmessage')) {
                $this->setControlValue('fbname', $u->getName());
                $this->setControlValue('fbnamelast', $u->getNamelast());
                $this->setControlValue('fbnamemiddle', $u->getNamemiddle());
                $this->setControlValue('fbphone', $u->getPhone());
                $this->setControlValue('fbemail', $u->getEmail());
            }
        } catch (Exception $e) {

        }
    }

}