<?php
class smarty_workflow_simple extends Engine_Class {

    public function process() {

        try{
            $orderId = $this->getArgument('orderId');
            $order = Shop::Get()->getShopService()->getOrderByID($orderId);

            if ($order->getNumber()) {
                $this->setValue('number', $order->getNumber());
            } else {
                $this->setValue('number', $order->getId());
            }
            $this->setValue('comments', $this->_formatComment($order->getComments()));

            try{
                $client = $order->getClient();
                $this->setValue('clientId', $client->getId());
                $this->setValue('clientName', $client->makeName(false));
                $this->setValue('clientUrl', $client->makeURLEdit());

            } catch (Exception $e2) {

            }


            try{
                $manager = $order->getManager();
                $this->setValue('managerId', $manager->getId());
                $this->setValue('managerName', $manager->makeName(false, 'lfm'));
                $this->setValue('managerUrl', $manager->makeURLEdit());

            } catch (Exception $e2) {

            }

            $this->setValue('orderName', $order->getName());
            $this->setValue('orderId', $order->getId());
            $this->setValue('orderUrl', $order->makeURLEdit());
            $this->setValue('isClosed', $order->isClosed());

            //все комментарии
            $commentKey = 'shop-order-'.$order->getId();
            $comments = CommentsAPI::Get()->getComments($commentKey);
            $commentArray = array();
            while ($x = $comments->getNext()) {
                $commentArray[] = $x->getContent();
            }
            $this->setValue('commentArray', $commentArray);

            $this->setValue('commentTemplateArray', Shop::Get()->getShopService()->getCommentTemplatesArray());
        } catch (Exception $e) {

        }
    }

    private function _formatComment($text) {
        PackageLoader::Get()->import('TextProcessor');
        $processor = new TextProcessor_ActionTextToHTML();
        return $processor->process($text);
    }

}