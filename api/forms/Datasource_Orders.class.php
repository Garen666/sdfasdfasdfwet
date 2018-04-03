<?php
/**
 * WebProduction Shop (wpshop)
 * @copyright (C) 2011-2014 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Datasource_Orders extends Forms_ADataSourceSQLObject {

    /**
     * @return ShopOrder
     */
    public function getSQLObject() {
        if (!$this->_sqlobject) {
            $cuser = Shop::Get()->getUserService()->getUser();
            $orders = Shop::Get()->getShopService()->getOrdersAll($cuser);
            $this->_sqlobject = $orders;
        }
        return $this->_sqlobject;
    }

    public function getFieldPreview() {
        return $this->getField('id');
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldCheckboxKey('select');
        $field->setName('#');
        $field->setSortable(false);
        $this->addField($field);

        $field = new Forms_ContentFieldInt('id');
        $field->setName('#');
        $this->addField($field);

        if (Engine::Get()->getConfigFieldSecure('project-box-custom-order-number')) {
            $field = new Forms_ContentFieldControlLink('number', 'shop-admin-orders-control', 'id');
            $field->setName('Номер');
            $this->addField($field);
        }

        if (Engine::Get()->getConfigFieldSecure('project-box-custom-order-name')) {
            $field = new Forms_ContentFieldControlLink('name', 'shop-admin-orders-control', 'id');
            $field->setName('Имя заказа');
            $field->setQuickedit(true);
            $this->addField($field);
        }

        $field = new Forms_ContentFieldControlLink('cdate', 'shop-admin-orders-control', 'id');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_date'));
        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('dateshipped', 'Y-m-d H:i');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_dateshipped'));
        $this->addField($field);

        /*if (Shop_ModuleLoader::Get()->isImported('storage')) {
        $field = new Forms_ContentFieldSelectList('isshipped');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_shipped'));
        $field->setDataSource(new Datasource_OrderShipped());
        $this->addField($field);
        }*/

        $field = new Forms_ContentFieldDatetime('dateto', 'Y-m-d H:i');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_execute_to'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldNumeric('sum');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_sum'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('currencyid');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_the_currency'));
        $field->setDataSource(new Datasource_Currency());
        $this->addField($field);

        if (Shop_ModuleLoader::Get()->isImported('finance')) {
            $field = new Shop_ContentField_Order_SumPayed('sum_payed');
            $field->setSortable(false);
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_sum_payed'));
            $this->addField($field);
        }

        // товары
        $field = new Shop_ContentField_Order_Products('products');
        $field->setSortable(false);
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_product'));
        $this->addField($field);

        if (Engine::Get()->getConfigFieldSecure('project-box')) {
            $field = new Forms_ContentFieldSelectList('categoryid');
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_single_category'));
            $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_OrderCategory'));
            $field->setEmptyOptionValue(0);
            $this->addField($field);
        }

        $field = new Forms_ContentFieldSelectList('statusid');
        $field->setDataSource(new Datasource_OrderStatus());
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_status'));
        $field->setEmptyOptionValue(0);
        $this->addField($field);


        $field = new Shop_ContentFieldUserInfo('userid', true);
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Users'));
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_the_client_user'));
        $field->setEmptyOptionValue(0);
        $this->addField($field);

        $field = new Forms_ContentField('clientname');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_fio'));
        $this->addField($field);

        $field = new Forms_ContentField('clientemail');
        $field->setName('Email');
        $this->addField($field);

        $field = new Forms_ContentField('clientaddress');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_address'));
        $this->addField($field);

        $field = new Forms_ContentField('clientcontacts');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_contacts'));
        $this->addField($field);

        $field = new Shop_ContentFieldOrderComment('comments');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_comment'));
        //$field->setQuickedit(true);
        $field->setEditable(false);
        $field->setSortable(false);
        $this->addField($field);

        $field = new Shop_ContentFieldUserInfo('managerid');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_manager'));
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Users'));
        $field->setEmptyOptionValue(0);
        $this->addField($field);

        if (Engine::Get()->getConfigFieldSecure('project-box')) {
            $field = new Forms_ContentFieldSelectList('sourceid');
            $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Source'));
            $field->setName('Источник');
            $field->setQuickedit(true);
            $field->setEmptyOptionValue(0);
            $this->addField($field);
        }

        $field = new Shop_ContentFieldUserInfo('authorid');
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Users'));
        $field->setName('Оформил');
        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('udate', 'Y-m-d H:i');
        $field->setName('Обновление');
        $this->addField($field);
    }

    private $_sqlobject;

}