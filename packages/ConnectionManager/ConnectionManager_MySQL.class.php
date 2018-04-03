<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2012 WebProduction <webproduction.com.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * Адаптер для соеденения с MySQL базой.
 * Использует встроенные php-функции mysql_*
 *
 * @deprecated
 * @see ConnectionManager_MySQLi
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package ConnectionManager
 */
class ConnectionManager_MySQL
implements ConnectionManager_IDatabaseAdapter, ConnectionManager_IConnection {

    /**
     * @return array
     */
    public function getStatistics() {
        return $this->_queryStat;
    }

    public function __construct($hostname, $username, $password, $database = false, $encoding = 'utf8') {
        // проверка
        if (!function_exists('mysql_connect')) {
            throw new ConnectionManager_Exception("PHP extension 'mysql' not available");
        }

        $this->_hostname = $hostname;
        $this->_username = $username;
        $this->_password = $password;
        $this->_database = $database;
        $this->_encoding = $encoding;
        if (PackageLoader::Get()->getMode('debug')) $this->enableStatistic();
    }

    public function connect() {
        $this->_linkID = @mysql_connect(
        $this->_hostname,
        $this->_username,
        $this->_password,
        true
        );

        if ($this->getLinkID() === false || ($e = mysql_error($this->getLinkID()))) {
            throw new ConnectionManager_Exception("Cannot connect to database: ".@$e);
        }

        if ($this->_database) {
            mysql_select_db($this->_database, $this->getLinkID());
            if ($e = mysql_error($this->getLinkID())) {
                throw new ConnectionManager_Exception("Cannot select database: ".$e);
            }
        }

        if ($this->_encoding) {
            $this->query("SET NAMES '{$this->_encoding}'");
        }
    }

    /**
     * Выполнить SQL-запрос.
     * Через этот метод теоретически проходят все SQL-запросы в системе.
     *
     * @param string $query
     * @return resource
     */
    public function query($query) {
        if (!$this->getLinkID()) {
            $this->connect();
        }

        $time = microtime(true);
        $result = mysql_query($query, $this->getLinkID());
        $time = microtime(true) - $time;

        if ($this->_stat) {
            $statArray = array();
            $statArray['query'] = $query;
            $statArray['time'] = $time;
            $this->_queryStat[] = $statArray;
        }

        if ($e = mysql_error($this->getLinkID())) {
            $ex = new ConnectionManager_Exception($e, mysql_errno($this->getLinkID()));
            $ex->setQuery($query);
            throw $ex;
        }

        return $result;
    }

    public function disconnect() {
        @mysql_close($this->getLinkID());
    }

    public function getLinkID() {
        return $this->_linkID;
    }

    public function __destruct() {
        @$this->disconnect();
    }

    /**
     * Начать транзакцию
     * force - принудительно.
     *
     * @param bool $force
     */
    public function transactionStart($force = false) {
        // транзакцию нужно открывать либо по force, либо когда счетчик = 0
        if (!$this->_transactionCount || $force) {
            $this->query("START TRANSACTION");
        }

        $this->_transactionCount ++;
    }

    /**
     * Выполнить транзакцию
     * force - принудительно
     *
     * @param bool $force
     */
    public function transactionCommit($force = false) {
        // коммит нужно выполнить только если force или транзакция одна
        if ($force || $this->_transactionCount == 1) {
            $this->query("COMMIT");
        }
        $this->_transactionCount --;

        if ($this->_transactionCount < 0) {
            $this->_transactionCount = 0;
        }
    }

    /**
     * Откатить транзакцию
     * force - принудительно
     *
     * @param bool $force
     */
    public function transactionRollback($force = false) {
        // rollback нужно выполнить только если force или транзакция одна
        if ($force || $this->_transactionCount == 1) {
            $this->query("ROLLBACK");
        }
        $this->_transactionCount --;

        if ($this->_transactionCount < 0) {
            $this->_transactionCount = 0;
        }
    }

    /**
     * Выполнить обработку запроса.
     *
     * @param mixed $queryResource
     * @return array
     */
    public function fetch($queryResource) {
        if (!$queryResource) {
            throw new ConnectionManager_Exception("No query result to fetch");
        }
        return mysql_fetch_assoc($queryResource);
    }

    /**
     * Экранировать строку
     *
     * @param string $string
     * @return string
     */
    public function escapeString($string) {
        if (!$this->getLinkID()) {
        	$this->connect();
        }
        return mysql_real_escape_string($string, $this->getLinkID());
    }

    public function enableStatistic() {
        $this->_stat = true;
    }

    public function disableStatistic() {
        $this->_stat = false;
    }

    /**
     * @return bool
     */
    public function isStatisticEnabled() {
        return $this->_stat;
    }

    public function getLastInsertID() {
        return mysql_insert_id($this->getLinkID());
    }

    private $_hostname;

    private $_username;

    private $_password;

    private $_database;

    private $_encoding;

    private $_linkID = null;

    private $_queryStat = array();

    private $_transactionCount = 0;

    private $_stat = false;

}