<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2010  WebProduction <webproduction.com.ua>
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
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

/**
 * Access Control List
 * (like Zend_ACL)
 *
 * ACL - абстрактный класс, который контроллирует доступ
 * абстрактных ролей к абстрактным ресурсам.
 *
 * Программист самостоятельно выстраивает обратное дерево (B-дерево)
 * всех ролей и ресурсов назначает им доступы друг к другу.
 *
 * Также есть упрощенная реализация ACL_Simple
 * @see ACL_Simple
 *
 * @package ACL
 * @copyright WebProduction
 * @author Max
 */
class ACL {

    private $_rules = array();

    /**
     * Разрешить доступ роли к ресурсу
     *
     * @param ACL_IRole $role
     * @param ACL_IResource $resource
     */
    public function allow(ACL_IRole $role, ACL_IResource $resource) {
        $this->_rules[$role->getACLID().'-'.$resource->getACLID()] = array(
        'role' => $role,
        'resource' => $resource,
        'type' => 'allow',
        );
    }

    /**
     * Запретить доступ роли к ресурсу
     *
     * @param ACL_IRole $role
     * @param ACL_IResource $resource
     */
    public function deny(ACL_IRole $role, ACL_IResource $resource) {
        $this->_rules[$role->getACLID().'-'.$resource->getACLID()] = array(
        'role' => $role,
        'resource' => $resource,
        'type' => 'deny',
        );
    }

    /**
     * Разрешен ли доступ роли к ресурсу?
     *
     * @param ACL_IRole $role
     * @param ACL_IResource $resource
     * @return bool
     */
    public function isAllowed(ACL_IRole $role, ACL_IResource $resource) {
        $currentRole = $role;
        $currentResource = $resource;

        while (1) {
            // ищем правило
            foreach ($this->_rules as $rule) {
                if ($rule['role'] === $currentRole && $rule['resource'] === $currentResource) {
                    return ($rule['type'] == 'allow');
                }
            }
            // правило явно не было найдено, поднимаем роль
            try {
                $currentRole = $currentRole->getACLParent();
            } catch (ACL_Exception $e) {
                // роль поднять не удалось, начинаем со стартовой роли и поднимаем ресурс
                try {
                    return $this->isAllowed($role, $resource->getACLParent());
                } catch (ACL_Exception $ee) {
                    // Eсли правила нет - это запрет или разрешение?
                    if ($this->_ruleMode == 'strict-allow') {
                    	return true;
                    }
                    if ($this->_ruleMode == 'strict-deny') {
                    	return false;
                    }
                    if ($this->_ruleMode == 'acl-exception') {
                    	throw new ACL_Exception('Rule not found');
                    }
                }
            }
        }
    }

    /**
     * Запрещен ли доступ роли к ресурсу?
     *
     * @param ACL_IRole $role
     * @param ACL_IResource $resource
     * @return bool
     */
    public function isDenied(ACL_IRole $role, ACL_IResource $resource) {
        return !$this->isAllowed($role, $resource);
    }

    private $_ruleMode = 'strict-allow';

    /**
     * Установить режим работы:
     * в случае, если правило не найдено - true
     */
    public function setRuleModeStrictAllow() {
    	$this->_ruleMode = 'strict-allow';
    }

    /**
     * Установить режим работы:
     * в случае, если правило не найдено - false
     */
    public function setRuleModeStrictDeny() {
    	$this->_ruleMode = 'strict-deny';
    }

    /**
     * Установить режим работы:
     * в случае, если правило не найдено - ACL_Exception
     * @see ACL_Exception
     */
    public function setRuleModeException() {
    	$this->_ruleMode = 'acl-exception';
    }

}