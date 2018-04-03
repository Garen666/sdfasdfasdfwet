<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2012 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

if (class_exists('PackageLoader')) {
    PackageLoader::Get()->registerJSFile(dirname(__FILE__).'/jquery-1.8.2.min.js', true);
} else {
    throw new Exception("Cannot include this package without PackageLoader", 0);
}