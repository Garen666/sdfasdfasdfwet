<?php
/**
 * WebProduction Packages
 * @copyright (C) 2007-2012 WebProduction <webproduction.ua>
 *
 * This program is commercial software;
 * you can not distribute it and/or modify it.
 */

/**
 * LinkMaker - генератор ссылок
 *
 * @copyright WebProduction
 * @author Ramm
 * @author Max
 * @author DFox
 * @package Engine
 * @subpackage LinkMaker
 */
class Engine_LinkMaker extends Engine_ALinkMaker implements Engine_ILinkMaker {

    /**
     * Построить ссылку на контент с заданными параметрами
     *
     * @param mixed $contentID
     * @param array $paramsArray
     * @return string
     */
    public function makeURLByContentIDParams($contentID, $paramsArray) {
        // строим хеш
        $hash = 'url-'.md5($contentID.serialize($paramsArray));

        $data = Engine::GetContentDataSource()->getDataByID($contentID);
        if (!$data) {
            throw new Engine_Exception("Content #{$contentID} not found in ContentDataSource", 0);
        }

        $urlArray = $data['url'];

        // текущий язык движка
        $lang = Engine::Get()->getLanguage();
        if ($lang || !isset($paramsArray['engine-language'])) {
            $paramsArray['engine-language'] = $lang;
        }

        if (is_array($urlArray)) {
            // подбираем URL, который точно подходит под передаваемые параметры
            // иначе просто берем первый
            $url = '';
            foreach ($urlArray as $xurl) {
                $ok = true;
                if (preg_match_all("/\{(.*?)\}/is", $xurl, $r)) {
                    foreach ($r[1] as $rx) {
                        if (!array_key_exists($rx, $paramsArray)) {
                            $ok = false;
                            break;
                        }
                    }

                    if ($ok) {
                        $url = $xurl;
                        break;
                    }
                }
            }
            if (!$url) {
                $url = $urlArray[0];
            }
        } else {
            $url = $urlArray;
        }

        // по найденному URLу строим что надо
        if (count($paramsArray)) {
            $a = array();
            foreach ($paramsArray as $key => $value) {
                if (strpos($url, '{'.$key.'}') !== false) {
                    $url = str_replace('{'.$key.'}', $value, $url);
                    continue;
                }
                if ($key == 'engine-language') {
                    continue;
                }
                if (is_array($value)) {
                    foreach ($value as $val) $a[] = $key.'[]='.$val;
                } else $a[] = $key.'='.$value;
            }
            if ($a) {
                $url .= '?'.implode(self::_GetAmp(), $a);
            }
        }

        return $url;
    }

    /**
     * Построить ссылку на основе URL, дописав/переписав у него параметры
     *
     * @param string $url
     * @param array $paramsArray
     * @return string
     */
    public function makeURLByReplaceParams($url, $paramsArray) {
        // строим хеш
        $hash = 'replace-'.md5($url.serialize($paramsArray));

        $urlArray = explode('?', $url, 2);
        $gets = @$urlArray[1];
        parse_str($gets, $gets);

        $params = $paramsArray;

        if ($params) {
            foreach ($params as $k => $v) {
                $gets[$k] = $v;
            }
        }

        $url = array();
        if ($gets) {
            foreach ($gets as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $av) {
                        if (get_magic_quotes_gpc()) {
                            $av = stripslashes($av);
                        }
                        $av = urlencode($av);
                        $url[] = "{$k}[]={$av}";
                    }
                } else {
                    if (get_magic_quotes_gpc()) {
                        $v = stripslashes($v);
                    }
                    $v = urlencode($v);
                    $url[] = "$k=$v";
                }
            }
        }

        if ($url) {
            $result = $urlArray[0].'?'.implode(self::_GetAmp(), $url);
        } else {
            $result = $urlArray[0];
        }

        return $result;
    }

    private static function _GetAmp() {
        // @todo: возможно спрятать внутрь
        if (self::$_XHTML) {
            return '&amp;';
        } else {
            return '&';
        }
    }

    /**
     * Построить URL на основе готовой части URL'a.
     * Параметры однозначно дописываются в конец.
     * Все части {...} удаляются.
     *
     * @author Max
     * @param string $contentURL
     * @param mixed $value
     * @param mixed $key
     * @return string
     */
    public static function GetURLByContentURL($contentURL, $value = '', $key = 'id') {
        $contentURL = preg_replace("/\{(.*?)\}/is", '', $contentURL);
        $contentURL = str_replace('//', '/', $contentURL);
        if ($value) {
            $contentURL .= "?$key=$value";
        }
        return $contentURL;
    }

    /**
     * Получить LinkMaker
     *
     * @return Engine_LinkMaker
     */
    public static function Get() {
        if (!self::$_Instance) {
            self::$_Instance = new Engine_LinkMaker();
        }
        return self::$_Instance;
    }


    /**
     * Установить режим формирования ссылок в формате XHTML
     *
     * @param bool $mode
     */
    public static function SetModeXHTML($mode = true) {
        self::$_XHTML = $mode;
    }

    private function __construct() {
        // инициируем систему кеширования для LinkMaker'a,
        // по умолчанию обычный массв
        $this->_cache = Storage::Initialize(
        'engine-linkmaker',
        new Storage_HandlerArray()
        );
    }

    private static $_Instance = null;

    private static $_XHTML = true;

    /**
     * Система кеширования Engine
     *
     * @var Storage
     */
    private $_cache;

}