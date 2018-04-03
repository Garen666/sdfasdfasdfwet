<?php
class category_index extends Engine_Class {

    public function process() {
        $table = new Shop_ContentTable(new Datasource_Category());

        $field = new Forms_ContentFieldControlLink('name', 'shop-admin-category-control', 'key');
        $table->addField($field);

        $table->getField('name')->setName(Shop::Get()->getTranslateService()->getTranslate('translate_the_category'));

        $this->setValue('table', $table->render());
    }

}