<?php
class products_icon_control extends Engine_Class {

    public function process() {
        try {
            $form = new Forms_ContentForm(new Datasource_ProductIcon());
            $ID = $this->getArgumentSecure('id');
            if($ID)
                $form->denyInsert();
            $this->setValue('form', $form->render($ID));
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }

    }

}