<?php
/**
 * WebProduction Shop (wpshop)
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @author Oleksii Golub <avator@webproduction.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Datasource_Workflow extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        return Shop::Get()->getShopService()->getWorkflowsAll();
    }

    protected function _initialize() {
        $isBox = Engine::Get()->getConfigFieldSecure('project-box');

        $field = new Forms_ContentFieldInt('id');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_title'));
        $this->addField($field);

        if ($isBox) {
            $field = new Forms_ContentFieldSelectList('currencyid');
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_the_currency'));
            $field->setDataSource(new Datasource_Currency());
            $this->addField($field);

            $field = new Forms_ContentField('productsDefault');
            $field->setName('Продукты');
            $this->addField($field);

            $field = new Forms_ContentField('term');
            $field->setName('Срок жизни');
            $this->addField($field);

            $field = new Forms_ContentField('issuename');
            $field->setName('Шаблон имени');
            $this->addField($field);

            $field = new Shop_ContentFieldUserInfo('managerid');
            $field->setName('Ответвтвенный для старта новых задач');
            $this->addField($field);

            // Если прописаны контенты
            try{
                Engine::Get()->getConfigField('smart-workflow-contents');

                $field = new Forms_ContentFieldCheckbox('smart');
                $field->setName('Умный бизнес-процесс');
                $this->addField($field);

                $field = new Shop_ContentFieldUserInfo('smartContent');
                $field->setName('Smart Content');
                $this->addField($field);
            } catch (Exception $e) {

            }


            $field = new Forms_ContentFieldCheckbox('hidden');
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_hidden'));
            $this->addField($field);
        }




    }

}