<?php
/**
 * WebProduction Shop (wpshop)
 * @copyright (C) 2011-2014 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class ShopFile extends XShopFile {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopFile
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return ShopFile
     */
    public static function Get($key) {
        return self::GetObject('ShopFile', $key);
    }

    /**
     * Построить имя события
     *
     * @return string
     */
    public function makeName() {
        return htmlspecialchars($this->getName());
    }

    /**
     * Получить размер файла
     *
     * @return string
     */
    public function makeSize() {
        $filePath = PackageLoader::Get()->getProjectPath().'media/file/'.$this->getFile();
        $size = @filesize($filePath);
        if (!$size) {
            return false;
        }
        if ($size < 1024) {
            return $size.'b';
        }
        if ($size < 1024*1024) {
            return round($size / 1024).'K';
        }
        if ($size < 1024*1024*1024) {
            return round($size / 1024 / 1024).'M';
        }
        return 0;
    }

    /**
     * @return string
     */
    public function makeURL() {
        return Engine::GetLinkMaker()->makeURLByContentIDParam(
        'file-download',
        $this->getId()
        );
    }

}