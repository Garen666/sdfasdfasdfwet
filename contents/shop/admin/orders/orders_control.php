<?php
class orders_control extends Engine_Class {

    public function process() {
        ini_set('max_input_vars', 10000);

        PackageLoader::Get()->import('CommentsAPI');

        try {
            // получаем заказ
            $order = Shop::Get()->getShopService()->getOrderByID(
            $this->getArgument('id')
            );

            // текущий авторизированный пользователь
            $user = $this->getUser();

            // проверка прав пользователя на просмотр/управление этим заказом
            if (!Shop::Get()->getShopService()->isOrderViewAllowed($order, $user)) {
                throw new ServiceUtils_Exception();
            }

            // referer url
            $referer = @$_SERVER['HTTP_REFERER'];
            if (!preg_match('#admin/shop/orders/[\d]+#iusD', $referer, $r)) {
                @session_start();
                @$_SESSION['order-referer'] = $referer;
            }

            $canEdit = Shop::Get()->getShopService()->isOrderChangeAllowed($order, $user);
            $this->setValue('canEdit', $canEdit);

            $menu = Engine::GetContentDriver()->getContent('shop-admin-order-menu');
            $menu->setValue('order', $order);
            $menu->setValue('selected', 'view');
            $this->setValue('block_menu', $menu->render());

            // режим box?
            $isBox = Engine::Get()->getConfigFieldSecure('project-box');
            $this->setValue('box', $isBox);

            $block_info = Engine::GetContentDriver()->getContent('shop-admin-orders-control-block-info');
            $this->setValue('block_info', $block_info->render());

            $this->setValue('isIssue', $order->getIssue());

            if (!$order->getIssue()) {
                $block_product_list = Engine::GetContentDriver()->getContent('shop-admin-orders-control-block-product-list');
                $this->setValue('block_product_list', $block_product_list->render());
            }

            $block_comment = Engine::GetContentDriver()->getContent('shop-admin-orders-control-block-comment');
            $this->setValue('block_comment', $block_comment->render());

            if ($this->getArgumentSecure('message' == 'ok')) {
                $this->setValue('message', 'ok');

                // редирект
                header('Location: '.$order->makeURLEdit().'?message=ok');
            }

            // получаем заказ
            $order = Shop::Get()->getShopService()->getOrderByID(
            $this->getArgument('id')
            );

            // получаем все товары в заказе
            $orderproducts = $order->getOrderProducts();

            $a = array();
            $clientId = $order->getUserid();

            while ($x = $orderproducts->getNext()) {
                // информация о наличии в поставщиках
                try {
                    // productid может быть не действительный,
                    // поэтому заключаем в try-catch

                    $product = $x->getProduct();


                    $productCount = $product->getCountWithDivisibility($x->getProductcount());

                } catch (Exception $e) {
                    $productCount = $x->getProductcount();
                }

                try {
                    $sum = $x->makeSum($order->getCurrency());
                } catch (Exception $priceEx) {
                    $sum = 0;
                }

                // запись в тексте, вместо кода товара, код поставщика, если поставщик - клиент
                $codesupplier = 0;


                // товары
                @$a[] = array(
                'id' => $x->getId(),
                'name' => htmlspecialchars($x->getProductname()),
                'productid' => $x->getProductid(),
                'count' => (float) $productCount,
                'price' => $x->getProductprice(),
                'sum' => $sum,
                'currencySym' => $x->getCurrency()->getSymbol(),
                'comment' => htmlspecialchars($x->getComment()),
                'categoryname' => htmlspecialchars($x->getCategoryname()),
                'serial' => htmlspecialchars($x->getSerial()),
                'warranty' => htmlspecialchars($x->getWarranty()),
                );
            }

            $this->setValue('productsArray', $a);

            // заголовок страницы
            Engine::GetHTMLHead()->setTitle($order->makeName());




                $this->setValue('totalSum', $order->getSum());

            $this->setValue('currency', $order->getCurrency()->getSymbol());
            $this->setValue('orderName', $order->makeName());
            $this->setValue('discountSum', $order->getDiscountsum());

            // кнопка "следить"
            $cuser = $this->getUser();

            if ($this->getArgumentSecure('watch')) {
                try {
                    if ($this->getArgumentSecure('watchvalue')) {
                        Shop::Get()->getShopService()->addOrderEmployer($order, $cuser);
                    } else {
                        Shop::Get()->getShopService()->deleteOrderEmployer($order, $cuser);
                    }
                } catch (ServiceUtils_Exception $se) {

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
