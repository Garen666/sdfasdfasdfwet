<?php
/**
 * WebProduction Packages
 * @copyright (C) 2007-2012 WebProduction <webproduction.ua>
 *
 * This program is commercial software;
 * you can not distribute it and/or modify it.
 */

/**
 * Smarty template engine for wpp Engine
 *
 * @todo rename to Engine_Template
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Engine
 * @subpackage Smarty
 */
class Engine_Smarty {

    /**
     * Через Smarty обработать файл и выдать html-код
     *
     * @param string $file
     * @param array $assignsArray
     * @return string
     */
    public function fetch($file, $assignsArray) {
        // @todo: может делать clone smarty?

        // @todo: возможны проблемы из-за сериализированных объектов?
        // возможно вообще запретить объекты в Smarty

        // строим хеш данных
        ksort($assignsArray);
        $hash = md5($file.serialize($assignsArray));

        // достаем Smarty и делаем обработку
        $this->getSmarty()->clear_all_assign();

        foreach ($assignsArray as $key => $value) {
            $this->getSmarty()->assign($key, $value);
        }

        $html = $this->getSmarty()->fetch($file);

        return $html;
    }

    /**
     * Получить объект шаблонизатора Smarty
     *
     * @return Smarty
     */
    public function getSmarty() {
        return $this->_smarty;
    }


    public function __construct() {
        // подключаем Smarty
        PackageLoader::Get()->import('Smarty');

        // инициируем Smarty внутри (аггрегация Smarty)
        $this->_smarty = new Smarty();
        $this->_smarty->compile_dir = dirname(__FILE__).'/compile/';

        // инициируем систему кеширования результатов
        // (по умолчанию обычный массив)
        // @todo: возможно заменить на файлы?
        $this->_cache = Storage::Initialize(
        'engine-smarty',
        new Storage_HandlerArray()
        );
    }

    /**
     * @var Smarty
     */
    private $_smarty = null;

    /**
     * @var Storage
     */
    private $_cache = null;

}