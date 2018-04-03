<?php
/**
 * WebProduction Shop (wpshop)
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Datasource_OrderStatus extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        return Shop::Get()->getShopService()->getStatusAll();
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldControlLink('id', 'shop-admin-orderstatus-control', 'key');
        $field->setName('#');
        $field->setEditable(false);
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_status'));
        $this->addField($field);

        if (Engine::Get()->getConfigFieldSecure('project-box')) {
            $field = new Forms_ContentFieldSelectList('categoryid', true);
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_single_category'));
            $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_OrderCategory'));
            $field->setEmptyOptionValue(0);
            $field->setEmptyOptionName('Для всех категорий');
            $this->addField($field);

            $field = new Forms_ContentFieldTextarea('content');
            $field->setName('Рекомендации к действию для менеджеров');
            $this->addField($field);
        }

        $field = new Forms_ContentField('logicclass');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_the_handler'));
        $field->setEditable(false);
        $this->addField($field);

        $field = new Forms_ContentFieldTextarea('message');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_email_template'));
        $this->addField($field);

        $field = new Forms_ContentFieldTextarea('messageadmin');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_email_template_admin'));
        $this->addField($field);


        $field = new Forms_ContentFieldCheckbox('default');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_new_default'));
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('payed');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_paid'));
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('saled');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_sold'));
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('downloadable');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_you_can_download_items'));
        $this->addField($field);

        $field = new Forms_ContentFieldInt('sort');
        $field->setName('Сортировка');
        $this->addField($field);

        if (Engine::Get()->getConfigFieldSecure('project-box')) {
            $field = new Forms_ContentFieldInt('priority');
            $field->setName('Приоритет (перекрытие)');
            $this->addField($field);
        }

        $field = new Forms_ContentField('colour');
        $field->setName('Подсветка фона');
        $this->addField($field);
    }

}