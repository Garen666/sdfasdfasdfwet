<?php
/**
 * WebProduction Shop (wpshop)
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @copyright WebProduction
 * @package Shop
 */
class Datasource_UserGroup extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        return Shop::Get()->getUserService()->getUserGroupsAll();
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_the_band_name'));
        $this->addField($field);

        $field = new Forms_ContentField('description');
        $field->setName('Описание группы');
        $this->addField($field);

        $field = new Forms_ContentFieldInt('sort');
        $field->setName('Сортировка');
        $this->addField($field);

        $field = new Forms_ContentField('colour');
        $field->setName('Цвет');
        $this->addField($field);

        if (Engine::Get()->getConfigFieldSecure('project-box')) {
            $field = new Forms_ContentField('logicclass');
            $field->setName('Smart-обработчик');
            $this->addField($field);
        }
    }

}