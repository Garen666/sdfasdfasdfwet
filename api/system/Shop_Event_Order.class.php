<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Shop_Event_Order extends Events_Event {

    /**
     * @param ShopOrder $order
     */
    public function setOrder(ShopOrder $order) {
        $this->_order = $order;
    }

    /**
     * @return ShopOrder
     */
    public function getOrder() {
        return $this->_order;
    }

    private $_order;

}