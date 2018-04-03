<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2012 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * Exeption, который могут выбрасывать сервисы
 * Хранит в себе массив ошибок
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @author Ramm
 * @author DFox
 * @author Shurik
 * @copyright WebProduction
 * @package ServiceUtils
 */
class ServiceUtils_Exception extends Exception {

    public function __construct($message = '', $code = 0) {
        parent::__construct($message, $code);
        if ($code === 0 && $message) {
            $this->addError($message);
        }
    }

    /**
     * Добавить ошибку-сообщение в массив
     *
     * @param mixed $code
     * @param mixed $parameterArray
     */
    public function addError($code, $parameterArray = array()) {
        // @todo: проверка на наличие кода?
        $this->_errorsArray[] = $code;
        $this->_errorFullArray[] = array(
        'key' => $code,
        'parameterArray' => $parameterArray
        );
    }

    /**
     * Получить массив ошибок
     *
     * @deprecated
     * @see getErrorsArray()
     * @return array
     */
    public function getErrors() {
        return $this->getErrorsArray();
    }

    /**
     * Получить массив ошибок
     *
     * @param bool $full
     * @return array
     */
    public function getErrorsArray($full = false) {
        if ($full) {
            return $this->_errorFullArray;
        } else {
            return $this->_errorsArray;
        }
    }

    /**
     * Получить количество ошибок
     *
     * @return int
     */
    public function getCount() {
        return count($this->getErrorsArray());
    }

    public function __toString() {
        if (class_exists('DebugException')) {
            return DebugException::Display($this, __CLASS__);
        }

        return parent::__toString();
    }

    /**
     * Записать полученный exception в log-файл
     */
    public function log($file = false) {
        if (!$file) {
            $file = PackageLoader::Get()->getProjectPath().'/media/logs/';
            $file .= 'exception-'.date('Y-m-d').'.log';
        }

        $cdate = date('Y-m-d H:i:s');
        $string = $this->getTraceAsString();
        $string .= print_r($this->getErrorsArray(), true);

        $f = fopen($file, 'a+');
        flock($f, LOCK_EX);
        fwrite($f, $cdate.': '.$string."\n");
        flock($f, LOCK_UN);
        fclose($f);
    }

    private $_errorsArray = array();
    private $_errorFullArray = array();

}