<?php
class shop_product_carousel extends Engine_Class {

    /**
     * @return ShopProduct
     */
    private function _getProducts() {
        $x = $this->getValue('products');
        $x->setHidden(0);
        $x->setDeleted(0);
        $x = Shop::Get()->getShopService()->setProductsDateLifeFilter($x);
        return $x;
    }

    public function process() {
        $admin = false;
        try {
            if ($this->getUser()->isAdmin()) {
                $admin = true;
            }
        } catch (Exception $e) {

        }

        $products = $this->_getProducts();

        $a = array();
        while ($p = $products->getNext()) {
            $info = $p->makeInfoArray();
            $a[] = $info;
        }
        $this->setValue('productsArray', $a);
    }

}