<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2015 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * Класс-отправщик письма с вложениями
 *
 * @author atarget
 * @author Max
 * @copyright WebProduction
 * @package MailUtils
 */
class MailUtils_Letter {

    /**
     * @param string $from
     * @param string $to
     * @param string $subject
     * @param string $text
     */
    public function __construct($from, $to, $subject, $body) {
        $this->_to = $to;
        $this->_from = $from;
        $this->_subject = $subject;
        $this->setBody($body);
    }

    /**
     * Получить адрес почты "куда" отправлять письмо
     *
     * @return string
     */
    public function getEmailTo() {
        return $this->_to;
    }

    /**
     * Получить обратный адрес "от кого" отправлять письмо
     *
     * @return string
     */
    public function getEmailFrom() {
        return $this->_from;
    }

    /**
     * Получить тему письма
     *
     * @return string
     */
    public function getSubject() {
        return $this->_subject;
    }

    /**
     * Построить закодированную тему письма (в UTF-8 & base64 & prefix)
     *
     * @return string
     */
    public function makeSubjectEncoded() {
        // если тема письма не из цифр и букв A-Z - то это UTF-8
        if (preg_match("/^([a-z0-9-\:\.\,\s]*)$/ius", $this->_subject)) {
            return $this->_subject;
        } else {
            return "=?UTF-8?B?".base64_encode($this->_subject)."?=";
        }
    }

    /**
     * @param string $text
     */
    public function setBody($text) {
        $this->_compiled = null;
        $this->_body = $text;
    }

    /**
     * @return string $text
     */
    public function getBody() {
        return $this->_body;
    }

    /**
     * Вложить файл
     *
     * @param string $data Данные
     * @param string $name Имя файла
     * @param string $type MIME-тип
     */
    public function addAttachment($data, $name = 'Attachment', $type = "application/octet-stream") {
        $this->_attachments[] = array(
        'type' => $type,
        'data' => $data,
        'name' => $name
        );

        $this->_compiled = null;
    }

    /**
     * @param int $n
     * @return string
     */
    public function getAttachment ($n) {
        return $this->_attachments[$n]['data'];
    }

    public function getAttachments() {
        return $this->_attachments;
    }

    public function deleteAttachment ($n) {
        $this->_compiled = null;
        unset($this->_attachments[$n]);
    }

    public function _makepart($part, $bound) {
        $message = chunk_split(base64_encode($part['data']));
        $part = "Content-Type: ".$part["type"].($part["name"] ? "; name = \"".$part["name"]."\"" : "")."\nContent-Disposition: attachment; filename=\"$part[name]\"\nContent-Transfer-Encoding: base64\n\n$message\n";
        return "\n--".$bound."\n".$part;
    }

    /**
     * Установить тип основного контента
     *
     * @param string $type
     */
    public function setBodyType($type) {
        $this->_body_type = $type;
    }

    /**
     * Получить тип основного контента
     *
     * @return string
     */
    public function getBodyType() {
        return $this->_body_type;
    }

    /**
     * Собрать письмо
     *
     * @return string
     */
    public function make($withSubject = false) {
        if (!empty($this->_compiled)) {
            return $this->_compiled;
        }

        $boundary = "=+=--b".md5(uniqid(time()));
        $message = '';
        if (!empty($this->_from)) {
            $message .= "From: {$this->_from}\n";
        }
        if (!empty($_SERVER['HTTP_HOST'])) {
            $message .= 'x-Mailer: '.$_SERVER['HTTP_HOST']."\n";
        }
        $message .= "MIME-Version: 1.0\n";
        if ($withSubject) {
            // @todo: bug with _compiled
            $message .= "Subject: ".$this->makeSubjectEncoded()."\n";
        }
        $message .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\n--".$boundary."\n";
        $message .= "Content-Type: {$this->_body_type}; charset=UTF-8 \nContent-Transfer-Encoding: 8bit \n\n".$this->getBody()."\n";

        if ($this->_attachments) {
            foreach ($this->_attachments as $x) {
                $message .= $this->_makepart($x, $boundary);
            }
        }

        // сохраняем compiled-версию
        $this->_compiled = $message."--".$boundary."--\n";

        return $this->_compiled;
    }

    /**
     * @todo remake concept
     *
     * @param string $data
     */
    public function setCompiled($data) {
        $this->_compiled = $data;
    }

    /**
     * Показать письмо
     *
     * @return string
     */
    public function __toString() {
        return $this->make();
    }

    /**
     * Отправить письмо.
     * В качестве отправщика будет использоваться указанный в настройках (MailUtils_Config)
     * оправщик (mail-sender).
     *
     * $startDate - это дата когда отправить письмо
     *
     * @param string $startDate
     */
    public function send($startDate = false) {
        $sender = MailUtils_Config::Get()->getSender();
        $sender->send($this, $startDate);
    }

    private $_body_type = 'text/plain';

    private $_to;

    private $_from;

    private $_subject;

    private $_body;

    private $_compiled = false;

    private $_attachments;

}