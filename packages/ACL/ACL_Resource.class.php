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
 * @package ACL
 * @author Max
 * @copyright WebProduction
 */
class ACL_Resource implements ACL_IResource {

    private $_aclID;
    private $_aclParent;

    public function __construct($id, $parentObject = null) {
        $this->_aclID = $id;
        if (is_object($parentObject)) {
        	if ($parentObject instanceof ACL_IResource) {
        		$this->_aclParent = $parentObject;
        	} else {
        	    throw new ACL_Exception('parent is not implements ACL_IResource');
        	}
        }
    }

    public function getACLID() {
        return $this->_aclID;
    }

    /**
     * @return ACL_Role
     */
    public function getACLParent() {
        if (!$this->_aclParent) {
            throw new ACL_Exception('No parent object found');
        }
        return $this->_aclParent;
    }

}