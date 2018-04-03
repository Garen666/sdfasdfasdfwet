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
 * unit-test класса ACL
 *
 * @author Max
 * @copyright WebProduction
 * @package ACL
 */
class Test_ACL extends TestKit_TestClass {

    public function setUp() {

    }

    public function testACL1() {
        // создаем дерево ролей
        $group1 = new ACL_Role('g1');
        $group2 = new ACL_Role('g2');
        $group3 = new ACL_Role('g3');
        $group4 = new ACL_Role('g4', $group3);
        $group5 = new ACL_Role('g5', $group4);
        $group6 = new ACL_Role('g6', $group4);

        // дерево ресурсов
        $resource1 = new ACL_Resource('r1');
        $resource2 = new ACL_Resource('r2');
        $resource3 = new ACL_Resource('r3', $resource2);
        $resource4 = new ACL_Resource('r4', $resource2);

        // список контроля доступа
        $acl = new ACL();
        $acl->allow($group1, $resource1);
        $acl->deny($group2, $resource1);
        $acl->deny($group3, $resource2);
        $acl->allow($group6, $resource3);

        $this->assertTrue($acl->isAllowed($group6, $resource3));
        $this->assertTrue($acl->isDenied($group6, $resource2));
        $this->assertTrue($acl->isDenied($group6, $resource4));
    }

    public function tearDown() {

    }

}