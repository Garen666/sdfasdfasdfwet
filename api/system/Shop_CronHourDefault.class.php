<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneClick
 */
class Shop_CronHourDefault implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        // строим ЧПУ
        Shop::Get()->getSEOService()->buildFriendlyURLs();
        usleep(1000000 / rand(0, 1000)); // issue #63748 - smart timeout
    }

}