<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2012 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * Реализация фабрики сервисов
 *
 * @author Max
 * @copyright WebProduction
 * @package ServiceUtils
 */
class ServiceUtils_Factory {

    /**
     * @return UserService
     */
    public function getUserService() {
        return $this->_getService('UserService');
    }

    /**
	 * @return AuthService
	 */
    public function getAuthService() {
        if (!$this->_authService) {
            return $this->_getService('AuthService');
        }
        return $this->_authService;
    }

    protected function _getService($serviceName) {
        if (empty($this->_cache[$serviceName])) {
            $this->_cache[$serviceName] = new $serviceName();
        }
        return $this->_cache[$serviceName];
    }

    private $_userService = false;

    private $_authService = false;

    private $_cache = array();

}