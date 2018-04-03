<?php
/**
 * WebProduction Shop (wpshop)
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Datasource_Role extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        $role = new XShopRole();
        $role->setOrder('name', 'ASC');
        return $role;
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldControlLink('id', 'shop-admin-role-control', 'key');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName('Название роли');
        $field->addValidator(new Forms_ValidatorEmpty());
        $this->addField($field);

        $field = new Forms_ContentFieldTextarea('description');
        $field->setName('Описание роли');
        $this->addField($field);

        $field = new Forms_ContentFieldSelectTree('parentid', true);
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Role'));
        $field->setName('Подчиняется');
        $field->addValidator(new Forms_ValidatorParentId());
        $this->addField($field);
    }

}