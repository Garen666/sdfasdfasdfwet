<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2012 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package SQLObjectSync
 */
class SQLObjectSync_Table {

    /**
     * @return ConnectionManager_IConnection
     */
    public function getConnectionDatabase() {
        if (!$this->_connection) {
            throw new SQLObject_Exception('No connection');
        }
        return $this->_connection;
    }

    /**
     * Установить соединение с базой данных
     *
     * @param ConnectionManager_IConnection $connection
     */
    public function setConnectionDatabase(ConnectionManager_IConnection $connection) {
        $this->_connection = $connection;
    }

    /**
     * Получить массив объектов SQLObjectSync_Field
     *
     * @return array
     */
    public function getFieldArray() {
        return $this->_fieldArray;
    }

    /**
     * Добавить поле в таблицу
     *
     * @param string $name
     * @param string $type
     * @param array $addons
     * @return SQLObjectSync_Field
     */
    public function addField($name, $type, $addons = false) {
        // @todo: проверка и нормализация имен полей

        // @todo: вот такая тупая защита от повторения полей
        $x = new SQLObjectSync_Field($name, $type, $addons);
        $this->_fieldArray[$name] = $x;

        return $x;
    }

    /**
     * Добавить индекс, ключ, первичный ключ, уникальный ключ.
     * INDEX, PRIMARY, UNIQUE, FULLTEXT
     *
     * @param mixed $fields Поля для индекса (строка или массив)
     * @param string $indexname Имя индекса
     * @param string $type Тип индекса
     */
    private function _addKey($fields, $indexType = false, $indexName = false) {
        if (is_array($fields) && !$indexName) {
            // если указано несколько полей и не указано имя индекса - ошибка
            throw new SQLObjectSync_Exception("Cannot add multiple index without indexname!");
        } elseif (!$indexName) {
            // имя индекса = имя поля
            $indexName = $fields;

        }

        if (!is_array($fields)) {
            $fields = array($fields);
        }
        if (!$indexType) {
            $indexType = 'INDEX';
        }

        $this->_indexArray[$indexName] = array(
        'name' => $indexName,
        'fields' => $fields,
        'type' => $indexType,
        );
    }

    /**
     * Добавить индекс на поле/поля
     *
     * @param mixed $indexFields string or array
     * @param string $indexName
     */
    public function addIndex($indexFields, $indexName = false) {
        $this->_addKey($indexFields, 'index', $indexName);
    }

    /**
     * Добавить уникальный индекс на поле/поля
     *
     * @param mixed $indexFields string or array
     * @param string $indexName
     */
    public function addIndexUnique($indexFields, $indexName = false) {
        $this->_addKey($indexFields, 'unique', $indexName);
    }

    /**
     * Добавить fulltext индекс на поле/поля
     *
     * @param mixed $indexFields string or array
     * @param string $indexName
     */
    public function addIndexFulltext($indexFields, $indexName = false) {
        $this->_addKey($indexFields, 'fulltext', $indexName);
    }

    /**
     * Добавить перввичный ключ на поле/поля
     *
     * @param mixed $indexFields string or array
     * @param string $indexName
     */
    public function addIndexPrimary($indexFields, $indexName = false) {
        $this->_addKey($indexFields, 'primary', $indexName);
    }

    /**
     * Получить имя таблицы
     *
     * @return string
     */
    public function getTableName() {
        return $this->_tablename;
    }

    public function __construct($tableName) {
        if (!$tableName) {
            throw new SQLObjectSync_Exception('Invalid tablename');
        }
        $this->_tablename = $tableName;
    }

    /**
     * @todo
     * @return string
     */
    private function getTableEngine() {
        return 'innoDB';
    }

    /**
     * Обработать таблицу, построить xclass если надо
     *
     * @todo adapters
     *
     * @param bool $rebuildIndexes
     */
    public function process($rebuildIndexes = false) {
        try {
            $q = $this->getConnectionDatabase()->query("DESCRIBE `{$this->_tablename}`");

            // такая таблица есть, выполняем проверки на поля: добавляем/убираем/апдейтим

            // строим массив текущих полей в таблице
            $originalFields = array();
            while ($x = $this->getConnectionDatabase()->fetch($q)) {
                $originalFields[$x['Field']] = array(
                'name' => $x['Field'],
                'type' => $x['Type'],
                );
            }

            // проверяем каких полей не хватает:
            // проходимся по заявленным полям и смотрим какие есть
            foreach ($this->_fieldArray as $currentField) {
                $currentName = $currentField->getName();
                if (empty($originalFields[$currentName])) {
                    // такого поля нет в реальной таблице, добавляем его
                    $this->getConnectionDatabase()->query("ALTER TABLE `{$this->_tablename}` ADD `{$currentName}` {$currentField->getType()} NOT NULL {$currentField->getAddons()} NOT NULL");
                } else {
                    // такое поле есть в реальной таблице, обновляем его
                    if (strtolower($currentField->getType()) != strtolower($originalFields[$currentName]['type'])) {
                        $this->getConnectionDatabase()->query("ALTER TABLE `{$this->_tablename}` CHANGE `{$currentName}` `{$currentName}` {$currentField->getType()} NOT NULL");
                    }
                }
            }

            // перестройка индексов
            if ($rebuildIndexes) {

                // получаем текущие индексы
                $currentIndexArray = array();
                $q = $this->getConnectionDatabase()->query("SHOW INDEX FROM `{$this->_tablename}`");
                while ($x = $this->getConnectionDatabase()->fetch($q)) {
                    $indexName = $x['Key_name'];
                    if (!isset($currentIndexArray[$indexName])) {
                        $indexType = $x['Non_unique'] ? 'index' : 'unique';
                        if ($x['Index_type'] == 'FULLTEXT') {
                            $indexType = 'fulltext';
                        }

                        $currentIndexArray[$indexName] = array(
                        'fieldArray' => array($x['Column_name']),
                        'type' => $indexType,
                        );
                    } else {
                        $currentIndexArray[$indexName]['fieldArray'][] = $x['Column_name'];
                    }

                }

                foreach ($this->_indexArray as $index) {
                    $indextype = $index['type'];
                    $indexname = $index['name'];
                    $indexfields = $index['fields'];

                    $indextype = strtolower($indextype);
                    if ($indextype == 'primary') {
                        // primary ключи убивать нельзя!
                        continue;
                    }

                    if (isset($currentIndexArray[$indexname])) {
                        // индекс уже есть
                        // если он отличается - перестраиваем
                        if (implode(',', $indexfields) != implode(',', $currentIndexArray[$indexname]['fieldArray'])
                        || $indextype != $currentIndexArray[$indexname]['type']) {
                            foreach ($indexfields as &$if) {
                                $if = "`{$if}`";
                            }
                            try {
                                $this->getConnectionDatabase()->query("ALTER TABLE `$this->_tablename` DROP INDEX `{$indexname}`");
                                $this->getConnectionDatabase()->query("ALTER TABLE `$this->_tablename` ADD {$indextype} `{$indexname}` (".implode(', ', $indexfields).")");
                            } catch (Exception $indexEx) {
                                print_r($indexEx);
                            }
                        }
                    } else {
                        // индекса еще нет
                        foreach ($indexfields as &$if) {
                            $if = "`{$if}`";
                        }
                        try {
                            $this->getConnectionDatabase()->query("ALTER TABLE `$this->_tablename` ADD {$indextype} `{$indexname}` (".implode(', ', $indexfields).")");
                        } catch (Exception $indexEx) {
                            print_r($indexEx);
                        }
                    }
                }
            }
        } catch (Exception $e) {
            // такой таблицы нету, создаем ее

            $tmp = array();
            foreach ($this->_fieldArray as $f) {
                $tmp[] = "`{$f->getName()}` {$f->getType()} NOT NULL {$f->getAddons()}";
            }

            foreach ($this->_indexArray as $index) {
                $indextype = $index['type'];
                $indexname = $index['name'];
                $indexfields = $index['fields'];
                foreach ($indexfields as &$if) {
                    $if = "`{$if}`";
                }
                if ($indextype == 'index') {
                    $indextype = '';
                }
                $tmp[] = "{$indextype} KEY `{$indexname}` (".implode(', ', $indexfields).")";
            }

            // создаем таблицу
            // @todo: аналогично tableEngine можно вынести charset
            $this->getConnectionDatabase()->query(
            "CREATE TABLE `{$this->_tablename}` (".implode(",\n", $tmp).") ENGINE={$this->getTableEngine()} DEFAULT CHARSET=utf8 AUTO_INCREMENT=1"
            );
        }
    }

    /**
     * Получить имя первичного ключа (поля)
     *
     * @return string
     */
    public function getPrimaryKey() {
        foreach ($this->_indexArray as $index) {
            if (strtolower($index['type']) == 'primary') {
                return $index['fields'][0];
            }
        }
        throw new SQLObjectSync_Exception('No primary key found');
    }

    /**
     * @var array
     */
    private $_fieldArray = array();

    /**
     * @var array
     */
    private $_indexArray = array();

    /**
     * @var string
     */
    private $_tablename = false;

    /**
     * @var ConnectionManager_IConnection
     */
    private $_connection = null;

}