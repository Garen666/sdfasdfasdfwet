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
class Shop {

    /**
     * @return Shop_GameService
     */
    public function getGameService() {
        return ServiceUtils::Get()->getService('game');
    }

    /**
     * @param string $service
     */
    public function setGameService($service) {
        ServiceUtils::Get()->setService('game', $service);
    }

    /**
     * @return ChatService
     */
    public function getChatService() {
        return ServiceUtils::Get()->getService('chat');
    }

    /**
     * @param string $service
     */
    public function setChatService($service) {
        ServiceUtils::Get()->setService('chat', $service);
    }

    /**
     * @return LotTypeService
     */
    public function getLotTypeService() {
        return ServiceUtils::Get()->getService('lotType');
    }

    /**
     * @param string $service
     */
    public function setLotTypeService($service) {
        ServiceUtils::Get()->setService('lotType', $service);
    }

    /**
     * @return Shop_UserService
     */
    public function getUserService() {
        return ServiceUtils::Get()->getService('user');
    }

    /**
     * @param string $service
     */
    public function setUserService($service) {
        ServiceUtils::Get()->setService('user', $service);
    }

    /**
     * @return Shop_FeedbackService
     */
    public function getFeedbackService() {
        return ServiceUtils::Get()->getService('feedback');
    }

    /**
     * @param string $service
     */
    public function setFeedbackService($service) {
        return ServiceUtils::Get()->setService('feedback', $service);
    }

    /**
     * @return Shop_ShopService
     */
    public function getShopService() {
        return ServiceUtils::Get()->getService('shop');
    }

    /**
     * @param string $service
     */
    public function setShopService($service) {
        return ServiceUtils::Get()->setService('shop', $service);
    }

    /**
     * @return Shop_SettingsService
     */
    public function getSettingsService() {
        return ServiceUtils::Get()->getService('setting');
    }

    /**
     * @param string $service
     */
    public function setSettingService($service) {
        return ServiceUtils::Get()->setService('setting', $service);
    }

    /**
     * @return Shop_FaqService
     */
    public function getFaqService() {
        return ServiceUtils::Get()->getService('faq');
    }

    /**
     * @param string $service
     */
    public function setFaqService($service) {
        return ServiceUtils::Get()->setService('faq', $service);
    }


    /**
     * @return Shop_TextPageService
     */
    public function getTextPageService() {
        return ServiceUtils::Get()->getService('textpage');
    }

    /**
     * @param string $service
     */
    public function setTextpageService($service) {
        return ServiceUtils::Get()->setService('textpage', $service);
    }

    /**
     * @return Shop_CurrencyService
     */
    public function getCurrencyService() {
        return ServiceUtils::Get()->getService('currency');
    }

    /**
     * @param string $service
     */
    public function setCurrencyService($service) {
        return ServiceUtils::Get()->setService('currency', $service);
    }

    /**
     * @return Shop_GuestBookService
     */
    public function getGuestBookService() {
        return ServiceUtils::Get()->getService('guestbook');
    }

    /**
     * @param string $service
     */
    public function setGuestbookService($service) {
        return ServiceUtils::Get()->setService('guestbook', $service);
    }

    /**
     * @return Shop_BlockService
     */
    public function getBlockService() {
        return ServiceUtils::Get()->getService('block');
    }

    /**
     * @param string $service
     */
    public function setBlockService($service) {
        return ServiceUtils::Get()->setService('block', $service);
    }


    /**
     * @return SEOService
     */
    public function getSEOService() {
        return ServiceUtils::Get()->getService('seo');
    }

    /**
     * @param string $service
     */
    public function setSEOService($service) {
        return ServiceUtils::Get()->setService('seo', $service);
    }

    /**
     * @return Shop_TranslateFormService
     */
    public function getTranslateService() {
        return ServiceUtils::Get()->getService('translate');
    }

    /**
     * @param string $service
     */
    public function setTranslateService($service) {
        return ServiceUtils::Get()->setService('translate', $service);
    }

    /**
     * @return Shop
     */
    public static function Get() {
        if (!self::$_Instance) {
            self::$_Instance = new self();
        }
        return self::$_Instance;
    }

    private function __construct() {
        // инициализация сервисом по умолчанию
        $this->setUserService('Shop_UserService');
        $this->setFeedbackService('Shop_FeedbackService');
        $this->setShopService('Shop_ShopService');
        $this->setSettingService('Shop_SettingsService');
        $this->setFaqService('Shop_FaqService');
        $this->setTextpageService('Shop_TextPageService');
        $this->setCurrencyService('Shop_CurrencyService');
        $this->setGuestbookService('Shop_GuestBookService');
        $this->setBlockService('Shop_BlockService');
        $this->setSEOService('SEOService');
        $this->setTranslateService('Shop_TranslateService');
        $this->setGameService('Shop_GameService');
        $this->setLotTypeService('LotTypeService');
        $this->setChatService('ChatService');

    }

    private function __clone() {

    }

    private static $_Instance = null;

}