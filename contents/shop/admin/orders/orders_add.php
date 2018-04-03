<?php
class orders_add extends Engine_Class {

    public function process() {
        try {
            if ($this->getUser()->isDenied('orders-add')) {
                throw new ServiceUtils_Exception();
            }

            if (Engine::Get()->getConfigFieldSecure('project-box')) {
                $urlRedirect = Engine::GetLinkMaker()->makeURLByContentID('issue-add');
                header('Location: '.$urlRedirect);
            	exit();
            }

            $order = Shop::Get()->getShopService()->makeOrderEmpty();

            $urlRedirect = $order->makeURLEdit();
            $this->setValue('urlredirect', $urlRedirect);

            header('Location: '.$urlRedirect);
        } catch (Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}