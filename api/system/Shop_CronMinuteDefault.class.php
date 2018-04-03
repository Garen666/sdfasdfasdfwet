<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneClick
 */
class Shop_CronMinuteDefault implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        // email
        MailUtils_Config::Get()->setSender(new MailUtils_SenderMail());
        MailUtils_SenderQueDB::ProcessQue();

        usleep(1000000 / rand(0, 1000)); // issue #63748 - smart timeout

    }
}