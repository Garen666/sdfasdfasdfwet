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
class ShopOrderCategory extends XShopOrderCategory {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopOrderCategory
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return ShopOrderCategory
     */
    public static function Get($key) {
        return self::GetObject('ShopOrderCategory', $key);
    }

    public function makeName() {
        return htmlspecialchars($this->getName());
    }

    public function makeURL() {
        return Engine::GetLinkMaker()->makeURLByContentIDParam(
        'shop-workflow-edit',
        $this->getId()
        );
    }

    /**
     * Получить этапы (статусы) категории
     *
     * @return ShopOrderStatus
     */
    public function getStatuses() {
        $statuses = Shop::Get()->getShopService()->getStatusAll();
        $statuses->setCategoryid($this->getId());
        return $statuses;
    }

    /**
     * Получить следующие статусы по Бизнес-процессу
     *
     * @param ShopOrderCategory $workflow
     * @param ShopOrderStatus $status
     * @return array
     */
    public function getStatusNext(ShopOrderCategory $workflow, ShopOrderStatus $status) {
        $statuses = new XShopOrderStatusChange();
        $statuses->filterCategoryid($workflow->getId());
        $statuses->filterElementfromid($status->getId());
        $statusesArray = array();
        while ($x = $statuses->getNext()) {
            try{
                $orderStatus = new XShopOrderStatus($x->getElementtoid());
                $statusesArray[$x->getElementtoid()] = array(
                    'id' => $x->getElementtoid(),
                    'name' => $orderStatus->getName()
                );
            } catch (Exception $e) {

            }
        }
        return $statusesArray;
    }

    /**
     * Получить стартовый статус
     *
     * @return ShopOrderStatus
     */
    public function getStatusDefault() {
        $status = $this->getStatuses();
        $status->setDefault(1);
        if ($x = $status->getNext()) {
            return $x;
        }

        throw new ServiceUtils_Exception();
    }

    /**
     * Получить завершенный статус
     *
     * @return ShopOrderStatus
     */
    public function getStatusClosed() {
        $status = $this->getStatuses();
        $status->setClosed(1);
        if ($x = $status->getNext()) {
            return $x;
        }

        throw new ServiceUtils_Exception();
    }

}