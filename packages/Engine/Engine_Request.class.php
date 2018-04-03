<?php
/**
 * WebProduction Packages
 * @copyright (C) 2007-2013 WebProduction <webproduction.ua>
 *
 * This program is commercial software;
 * you can not distribute it and/or modify it.
 */

/**
 * Реализация класса работающего с запросом для древовидной структуры сайта
 *
 * @author DFox (idea)
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package Engine
 */
class Engine_Request {

    public function __construct() {
        // по умолчанию пытаемся поставить контент 404
        $this->setContentIDNotFound(404);
    }

    /**
     * Получить идентификатор контента,
     * который обрабатывает (собирается обрабатывать) Engine
     *
     * @return string
     */
    public function getContentID() {
        return $this->_contentID;
    }

    /**
     * Установить "контент 404" - перключить движок на 404ю страницу
     */
    public function setContentNotFound() {
        Engine::Get()->getResponse()->setHTTPStatus404();
        $this->setContentID($this->getContentIDNotFound());
    }

    /**
     * Получить contentID, который установится в случае
     * отсутствия подходящего контента
     *
     * @return string
     */
    public function getContentIDNotFound() {
        return $this->_contentID404;
    }

    /**
     * Установить contentID, который установится в случае
     * отсутствия подходящего контента
     *
     * @param string $contentID
     */
    public function setContentIDNotFound($contentID) {
        $this->_contentID404 = $contentID;
    }

    /**
     * Установить идентифиактор контента
     * (переключить движок на контент)
     * Вызов этого метода внутри работы -
     * по сути абсолютный редирект
     *
     * @param string $contentID
     */
    public function setContentID($contentID) {
        $this->_contentID = $contentID;
    }

    private function _callbackPregMatchURL($param, &$array, $return) {
        $param = trim($param);
        if (!$param) {
            throw new Engine_Exception("Empty param in match URL!");
        }
        $array[] = $param;
        return $return;
    }

    private $_contentURLIndex = '/index.html';

    /**
     * Задать URL index-страницы, который будет использован,
     * если запращивается страница /
     * По умолчанию /index.html
     *
     * @param string $url
     */
    public function setContentURLIndex($url) {
        $this->_contentURLIndex = $url;
    }

    /**
     * Получить URL, который будет считаться первым,
     * если будет запрошена страница /
     * По умолчанию /index.html
     *
     * @return string
     */
    public function getContentURLIndex() {
        return $this->_contentURLIndex;
    }

    /**
     * Задать GURL index-страницы который будет использован,
     * если запращивается страница /
     *
     * @param $gurl
     * @param array $params
     * @throw Engine_Exception
     */
    public function setContentGURLIndex($gurl, array $params = array()){
        $this->_contentURLIndex = Engine::GetLinkMaker()->makeURLByContentIDParams($gurl, $params);
    }

    /**
     * По переданному URL и аргументам определить ID контента, с которого
     * все начнется и записать его в _contentID
     *
     * @author DFox
     * @author Maxim Miroshnichenko <max@webproduction.com.ua>
     * @param string $url
     * @param array $args
     * @param bool $return Вернуть или записать в _contentID?
     * @return string
     */
    public function defineContentID($url, $args, $return = false) {
        if ($url == '/') {
            $url = $this->getContentURLIndex();
        }

        // перебираем все данные из источника
        $data = Engine::GetContentDataSource()->getData();
        foreach ($data as $a) {
            // получаем URL
            if (!$a['url']) continue;

            $urlsArray = $a['url'];
            if (!is_array($urlsArray)) {
                $urlsArray = array($urlsArray);
            }

            foreach ($urlsArray as $murl) {

                // так как preg-выражения долгие, то используем их только если на то есть повод
                $found = false;
                if (substr_count($murl, '{')) {
                    $urlParams = array();

                    // убираем из URL'a все необязательные параметры вида [*]
                    @$murl = preg_replace("/\[(.+?)\]/ise", '$this->_callbackPregMatchURL(\'$1\', &$urlParams, "(.*?)");', $murl);

                    // заменяем в URL'е все {*} конструкции на (.*?) и запоминаем порядок их следования
                    @$murl = preg_replace("/\{(.*?)\}/ise", '$this->_callbackPregMatchURL(\'$1\', $urlParams, "([^/]+?)");', $murl);
                    $murl = str_replace('/', '\/', $murl);
                    $murl = "/^{$murl}$/u";
                    // var_dump($murl);

                    if (preg_match($murl, $url, $r)) {
                        $found = true;

                        // url подошел - необходимо найти и создать все обязательные аргументы
                        foreach ($urlParams as $index => $name) {
                            if (isset($r[$index+1])) {
                                $value = $r[$index+1];

                                // var_dump($name); // - это может быть регулярное выражение
                                // var_dump($value); // - значение

                                if (substr_count($name, '{')) {
                                    $expression = "{$name}";
                                    // заменяем в URL'е все {*} конструкции на (.*?) и запоминаем порядок их следования
                                    $urlParams2 = array();
                                    $expression = preg_replace("/\{(.*?)\}/ise", '$this->_callbackPregMatchURL(\'$1\', &$urlParams2, "([^/]+?)");', $expression);
                                    $expression = str_replace('/', '\/', $expression);

                                    if (preg_match("/{$expression}/", $value, $rx)) {
                                        foreach ($urlParams2 as $index2 => $name2) {
                                            if (isset($rx[$index2+1])) {
                                                // print_r($name2);
                                                // var_dump($rx[$index2+1]);
                                                // добавляем агрумент в URLParser
                                                Engine::GetURLParser()->setArgument($name2, $rx[$index2+1]);
                                                // добавляем агрумент в $args // хотя скорее всего это и не нужно при правильном проектировании
                                                $args[$name2] = $rx[$index2+1];
                                            }
                                        }
                                    }
                                } else {
                                    // добавляем агрумент в URLParser
                                    Engine::GetURLParser()->setArgument($name, $value);
                                    // добавляем агрумент в $args
                                    $args[$name] = $value;
                                }
                            }
                        }
                    }
                } else {
                    // обычное сравнение
                    if ($murl == $url) {
                        $found = true;
                    }
                }

                if (!$found) continue;

                // проверяем агрументы
                $params_ok = true;
                $argumentsArray = $a['arguments'];
                foreach ($argumentsArray as $argname) {
                    if (!isset($args[$argname])) {
                        $params_ok = false;
                    }
                }

                if (!$params_ok) continue;

                if ($return) {
                    return $a['id'];
                }
                $this->setContentID($a['id']);
                return true;
            }
        }

        if ($return) {
            // @todo: exception?
            return false;
        }
        $this->setContentNotFound();
        return false;
    }

    private $_contentID;

    private $_contentID404 = 404;

}