<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2013 WebProduction <webproduction.ua>
 *
 * This program is commetcial software; you can not redistribute it and/or
 * modify it under any terms.
 */

/**
 * Событийная система Events.
 * Event system или Event Manager.
 * Events выступает в роли строителя-диспетчера-прототипов событий.
 *
 * Система Events может быть встроена во многие другие подсистемы
 * типа Engine, SQLObject, ...
 * Встраивание путем инкапсуляции (аггрегации) или наследования.
 *
 * Паттерны: Observer/Listener/Publish-Subscribe, Prototype.
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Events
 */
class Events {

    /**
     * Получить событие
     *
     * @param string $name
     * @return Events_Event
     * @throws Events_Exception
     */
    public function getEvent($name) {
        if (empty($this->_eventsArray[$name])) {
        	throw new Events_Exception("Event with name '{$name}' not found");
        }
        return $this->_eventsArray[$name];
    }

    /**
     * Сгенерировать событие на основе прототипа.
     * (Клонировать прототип и вернуть результат)
     *
     * ООП-паттерн: Prototype
     *
     * @param string $name
     * @return Events_Event
     * @throws Events_Exception
     */
    public function generateEvent($name) {
        return clone $this->getEvent($name);
    }

    /**
     * Прицепить наблюдатель к событию
     *
     * @param string $eventName
     * @param Events_IEventObserver $observer
     * @throws Events_Exception
     */
    public function observe($eventName, Events_IEventObserver $observer) {
        $this->getEvent($eventName)->addObserver($observer);
    }

    /**
     * Зарегистрировать событие
     *
     * @param string $name
     * @param Events_Event $event
     */
    public function addEvent($name, Events_Event $event) {
        $this->_eventsArray[$name] = $event;
    }

    /**
     * @return Events
     */
    public static function Get() {
        if (!self::$_Instance) {
        	self::$_Instance = new self();
        }
        return self::$_Instance;
    }

    /**
     * Массив существущих событий
     *
     * @var array
     */
    private $_eventsArray = array();

    private static $_Instance = null;

}