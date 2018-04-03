<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2013 WebProduction <webproduction.ua>
 *
 * This program is commetcial software; you can not redistribute it and/or
 * modify it under any terms.
 */

/**
 * Event - событие.
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Events
 */
class Events_Event {

    /**
     * Добавить наблюдателя за событием
     *
     * @param Events_EventObserver $observer
     */
    public function addObserver(Events_IEventObserver $observer) {
        $this->_observersArray[] = $observer;
    }

    /**
     * Получить массив наблюдателей за событием
     *
     * @return array of Events_IEventObserver
     */
    public function getObserversArray() {
        return $this->_observersArray;
    }

    /**
     * Удалить наблюдателя из события
     *
     * @param Events_IEventObserver $observer
     */
    public function deleteObserver(Events_IEventObserver $observer) {
        foreach ($this->_observersArray as $k => $v) {
            if ($observer == $v) {
            	unset($this->_observersArray[$k]);
            }
        }
    }

    /**
     * Уведомить всех наблюдателей о событии.
     * Наблюдателю передается полностью объект события Event.
     */
    public function notify() {
        foreach ($this->_observersArray as $observer) {
            $observer->notify($this);
        }
    }

    private $_observersArray = array();

}