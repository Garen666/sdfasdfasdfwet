<?php
/**
 * WebProduction Packages. SQLObject.
 * Copyright (C) 2007-2012 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

interface SQLObject_IHandler {

    public function insert(SQLObject $object);

	public function delete(SQLObject $object);

	public function update(SQLObject $object);

	public function select(SQLObject $object);

	public function truncate(SQLObject $object);

}