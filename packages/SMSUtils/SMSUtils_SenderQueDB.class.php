<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2013 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * Отложенный отправщик SMS через таблицу в базе.
 * Складывает SMS в таблицу в базе, а затем отдельным скриптом в cron'e
 * можно выполнять отправку по очереди.
 *
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package MailUtils
 */
class SMSUtils_SenderQueDB implements SMSUtils_ISender {

    public function __construct($package = 'SQLObject') {
        PackageLoader::Get()->import($package);

        if (!class_exists('SoapClient')) {
            throw new SMSUtils_Exception('SOAPClient not found');
        }

        // инициируем таблицу в базе
        if (PackageLoader::Get()->getMode('development')) {

            $table = SQLObject_Config::Get()->addTable('smsutils_que', 'SMSUtils_XTurbosmsuaQue');
            $table->addField('id', "int(11)", 'auto_increment');
            $table->addIndexPrimary('id');
            $table->addField('cdate', "datetime");
            $table->addField('status', "tinyint(1)");
            $table->addField('pdate', "datetime");
            $table->addField('sender', "varchar(255)");
            $table->addField('to', "varchar(255)");
            $table->addField('content', "text");
            $table->addField('result', "text");

            SQLObject_Config::Get()->process();
        }

        /*PackageLoader::Get()->registerPHPClass(
        dirname(__FILE__).'/db/SMSUtils_XTurbosmsuaQue.class.php'
        );*/
    }

    public function send($sender, $destination, $text) {
        try {
            SQLObject::TransactionStart();

            $que = new SMSUtils_XTurbosmsuaQue();
            $que->setCdate(date('Y-m-d H:i:s'));
            $que->setStatus(0); // не отправлено
            $que->setSender($sender);
            $que->setTo($destination);
            $que->setContent($text);
            $que->insert();

            SQLObject::TransactionCommit();
        } catch (Exception $e) {
            SQLObject::TransactionRollback();
            throw $e;
        }
    }

    /**
     * Выполнить обработку очереди.
     *
     * @param int $limit
     */
    public static function ProcessQue(SMSUtils_ISender $sender, $limit = 50, $claerinterval = 168) {
        $que = new SMSUtils_XTurbosmsuaQue();
        $que->setStatus(0);
        $que->setLimitCount($limit);

        while ($x = $que->getNext()) {
            // отправляем sms
            $answer = $sender->send($x->getSender(), $x->getTo(), $x->getContent())->ResultArray;

            //в ответ может прийти как строка так и массив
            if (is_array($answer)) {
                $result = $answer[0];
            } else {
                $result = $answer;
            }

            if ($result == "Сообщения успешно отправлены") {
                $result = 'success';
            }

            // обновляем информацию в базе
            $x->setStatus(1);
            $x->setPdate(date('Y-m-d H:i:s'));
            $x->setResult($result);
            $x->update();
        }

        if (is_numeric($claerinterval)) {
            self::ClearQueue($claerinterval);
        }
    }

    /**
     * Очистить отработанную очередь.
     * $inteval указывается в часах и указывает максимальный срок хранения
     * обработанной записи с момента её обработки.
     * Если указать 0, то удалятся все уже отработанные записи очереди.
     *
     * @param int $inteval
     */
    public static function ClearQueue($interval = 168) {
        $interval = (int)$interval;

        try {
            SQLObject::TransactionStart();

            $que = new SMSUtils_XTurbosmsuaQue();

            $date = date('Y-m-d H:i:s', time() - $interval*3600);

            $que->setStatus(1);
            $que->addWhereQuery("pdate <= '{$date}'");
            $que->setLimitCount($interval);
            while ($x = $que->getNext()) {
            	$x->delete();
            }

            SQLObject::TransactionCommit();
        } catch (Exception $e) {
            SQLObject::TransactionRollback();

            if (PackageLoader::Get()->getMode('debug')) {
                print "Exception: {$e->getMessage()}\n";
            }
        }
    }

}