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
 * unit-test класса ACL_Simple
 *
 * @author Max
 * @copyright WebProduction
 * @package ACL
 */
class Test_ACL_Simple extends TestKit_TestClass {

    public function setUp() {

    }

    public function testACLSimple1() {
        // тест на добавления

        $acl = new ACL_Simple();
        $acl->addRole('user1');
        $acl->addRole('user2');
        $acl->addRole('user3');
        $g1 = $acl->addRole('group1');
        $acl->addRole('user4', 'group1');
        $user5 = $acl->addRole('user5', $g1);

        $acl->addResource('r1');
        $r2 = $acl->addResource('r2', 'r1');

        $this->assertEquals('group1', $g1->getACLID());
        $this->assertEquals('group1', $user5->getACLParent()->getACLID());
        $this->assertEquals('r1', $r2->getACLParent()->getACLID());
    }

    public function testACLSimple2() {
        // тест на назначение прав

        $acl = new ACL_Simple();
        $acl->addRole('user1');
        $acl->addRole('user2');
        $acl->addRole('user3');
        $g1 = $acl->addRole('group1');
        $acl->addRole('user4', 'group1');
        $user5 = $acl->addRole('user5', $g1);

        $acl->addResource('r1');
        $acl->addResource('r3');
        $acl->addResource('rX');
        $r2 = $acl->addResource('r2', 'r1');

        $acl->allow('user1', 'r1');
        $acl->allow('user3', 'r1');
        $acl->deny('user1', 'r2');

        $this->assertTrue($acl->isAllowed('user1', 'r1'));
        $this->assertTrue($acl->isDenied('user1', 'r2'));
        $this->assertTrue($acl->isAllowed('user1', 'rX'));

        // ставим строгий режим
        $acl->getACL()->setRuleModeStrictDeny();
        $this->assertTrue($acl->isDenied('user1', 'rX'));
        $this->assertTrue($acl->isDenied('user3', 'rX'));
        $this->assertTrue($acl->isDenied('user3', 'r3'));
        $this->assertTrue($acl->isAllowed('user3', 'r2'));
    }

    public function tearDown() {

    }

}