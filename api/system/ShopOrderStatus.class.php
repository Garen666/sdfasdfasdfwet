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
class ShopOrderStatus extends XShopOrderStatus {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopOrderStatus
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return ShopStorageName
     */
    public function getStorageName() {
        return Shop::Get()->getStorageService()->getStorageNameByID(
        $this->getStoragenameid()
        );
    }

    public function getWidth() {
        return $this->_normalizeWorkflowElementWidth(
        parent::getWidth()
        );
    }

    public function getHeight() {
        return $this->_normalizeWorkflowElementHeight(
        parent::getHeight()
        );
    }

    public function getX() {
        return $this->_normalizeWorkflowElementPosition(
        parent::getX()
        );
    }

    public function getY() {
        return $this->_normalizeWorkflowElementPosition(
        parent::getY()
        );
    }

    /**
     * Преобразовать координату элемента к допустимым параметрам
     *
     * @param int $position
     * @return int
     */
    private function _normalizeWorkflowElementPosition($position) {
        $position = (int) $position;

        // issue #34780 - приводим к сетке 20x20px
        $position = round($position - $position % 20);

        return $position;
    }

    /**
     * Преобразовать ширину элемента к допустимым параметрам
     *
     * @param int $width
     * @return int
     */
    private function _normalizeWorkflowElementWidth($width) {
        $width = (int) $width;

        if ($width <= 100) {
            $width = 100;
        }

        if ($width >= 300) {
            $width = 300;
        }

        // issue #34780 - приводим к сетке 20x20px
        $width = round($width - $width % 20);

        return $width;
    }

    /**
     * Преобразовать высоту элемента к допустимым параметрам
     *
     * @param int $height
     * @return int
     */
    private function _normalizeWorkflowElementHeight($height) {
        $height = (int) $height;

        if ($height <= 20) {
            $height = 20;
        }

        if ($height >= 300) {
            $height = 300;
        }

        // issue #34780 - приводим к сетке 20x20px
        $height = round($height - $height % 20);

        return $height;
    }

    /**
     * @deprecated
     * @return ShopOrderCategory
     */
    public function getCategory() {
        return $this->getWorkflow();
    }

    /**
     * @return ShopOrderCategory
     */
    public function getWorkflow() {
        return Shop::Get()->getShopService()->getOrderCategoryByID(
        $this->getCategoryid()
        );
    }

    /**
     * @return string
     */
    public function makeName() {
        return htmlspecialchars($this->getName());
    }

    /**
     * Проверка, можно ли выполнить переход в новый статус
     *
     * @param ShopOrderStatus $status
     * @return bool
     */
    public function canChangeTo(ShopOrderStatus $status) {
        $tmp = new XShopOrderStatusChange();
        $tmp->setCategoryid($this->getCategoryid());
        $tmp->setElementfromid($this->getId());
        $tmp->setElementtoid($status->getId());
        if ($tmp->select()) {
        	return true;
        }
        return false;
    }

}