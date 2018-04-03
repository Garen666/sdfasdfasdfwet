<?php
class orders_index extends Engine_Class {

    public function process() {
        $list = Engine::GetContentDriver()->getContent('issue-list');
        $list->setValue('datasource', new Datasource_Orders());
        $this->setValue('block_issue', $list->render());
    }

}