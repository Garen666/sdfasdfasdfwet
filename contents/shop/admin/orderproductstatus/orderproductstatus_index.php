<?php
class orderproductstatus_index extends Engine_Class {

    public function process() {
        $table = new Shop_ContentTable(new Datasource_OrderProductStatus());
        $this->setValue('table', $table->render());
    }

}