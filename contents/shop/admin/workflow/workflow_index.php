<?php
class workflow_index extends Engine_Class {

    public function process() {
        $isBox = Engine::Get()->getConfigFieldSecure('project-box');
        $this->setValue('box', $isBox);

        if ($this->getArgumentSecure('add')) {
            try {
                $name = $this->getArgument('name', 'string');

                if (!$name) {
                    throw new ServiceUtils_Exception();
                }

                $type = $this->getArgumentSecure('type');
                if ($type && $type == 'issue') {
                    $type = 1;
                } else {
                    $type = 0;
                }

                $tmp = new ShopOrderCategory();
                $tmp->setName($name);
                if ($tmp->select()) {
                    throw new ServiceUtils_Exception();
                }

                $tmp->insert();

                $this->setValue('urlredirect', $tmp->makeURL());

                $this->setValue('message', 'ok');
            } catch (Exception $e) {
                $this->setValue('message', 'error');
            }
        }

        $table = new Shop_ContentTable(new Datasource_Workflow());

        $field = new Forms_ContentFieldControlLink('name', 'shop-workflow-edit', 'id');
        $table->addField($field);

        $table->getField('name')->setName('Бизнес-процесс');

        $this->setValue('table', $table->render());

    }

}