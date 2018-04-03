<?php
class products_history extends Engine_Class {

    public function process() {
        try {
            $product = Shop::Get()->getShopService()->getProductByID(
            $this->getArgument('id')
            );

            $this->setValue('productid', $product->getId());
            $this->setValue('name', $product->getName());
            Engine::GetHTMLHead()->setTitle('Товар #'.$product->getId());

            $comments = CommentsAPI::Get()->getComments('shop-history-product-'.$product->getId());
            $a = array();
            while ($x = $comments->getNext()) {
                try {
                    $user = Shop::Get()->getUserService()->getUserByID($x->getId_user())->makeInfoArray();
                } catch (Exception $e) {
                    $user = false;
                }

                $a[] = array(
                'cdate' => $x->getCdate(),
                'user' => $user,
                'content' => nl2br(htmlspecialchars($x->getContent())),
                );
            }
            $this->setValue('activityArray', $a);

            $menu = Engine::GetContentDriver()->getContent('shop-admin-products-menu');
            $menu->setValue('selected', 'history');
            $this->setValue('menu', $menu->render());
        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}