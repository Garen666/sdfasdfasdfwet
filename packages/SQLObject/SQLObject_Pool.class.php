<?php
/**
 * WebProduction Packages. SQLObject.
 * Copyright (C) 2007-2012 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * Объектный пул SQLObject'a.
 * В него помещаются только часто используемые объекты (Например, категории)
 * Пул требует ОЗУ.
 *
 * @copyright WebProduction
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @package SQLObject
 */
class SQLObject_Pool {

    /**
     * Добавить объект в пул
     *
     * @param SQLObject $object
     * @throws SQLObject_Exception
     * @return bool
     */
    public function add(SQLObject $object) {
        if (!$object) {
            throw new SQLObject_Exception('Cannot put an empty object to pool');
        }

        $classname = $object->getClassname();

        // сколько максимально объектов данного класса можно хранить в пуле
        $maxClassObjects = SQLObject_Config::Get()->getMaxPoolObjects($classname);

        // по умолчанию пул для 100 объектов
        if ($maxClassObjects <= 0) {
            $maxClassObjects = 100;
        }

        if (isset($this->_pool[$classname])
        && count($this->_pool[$classname]) + 1 > $maxClassObjects) {
            // если мы добавим еще один объект, то придется что-то удалять...

            // первая дата активности в пуле по этому классу
            $date = false;
            foreach ($this->_pool[$classname] as $a) {
                if ($date === false || $a[1] < $date) {
                    $date = $a[1];
                }
            }

            // удаление из пула старых объектов этого класса
            foreach ($this->_pool[$classname] as $k => $a) {
                if ($a[1] <= $date) {
                    // убираем объект из пула - этого достаточно
                    unset($this->_pool[$classname][$k]);
                    break;
                }
            }
        }

        $this->_pool[$classname][$object->getField($object->getPrimaryKey())] = array($object, microtime(true));

        return true;
    }

    /**
     * Получить объект из пула
     *
     * @param string $classname
     * @param int $id
     * @return SQLObject
     */
    public function get($classname, $id) {
        $id = (int) $id;
        if (!empty($this->_pool[$classname][$id])) {
            $this->_pool[$classname][$id][1] = microtime(true);
            return $this->_pool[$classname][$id][0];
        }
        return false;
    }

    /**
     * Удалить объект из пула
     * @todo exception?
     *
     * @param string $classname
     * @param int $id
     * @return bool
     */
    public function delete($classname, $id) {
        if (!empty($this->_pool[$classname][$id])) {
            unset($this->_pool[$classname][$id]);
            return true;
        }
        return false;
    }

    /**
     * Удалить все объекты из пула
     *
     * @param string $classname
     * @return bool
     */
    public function clear($classname) {
        if (!empty($this->_pool[$classname])) {
            unset($this->_pool[$classname]);
            return true;
        }
        return false;
    }

    /**
     * Удалить все объекты из пула
     *
     */
    public function clearAll() {
        $this->_pool = array();
    }
    
    /**
     * Получить объекты SQLObjectPool'a
     *
     * @return SQLObject_Pool
     */
    public static function GetPool() {
        if (!self::$_Instance) {
            self::$_Instance = new self();
        }
        return self::$_Instance;
    }

    private function __construct() {

    }

    private function __clone() {

    }

    private static $_Instance = null;

    private $_pool = array();

}