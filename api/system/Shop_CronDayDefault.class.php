<?php

class Shop_CronDayDefault implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        // генерация sitemaps
        Shop::Get()->getSEOService()->generateSitemap();
    }

}