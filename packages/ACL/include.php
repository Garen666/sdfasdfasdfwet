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

if (class_exists('PackageLoader')) {
    PackageLoader::Get()->registerPHPDirectory(dirname(__FILE__));
} else {
    include_once(dirname(__FILE__).'/ACL.class.php');
    include_once(dirname(__FILE__).'/ACL_IRole.class.php');
    include_once(dirname(__FILE__).'/ACL_Role.class.php');
    include_once(dirname(__FILE__).'/ACL_IResource.class.php');
    include_once(dirname(__FILE__).'/ACL_Resource.class.php');
    include_once(dirname(__FILE__).'/ACL_Exception.class.php');
    include_once(dirname(__FILE__).'/ACL_Simple.class.php');
}