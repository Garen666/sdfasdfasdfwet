<?php
class issue_smart_closed_ajax extends Engine_Class {

    public function process() {

        try {
            $orderId = $this->getArgumentSecure('orderId');
            $onlycomment = $this->getArgumentSecure('onlycomment');
            $order = Shop::Get()->getShopService()->getOrderByID($orderId);

            $return = 'comment';

            if (!$onlycomment) {
                if ($order->isClosed()) {
                    try{
                        $statusDefault = $order->getWorkflow()->getStatusDefault() ;
                        Shop::Get()->getShopService()->updateOrderStatus(Shop::Get()->getUserService()->getUser(), $order, $statusDefault->getId());
                    } catch (Exception $e) {

                    }

                    $order->setDateclosed('0000-00-00 00:00:00');
                    $order->update();
                    $return = 'open';
                } else {
                    IssueService::Get()->closeIssue($order);
                    $return = 'closed';
                }

            }


            if ($this->getArgumentSecure('comment')) {
                Shop::Get()->getShopService()->addOrderComment($order, $this->getUser(), $this->getArgumentSecure('comment'));
            }

            echo json_encode($return);
            exit;
        } catch (Exception $e) {
            echo json_encode('exception');
            exit;
        }
    }

}