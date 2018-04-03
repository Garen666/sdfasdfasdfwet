<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2011 WebProduction <webproduction.com.ua>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU LESSER GENERAL PUBLIC LICENSE
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 */

/**
 * Простая система привелегий, на основе ACL
 * и его строковых ключей.
 *
 * Access Control List Simple Using
 * (like Zend_ACL)
 *
 * @package ACL
 * @copyright WebProduction
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 */
class ACL_Simple {

    /**
     * @var ACL
     */
    private $_acl;

    /**
     * @return ACL
     */
    public function getACL() {
    	return $this->_acl;
    }

    /**
     * @var array
     */
    private $_rolesArray = array();

    /**
     * @var array
     */
    private $_resourcesArray = array();

    public function __construct() {
        $this->_acl = new ACL();
    }

    /**
     * Найти роль по ее ID
     *
     * @param sting $roleID
     * @return ACL_Role
     */
    public function findRole($roleID) {
        if (is_object($roleID) && $roleID instanceof ACL_IRole) {
            return $roleID;
        }

        foreach ($this->_rolesArray as $role) {
            if ($role->getACLID() == $roleID) {
                return $role;
            }
        }

        throw new ACL_Exception('Role not found');
    }

    /**
     * Найти ресурс по его ID
     *
     * @param sting $resourceID
     * @return ACL_Resource
     */
    public function findResource($resourceID) {
        if (is_object($resourceID) && $resourceID instanceof ACL_IResource) {
            return $resourceID;
        }

        foreach ($this->_resourcesArray as $resource) {
            if ($resource->getACLID() == $resourceID) {
                return $resource;
            }
        }

        throw new ACL_Exception('Resource not found');
    }

    /**
     * @param string $roleID
     * @param mixed $parent
     * @return ACL_Role
     */
    public function addRole($roleID, $parent = false) {
        if (!$roleID) {
            throw new ACL_Exception('Incorrect roleID');
        }

        try {
            return $this->findRole($roleID);
        } catch (ACL_Exception $e) {

        }

        if ($parent !== false && $parent !== null) {
            if (is_object($parent)) {
                if ($parent instanceof ACL_IRole) {
                    // all ok!
                    // nothing do.
                } else {
                    throw new ACL_Exception('Parent role is not implements ACL_IRole');
                }
            } else {
                $parent = $this->findRole($parent);
            }
        }

        $role = new ACL_Role($roleID, $parent);
        $this->_rolesArray[$roleID] = $role;
        return $role;
    }

    /**
     * @param string $resourceID
     * @param mixed $parent
     * @return ACL_Resource
     */
    public function addResource($resourceID, $parent = false) {
        if (!$resourceID) {
            throw new ACL_Exception('Incorrect resourceID');
        }

        try {
            return $this->findResource($resourceID);
        } catch (ACL_Exception $e) {

        }

        if ($parent !== false && $parent !== null) {
            if (is_object($parent)) {
                if ($parent instanceof ACL_IResource) {
                    // all ok!
                    // nothing do.
                } else {
                    throw new ACL_Exception('Parent role is not implements ACL_IResource');
                }
            } else {
                $parent = $this->findResource($parent);
            }
        }

        $resource = new ACL_Resource($resourceID, $parent);
        $this->_resourcesArray[$resourceID] = $resource;
        return $resource;
    }

    /**
     * Разрешить доступ роли к ресурсу
     *
     * @param string $role
     * @param string $resource
     */
    public function allow($role, $resource) {
        $role = $this->findRole($role);
        $resource = $this->findResource($resource);
        $this->_acl->allow($role, $resource);
    }

    /**
     * Запретить роли доступ к ресурсу
     *
     * @param string $role
     * @param string $resource
     */
    public function deny($role, $resource) {
        $role = $this->findRole($role);
        $resource = $this->findResource($resource);
        $this->_acl->deny($role, $resource);
    }

    /**
     * Разрешен ли доступ к ресурсу?
     *
     * @param string $role
     * @param string $resource
     * @return bool
     */
    public function isAllowed($role, $resource) {
        $role = $this->findRole($role);
        $resource = $this->findResource($resource);
        return $this->_acl->isAllowed($role, $resource);
    }

    /**
     * Запрещен ли доступ к ресурсу?
     *
     * @param string $role
     * @param string $resource
     * @return bool
     */
    public function isDenied($role, $resource) {
        return !$this->isAllowed($role, $resource);
    }

}