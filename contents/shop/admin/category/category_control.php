<?php
class category_control extends Engine_Class {

    public function process() {
        try {
            $form = new Forms_ContentForm(new Datasource_Category());
            PackageLoader::Get()->import('CKFinder');
            $categoryID = $this->getArgumentSecure('key');
            try {
                $category = Shop::Get()->getShopService()->getCategoryByID($categoryID);

                if ($category->getChilds()->getCount()
                || $category->getProducts()->getCount()
                ) {
                    $form->denyDelete();
                }
            } catch (Exception $e) {

            }

            if (!$categoryID) {
                // делаем поле ID редактируемым
                $form->getDataSource()->getField('id')->setEditable(true);
                $form->getDataSource()->getField('id')->setName('Код категории (не обязательно)');
            } else {
                $va = $form->getField('parentid')->getValidatorsArray();
                $va[0]->setDisallowID($categoryID);
            }

            $this->setValue('form', $form->render($categoryID));
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }

    }

}