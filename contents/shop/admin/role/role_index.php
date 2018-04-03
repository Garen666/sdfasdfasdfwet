<?php
class role_index extends Engine_Class {

    public function process() {
        $table = new Shop_ContentTable(new Datasource_Role());

        $field = new Forms_ContentFieldControlLink('url', 'shop-admin-role-control', 'key');
        $table->addField($field);
        $table->getField('url')->setName('URL');

        $this->setValue('table', $table->render());
    }

}