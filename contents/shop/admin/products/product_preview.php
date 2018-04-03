<?php
class product_preview extends Engine_Class {

    public function process() {
        try {
            $product = Shop::Get()->getShopService()->getProductByID(
            $this->getArgument('id')
            );

            $this->setValue('id', $product->getId());
            $this->setValue('articul', $product->getArticul());
            $this->setValue('name', $product->makeName());
            $this->setValue('url', $product->makeURLEdit());
            $this->setValue('description', $product->makeCharacteristicsString());
            if ($product->getImage()) {
                $this->setValue('image', $product->makeImageThumb(200, 200));
            }

            $this->setValue('price', $product->getPrice());
            $this->setValue('pricebase', $product->getPricebase());

            try {
                $this->setValue('currency', $product->getCurrency()->getSymbol());
            } catch (Exception $e) {

            }

            $this->setValue('urlBarcode', $product->makeURLBarcode());

        } catch (Exception $e) {
            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}